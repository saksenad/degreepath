{extends file="layout.tpl"}
{block name=nav_options}
	<li id="loggedin" class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$userInfo['first_name']} <b class="caret"></b></a>
		<ul class="dropdown-menu">
				<li><a href="schedule.php">My Degree Plan</a></li>
				<li class="divider"></li>
				<li><a href="home.php" onclick="logout()">Log-out</a></li>
		</ul>
	</li>
{/block}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <!-- start: Row -->
			<div class="row">

        <!-- start: Profile Section -->
				<div id="profile" class="span5">
 
				  <!-- start: Profile Info-->
					<div id="profile-form">

					  <h2>{$userInfo['first_name']} {$userInfo['last_name']}</h2>

            <br/>
            <form method="post" action="../api/users/update">

						  <label for="major"><span>Major:</span></label>
						  <select class="form-control" name="major">
                <option value="" selected>{$userInfo['major']}</option>
                {foreach $departments as $dept}
                	<option value={$dept}>{$dept}</option>
                {/foreach}
              </select>

						  <label for="minor"><span>Minor:</span></label>
						  <select class="form-control" name="minor">
                <option value="" selected>{$userInfo['minor']}</option>
                {foreach $departments as $dept}
                	<option value={$dept}>{$dept}</option>
                {/foreach}
              </select>
           
          </div>
          <!-- end: Profile Info -->	

				  <!-- start: Account Info -->	
          <div id="account">
            
					    <h3>Account Information</h3>
              <br/>

						  <label for="email">Email address:</label>
						  <input id="email" name="email" type="text" value={$userInfo['email']}>

					    <label for="firstname"><span>First Name:</span></label>
					    <input id="firstname" name="firstname" type="text" value={$userInfo['first_name']}>

						  <label for="lastname"><span>Last Name:</span></label>
              <input id="lastname" name="lastname" type="text" value={$userInfo['last_name']}>

							<label for="username"><span>Username:</span></label>
							<input id="username" name="username" type="text" value={$userInfo['username']}>

							<input type="submit" value="Update Information">

				    </form>
          </div>
				  <!-- end: Account Info -->	

        <!-- end: Profile Section -->
        </div>

				<!-- start: Transfer Info-->
				<div id="transfer" class="span5">	

          <h2>AP/Transfer Credits</h2>
          <br/>
          <p>
            For more accurate information about prerequisites and requirements to graduate,
            please enter any courses that you already have credit for from another institution
            of from AP/IB courses.
          </p>
          <br/>

          <!-- start: Accordian -->
          <!-- end: Accordian -->

          <!-- start: Transfer Credit Bucket -->
          <div>
              <div id="bucket" class="color-cccddd">
                <ul class="pending connectedSortable" data-term="000000"> 
                  {foreach $transfers as $course}
	                  <li class="ui-state-default" data-cid={$course['id']}>{$course['subject']} {$course['course_number']}</li>  
                  {/foreach}
                </ul>
              </div>
          </div>
          <!-- end: Transfer Credit Bucket -->

				</div>
				<!-- end: Tranfer Info -->	

			</div>
			<!-- end: Row -->

  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>
	
{/block}
