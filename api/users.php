<?php 

require_once 'api/prefix.php';

session_start();

$app->post("/users", function() use ($app) {

	sanitizeInput($_POST);

	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $major = $_POST['major'];

	createUser($username, $email, $password, $first_name, $last_name, $major);

  $app->redirect("../login.php");
});

/*User can update their information*/
$app->post("/users/update", function() use ($app) {

	$username = $_POST['username'];
	$email = $_POST['email'];
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$major = $_POST['major'];
	$minor = $_POST['minor'];
	$uid = $_SESSION['user_id'];

	updateUserInfo($uid,$username,$email,$firstName,$lastName,$major,$minor);

  $app->redirect("/");
});

$app->delete("/users", function() {
	// Put input into a sensible array, like how POST requests work
	$_DELETE = array();
	parse_str(file_get_contents('php://input'), $_DELETE);
	
	error_log($_DELETE);

	sanitizeInput($_DELETE);

	$username = $_DELETE['username'];
	$password = $_DELETE['password'];


	removeUser($username, $password);
});

$app->get("/user", function() use ($app) {
	global $_SESSION;
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['username'];

	echo json_encode(array(
		"username" => $username,
		"user_id" => $user_id
	));

  $app->redirect("schedule.php");
});

$app->post("/user", function() {
	sanitizeInput($_POST);

	$username = $_POST['username'];
	$password = $_POST['password'];

	$uid = user_id($username, $password);
	if ($uid == -1) {
		echo "did not log you in";
		return;
	} else {
		global $_SESSION;
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $uid;
	}
});

$app->delete("/user", function() {
	global $_SESSION;

	$_SESSION['username'] = null;
	$_SESSION['user_id'] = null;
});

function createUser($username, $email, $password, $first_name, $last_name, $major) {
	global $conn;

	$query = sprintf("INSERT INTO users(username, email, password, first_name, last_name, major) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", 
		$username, $email, checksum($username, $password), $first_name, $last_name, $major);
	mysqli_query($conn, $query) or die("query: " . $query . " failed. " . mysqli_error($conn));

  $user_id = mysqli_insert_id($conn);

  $query = sprintf("INSERT INTO user_subjects(user_id, subject) VALUES ('%s', '%s')", $user_id, $major);
	mysqli_query($conn, $query) or die("query: " . $query . " failed. " . mysqli_error($conn));


	echo json_encode(array(
		"username" => $username,
		"uid" => $user_id
	));
}

function removeUser($username, $password) {
	global $conn;

	// First, need the user_id
	$user_id = user_id($username, $password);
	if ($user_id == -1) {
		echo json_encode(array(
			"result" => $user_id
		));
	}

	// Delete that user from the database, and return the user_id to show a successful delete
	$query = sprintf("DELETE FROM users WHERE id = %d", $user_id);
	mysqli_query($conn, $query);
	echo json_encode(array(
		"result" => $user_id
	));
}

function user_id($username, $password) {	
	global $conn;
	$query = sprintf("SELECT id,password
					  FROM users 
					  WHERE username = '%s'", 
		$username, checksum($username, $password));

	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));

	if (!$result)  {
		echo "Didn't find anything in the database";
		return -1;
	}

	$row = mysqli_fetch_assoc($result);
	$stored_pass = $row['password'];

	if (crypt_verify($username, $password, $stored_pass)) {
		return $row['id'];
	} else {
		return -1;
	}
}

function sanitizeInput($_ARRAY) {
	$username = $_ARRAY['username'];
	$password = $_ARRAY['password'];
	if (array_key_exists('email', $_ARRAY))
		$email = $_ARRAY['email'];

	$s_username = filter_var($username, FILTER_SANITIZE_STRING);
	$s_pass = filter_var($password, FILTER_SANITIZE_STRING);
	if (array_key_exists('email', $_ARRAY))
		$s_email = filter_var($email, FILTER_SANITIZE_EMAIL);

	$_ARRAY['username'] = $s_username;
	$_ARRAY['password'] = $s_pass;
	if (array_key_exists('email', $_ARRAY))
		$_ARRAY['email'] = $s_email;
}


function checksum($username, $password) {
	$c_input = $username . "____" . $password;
	$checksum = crypt($c_input);
	return $checksum;
}

function crypt_verify($username, $password, $hash) {
	$c_input = $username . "____" . $password;
	return (crypt($c_input, $hash) == $hash);
}




/* Methods for getting assets owned by a user */

$app->get("/users/semesters", function() {
  $user_id = $_SESSION['user_id'];
	return json_encode(semestersForUser($user_id));
});

$app->post("/users/semesters", function() {
  $user_id = $_SESSION['user_id'];
	addUserSemester($user_id, $_POST['term_code']);
});

$app->delete("/users/semesters/:term_code", function($term_code) {
  $user_id = $_SESSION['user_id'];
	removeUserSemester($user_id, $term_code);
});

$app->get("/users/subjects", function() {
  $user_id = $_SESSION['user_id'];
	return json_encode(subjectsForUser($user_id));
});

$app->post("/users/subjects", function() {
  $user_id = $_SESSION['user_id'];
	addUserSubject($user_id, $_POST['subject']);
});

$app->delete("/users/subjects/:subject", function($subject) {
  $user_id = $_SESSION['user_id'];
	removeUserSubject($user_id, $subject);
});


function addUserSemester($user_id, $term_code) {
	global $conn;
	$query = sprintf("INSERT INTO user_semesters (user_id, term_code)
			  VALUES (%d, %d)", $user_id, $term_code);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function removeUserSemester($user_id, $term_code) {
	global $conn; 
	$query = sprintf("DELETE FROM user_semesters WHERE user_id = %d AND term_code = %d", $user_id, $term_code);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function semestersForUser($user_id) {
	global $conn; 
	$query = sprintf("SELECT term_code FROM user_semesters WHERE user_id = %d", $user_id);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
	$semesters = array();
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($semesters, $row['term_code']);
      }  
    }
	return $semesters;
}

function addUserSubject($user_id, $subject) {
	global $conn;
	$query = sprintf("INSERT INTO user_subjects (user_id, subject)
			  VALUES (%d, '%s')", $user_id, $subject);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function removeUserSubject($user_id, $subject) {
	global $conn; 
	$query = sprintf("DELETE FROM user_subjects WHERE user_id = %d AND subject = '%s'", $user_id, $subject);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function subjectsForUser($user_id) {
	global $conn; 
	$query = sprintf("SELECT subject FROM user_subjects WHERE user_id = %d", $user_id);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
	$subjects = array();
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($subjects, $row['subject']);
      }  
    }
	return $subjects;
}

function getUserInfo($user_id) {
  global $conn;
	$query = sprintf("SELECT username, email, first_name, last_name, major, minor
					  FROM users 
					  WHERE id = '%s'", 
		$user_id);

	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
  return $row;
}

function updateUserInfo($uid,$username,$email,$firstName,$lastName,$major,$minor) {

	global $conn; 
	$query = sprintf("UPDATE `users` 
					SET `first_name`='%s',`last_name`='%s',`major`='%s',`minor`='%s',`username`='%s',`email`='%s'
				WHERE id=%d;",$firstName,$lastName,$major,$minor,$username,$email,$uid);

	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
	return $result;

}
/* End of methods for getting semesters associated with a user */
?>
