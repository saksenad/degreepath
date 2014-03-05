function requestDelete() {
	console.log("requesting delete");
	var name = document.getElementById("delete_username").value;
	var pass = document.getElementById("delete_password").value;
	console.log(name);
	console.log(pass);
	$.ajax({
		type: "DELETE",
		url: "api/users",
		data:
		{
			username: name,
			password: pass
		},
		success: function(message) {
			console.log(message);
		}
	});
}

function logout() {
	$.ajax({
		type: "DELETE",
		url: "api/user",
	});
}