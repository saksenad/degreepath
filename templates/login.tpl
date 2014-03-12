{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <h3>Create an Account</h3>
	  <form action="api/users" method="POST">
	    Username: <input type="text" name="username"><br />
	    Email: <input type="text" name="email"><br />
	    Password: <input type="password" name="password"> <br />
	    <input type="submit">
	  </form>


	  <h3>Delete Your Account</h3>
	  <form onsubmit="requestDelete()">
	    Username <input type="text" id="delete_username" /> <br /> 
	    Password: <input type="password" id="delete_password"> <br />
	    <input type="submit">
	  </form>

	  <h3>Login To Your Account</h3>
	  <form onsubmit="login();">
	    Username: <input type="text" id="login_username"><br />
	    Password: <input type="password" id="login_password"> <br />
	    <input type="submit">
	  </form>

	  <form onsubmit="logout();">
	    <input type="submit" value="Logout">
	  </form>

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>

{/block}
