{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <h3 id="create-account-header">Create an Account</h3>
	  <form action="api/users" method="POST">
      <label for="first_name">First Name:</label>
      <input id="first_name" type="text" name="first_name"><br />

      <label for="last_name">Last Name:</label>
      <input id="last_name" type="text" name="last_name"><br />

      <label for="major">Major:</label>
      <select id ="major">
        <option value="CHEM">Chemistry</option>
        <option value="CS">Computer Science</option>
        <option value="ACCT">Accounting</option>
      </select><br />

	    <label for="username">Username:</label>
      <input id="username" type="text" name="username"><br />

	    <label for="email">Email:</label>
      <input type="text" name="email"><br />

	    <label for="password">Password:</label>
      <input type="password" name="password"> <br />

	    <input type="submit">
	  </form>

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>

{/block}
