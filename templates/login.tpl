{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <h3 id="login-header">Login To Your Account</h3>
	  <form id="login-form" onsubmit="login();">
	    <label for="username">Username:</label>
      <input type="text" id="login_username"><br />
	    
      <label for="password:">Password:</label>
      <input type="password" id="login_password"> <br />
	    
      <input type="submit"value="Login">
	  </form>

    <!--
	  <h3>Delete Your Account</h3>
	  <form onsubmit="requestDelete()">
	    Username <input type="text" id="delete_username" /> <br /> 
	    Password: <input type="password" id="delete_password"> <br />
	    <input type="submit" value="Delete Account">
	  </form>

	  <form onsubmit="logout();">
	    <input type="submit" value="Logout">
	  </form>

    -->

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>

{/block}
