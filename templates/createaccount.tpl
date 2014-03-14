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

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>

{/block}
