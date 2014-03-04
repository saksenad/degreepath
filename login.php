<html>

Create an Account
<form action="api/users" method="POST">
Username: <input type="text" name="username"><br />
Email: <input type="text" name="email"><br />
Password: <input type="password" name="pass"> <br />
<input type="submit">
</form>


Delete Your Account
<form onsubmit="requestDelete()">
Usermame <input type="text" id="delete_username" /> <br /> 
Password: <input type="password" id="delete_password"> <br />
<input type="submit">
</form>


<script>

function requestDelete() {
	var name = document.getElementById("delete_username").value;
	var pass = document.getElementById("delete_password").value;
	console.log("requesting delete");
	$.ajax({
		type: "DELETE",
		url: "api/users",
		data:
		{
			name: username,
			password: pass
		},
		success: function(message) {
			console.log(message);
		}
	});
}

</script>

</html>
