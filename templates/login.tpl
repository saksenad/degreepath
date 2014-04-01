{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <h3 id="login-header">Login To Your Account</h3>
	  <form id="login-form" onsubmit="login();">
	    <label for="login_username">Username:</label>
      <input type="text" id="login_username"><br />
	    
      <label for="login_password:">Password:</label>
      <input type="password" id="login_password"> <br />
	    
      <input type="submit" value="Login">
	  </form>

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>

{/block}
