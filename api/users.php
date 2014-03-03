<?php 

require_once 'api/prefix.php';
$_DELETE = array();
$app = \Slim\Slim::getInstance();


$app->post("/user", function() {
	$username = $_POST['username'];
	$password = $_POST['pass'];
	$email = $_POST['email'];

	createUser($username, $email, $password);
});

$app->delete("/user/", function() {
	global $_DELETE;
	$_DELETE = array();
	parse_str(file_get_contents('php://input'), $_DELETE);
	
	$username = $_DELETE['username'];
	$password = $_PASSWORD['password'];

	removeUser($username, $password);
});

function createUser($username, $email, $password) {
	global $conn;

	// TODO:
	// Input escaping, and "sanitizing"
	// Password hashing
	// Possible security enhancements in the future

	$query = sprintf("INSERT INTO users(name, email, password) VALUES ('%s', '%s', '%s')", $username, $email, $password);
	mysqli_query($conn, $query) or die("query: ".$query." failed. " . mysql_error());

	echo json_encode(array(
		"username" => $username,
		"uid" => mysqli_insert_id($conn)
	));
}

function removeUser($uid) {
	// TODO: password authentication

	$query = sprintf("DELETE FROM users WHERE id == %d", $user_id);
	mysqli_query($conn, $query) or die("query: ".$query." failed. " . mysql_error());
}


?>