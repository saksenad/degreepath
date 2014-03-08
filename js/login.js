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
	var name = document.getElementById("login_username").value;
	var pass = document.getElementById("login_password").value;
	$.ajax({
		type: "POST",
		url: "api/user",
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