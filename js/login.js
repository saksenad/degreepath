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
