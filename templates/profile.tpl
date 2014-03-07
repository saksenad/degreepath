{extends file="layout.tpl"}
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
					  <h2>Naomi Robert</h2>
            <br/>

						<form method="post" action="">

							<fieldset>
								<div class="clearfix">
									<label for="major"><span>Major:</span></label>
									<div class="input">
										<select class="form-control">
                      <option value="" disabled selected>Choose a major</option>
                      <option value="ae">Aerospace Engineering</option>
                      <option value="cs">Computer Science</option>
                      <option value="psyc">Psychology</option>
                    </select>
									</div>
								</div>

								<div class="clearfix">
									<label for="minor"><span>Minor:</span></label>
									<div class="input">
										<select class="form-control">
                      <option value="" selected>No minor</option>
                      <option value="ae">Aerospace Engineering</option>
                      <option value="cs">Computer Science</option>
                      <option value="psyc">Psychology</option>
                    </select>
									</div>
								</div>

							</fieldset>

						</form>
					</div>
          <!-- end: Profile Info -->	

				  <!-- start: Account Info -->	
          <div id="account">
            <div id="account-form">
					    <h3>Account Information</h3>
              <br/>

						  <form method="post" action="">
							  <fieldset>
								  <div class="clearfix">
									  <label for="email"><span>Email address:</span></label>
									  <div class="input">
										  <input tabindex="2" size="25" id="email" name="email" type="text" value="" class="input-xlarge">
									  </div>
								  </div>

                  <div class="clearfix">
									  <label for="name"><span>Password:</span></label>
									  <div class="input">
										  <input tabindex="1" size="18" id="password" name="password" type="text" value="">
									  </div>
								  </div>
					    </fieldset>
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
                  <li class="ui-state-default">CS 1301</li>
                  <li class="ui-state-default">PSYC 1101</li>
                  <li class="ui-state-default">HIST 2211</li>
                  <li class="ui-state-default">PHYS 2112</li>  
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
