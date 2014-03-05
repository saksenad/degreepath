{extends file="layout.tpl"}
{block name=body}
	Create an Account
	<form action="api/users" method="POST">
	Username: <input type="text" name="username"><br />
	Email: <input type="text" name="email"><br />
	Password: <input type="password" name="password"> <br />
	<input type="submit">
	</form>


	Delete Your Account
	<form onsubmit="requestDelete()">
	Usermame <input type="text" id="delete_username" /> <br /> 
	Password: <input type="password" id="delete_password"> <br />
	<input type="submit">
	</form>

	Login To Your Account
	<form action="api/user" method="POST">
	Username: <input type="text" name="username"><br />
	Password: <input type="password" name="password"> <br />
	<input type="submit">
	</form>

	<form onsubmit="logout()">
	<input type="submit" value="Logout">
	</form>
	
{/block}