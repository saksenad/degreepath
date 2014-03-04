<?php 

require_once 'api/prefix.php';
$app = \Slim\Slim::getInstance();


$app->post("/users", function() {
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$email = $_POST['email'];

	createUser($username, $email, $password);
});

$app->delete("/users", function() {
	// Put input into a sensible array, like how POST requests work
	$_DELETE = array();
	parse_str(file_get_contents('php://input'), $_DELETE);
	
	$username = $_DELETE['username'];
	$password = $_DELETE['password'];

	removeUser($username, $password);
});

function createUser($username, $email, $password) {
	global $conn;


	// Clean up the input provided from the user before hashing and storing
	sanitizeInput();

	$query = sprintf("INSERT INTO users(name, email, password) VALUES ('%s', '%s', '%s')", 
		$username, $email, checksum($username, $password));
	mysqli_query($conn, $query) or die("query: ".$query." failed. " . mysql_error());

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

	// Delete that user from the database, and return the user_id to show a successful delete=
	$query = sprintf("DELETE FROM users WHERE id == %d", $user_id);
	mysqli_query($conn, $query);
	echo json_encode(array(
		"result" => $user_id
	));
}

function user_id($username, $password) {	
	global $conn;
	$query = sprintf("SELECT id FROM users WHERE name == '%s' AND password == '%s'", 
		$username, checksum($username, $password));

	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) != 1) {
		return -1;
	}

	$row = mysqli_fetch_assoc($result);

	return $row['id'];
}

function sanitizeInput() {
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$email = $_POST['email'];

	$s_username = filter_var($username, FILTER_SANITIZE_STRING);
	$s_pass = filter_var($password, FILTER_SANITIZE_STRING);
	$s_email = filter_var($email, FILTER_SANITIZE_EMAIL);
}


function checksum($username, $password) {
	$c_input = $username . "____" . $password;
	$checksum = password_hash($c_input, PASSWORD_BCRYPT);
	return $checksum;
}

?>