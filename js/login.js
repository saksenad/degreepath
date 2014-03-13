function requestDelete() {
	var name = document.getElementById("delete_username").value;
	var pass = document.getElementById("delete_password").value;
	$.ajax({
		type: "DELETE",
		url: "api/users",
		data:
		{
			username: name,
			password: pass
		}
	});
}

function login() {
	console.log("calling login properly");


/*
<li id="loggedin" class="dropdown">
			                  			<a href="#" class="dropdown-toggle" data-toggle="dropdown">George P. Burdell <b class="caret"></b></a>
			                  			<ul class="dropdown-menu">
			                    				<li><a href="profile.php">My Account</a></li>
			                    				<li class="divider"></li>
			                    				<li><a href="login.php">Log-in</a></li>
			                    				<li><a href="home.php" onclick="logout()">Log-out</a></li>
			                  			</ul>
			                			</li>**/

	var name = document.getElementById("login_username").value;
	var pass = document.getElementById("login_password").value;
	$.ajax({
		type: "POST",
		url: "api/user",
		async: false,
		data:
		{
			username: name,
			password: pass,
		}
	});
}


function logout() {
	$.ajax({
		type: "DELETE",
		url: "api/user",
	});
}
