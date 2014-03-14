{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <h3>Login To Your Account</h3>
	  <form onsubmit="login();">
	    Username: <input type="text" id="login_username"><br />
	    Password: <input type="password" id="login_password"> <br />
	    <input type="submit" value="Login">
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
