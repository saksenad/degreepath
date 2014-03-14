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

					  <h2>{$userDisplayName}</h2>

            <br/>
            				<form method="post" action="../api/users/update">

							<fieldset>
								<div class="clearfix">
									<label for="major"><span>Major:</span></label>
									<div class="input">
										<select class="form-control" name="major">
					                      <option value="" disabled selected>Choose new major</option>
					                      {foreach $departments as $dept}
					                      	<option value={$dept}>{$dept}</option>
					                      {/foreach}
					                    </select>
									</div>
								</div>

								<div class="clearfix">
									<label for="minor"><span>Minor:</span></label>
									<div class="input">
										<select class="form-control" name="minor">
					                      <option value="" disabled selected>No minor</option>
					                      {foreach $departments as $dept}
					                      	<option value={$dept}>{$dept}</option>
					                      {/foreach}
					                    </select>
									</div>
								</div>

							</fieldset>

						
					</div>
          <!-- end: Profile Info -->	

				  <!-- start: Account Info -->	
          <div id="account">
            <div id="account-form">
					    <h3>Account Information</h3>
              <br/>

						  
							  <fieldset>
								  <div class="clearfix">
									  <label for="email">Email address:</label>
									  <div class="input">

										  <input tabindex="2" size="25" id="email" name="email" type="text" value={$userArray['email']} class="input-xlarge">
									  </div>
								  </div>

                  					<div class="clearfix">
									  <label for="firstname"><span>First Name</span></label>
									  <div class="input">
										  <input tabindex="1" size="18" id="firstname" name="firstname" type="text" value={$userArray['first_name']}>
									  </div>
								  	</div>

								  <div class="clearfix">
									  <label for="lastname"><span>Last Name</span></label>

									  <div class="input">
										  <input tabindex="2" size="25" id="lastname" name="lastname" type="text" value={$userArray['last_name']} class="input-xlarge">
									  </div>
								  </div>

								  <div class="clearfix">
									  <label for="username"><span>Username</span></label>
									  <div class="input">
										  <input tabindex="2" size="25" id="username" name="username" type="text" value={$userArray['username']} class="input-xlarge">
									  </div>
								  </div>

								  <input type="submit" value="Update Information">
					    </fieldset>

              <input type="submit">
				    </form>

				  </div>
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
                <ul id="pending" class="connectedSortable" data-term="000000"> 
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
