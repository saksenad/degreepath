{extends file="layout.tpl"}
{block name=body}

<!--start: Wrapper-->
<div id="wrapper">
			
	<!--start: Container -->
  <div class="container">

	  <!-- start: Row -->
			<div class="row">
			
				<!-- start: Profile Info-->
				<div class="span4">
					<div class="title"><h2>Naomi Robert</h2></div>
 
					<div id="contact-form">

						<form method="post" action="">

							<fieldset>
								<div class="clearfix">
									<label for="name"><span>Major:</span></label>
									<div class="input">
										<input tabindex="1" size="18" id="major" name="major" type="text" value="">
									</div>
								</div>

								<div class="clearfix">
									<label for="email"><span>Minor:</span></label>
									<div class="input">
										<input tabindex="2" size="25" id="minor" name="minor" type="text" value="" class="input-xlarge">
									</div>
								</div>

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
				<!-- end: Profile Info -->		

			</div>
			<!-- end: Row -->


  <!--end: Wrapper-->
  </div>
			
<!--end: Container -->
</div>
	
{/block}
