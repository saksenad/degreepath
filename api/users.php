<?php 

require_once 'api/prefix.php';

session_start();


function get_http_body_values($_ARRAY) {
	/* DELETE and PUT data comes in on the stdin stream */

	$bodyData = fopen("php://input", "r") or die("fuck this project");
	if (!$bodyData) {
		error_log("did not get any data, or could not open input");
	}

	$bodyString = "";
	/* Read data from input stream */
	while ($data = fread($bodyData, 1024)) {
		error_log("got data ". $data);
		$bodyString = $bodyString . $data;
	}

	error_log("data from request", $bodyString);
	parse_str($bodyString, $_ARRAY);

	/* Close stream */
	fclose($bodyData);
}

$app->post("/users", function() {
	sanitizeInput($_POST);

	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	createUser($username, $email, $password);
});

$app->put("/users", function() {
	// Put input into a sensible array, like how POST requests work
	error_log("calling users");
	$_DELETE = array();
	get_http_body_values($_DELETE);

	error_log($_DELETE);
	sanitizeInput($_DELETE);

	$username = $_DELETE['username'];
	$password = $_DELETE['password'];

	error_log("trying to remove user: ". $username . " pass : ". $password);

	removeUser($username, $password);
});

$app->get("/user", function() {
	global $_SESSION;
	$user_id = $_SESSION['user_id'];
	$username = $_SESSION['username'];

	echo json_encode(array(
		"username" => $username,
		"user_id" => $user_id
	));
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

function createUser($username, $email, $password) {
	global $conn;

	$query = sprintf("INSERT INTO users(username, email, password) VALUES ('%s', '%s', '%s')", 
		$username, $email, checksum($username, $password));
	mysqli_query($conn, $query) or die("query: " . $query . " failed. " . mysqli_error($conn));

	echo json_encode(array(
		"username" => $username,
		"uid" => mysqli_insert_id($conn)
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
	error_log("trying to remove user with user_id ". $user_id);
	// Delete that user from the database, and return the user_id to show a successful delete
	$query = sprintf("DELETE FROM users WHERE id = %d", $user_id);
	mysqli_query($conn, $query) or die("could not remove user");
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

$app->get("/users/:id/semesters", function($user_id) {
	return json_encode(semestersForUser($user_id));
});

$app->post("/users/:id/semesters", function($user_id) {
	addUserSemester($user_id, $_POST['term_code']);
});

$app->delete("/users/:id/:term_code", function($user_id, $term_code) {
	removeUserSemester($user_id, $term_code);
});


function addUserSemester($user_id, $term_code) {
	global $conn;
	$query = sprintf("INSERT INTO user_semesters (user_id, term_code)
			  VALUES (%d, %d)", $user_id, $term_code);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function removeUserSemester($user_id, $term_code) {
	global $conn; 
	$query = sprintf("DELETE FROM user_semesters WHERE user_id = %d", $user_id);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
}

function semestersForUser($user_id) {
	global $conn; 
	$query = sprintf("SELECT term_code FROM user_semesters WHERE user_id = %d", $user_id);
	$result = mysqli_query($conn, $query) or die("Query: " . $query . "error" .  mysqli_error($conn));
	$semesters = mysql_fetch_array($result);
	return $semesters;
}

/* End of methods for getting semesters associated with a user */





?>
