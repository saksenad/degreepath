{extends file="layout.tpl"}
{block name=nav_options}
	<li id="loggedin" class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$userInfo['first_name']} <b class="caret"></b></a>
		<ul class="dropdown-menu">
				<li><a href="profile.php">My Account</a></li>
				<li class="divider"></li>
				<li><a href="home.php" onclick="logout()">Log-out</a></li>
		</ul>
	</li>
{/block}
{block name=body}
  
<!-- start: Wrapper -->
<div id="wrapper">

  <!-- start: Container -->
  <div class="container">

    <!-- start: Row -->
    <div class="row">

      <!-- start: Accordian -->
      <div id="courses" class="span2">
        <div id="accordion">

            {foreach $user_subjects as $user_subject}          
              <h3>
                <span class="subject">{$user_subject}</span>
                <img class="remove-subject" src="/img/icons/x.png"></img> 
              </h3>
              {assign var='courses' value=getCourses($user_subject)}
              <div id="accordionWrapper" class="color-cccddd">
                <ul class="pending connectedSortable" data-term="999999">    
                  {foreach $courses as $course}
                    <li data-cid={$course['id']} data-credits={$course['credit_hours']} data-gpa={$course['GPA']}>{$course['subject']} {$course['course_number']}</li>
                  {/foreach}
                </ul>
              </div>
            {/foreach}

        </div>
      
        <div id="addDept">
            <select id="deptDropDown">
              {foreach $departments as $dept} 
              <option value={$dept}>{$dept}</option>
              {/foreach}
            </select>
            <button id="deptButton">Add</button>
        </div>

      </div>
      <!-- end: Accordian -->

      <!-- start: Table -->
      <div id="table" class="span10">

        <!-- start: Row -->
    		<div class="row" id="semester-buckets">

        {foreach $terms as $term}
      		<div class="span3">
            <div id="semester" class="color-cccddd bucket">
              {assign var='credits' value=0}
              {assign var='points' value=0}
              <h3 id="semester-header" align="center">
                {$season[substr($term,4,2)]} {substr($term,0,4)}
                <img class="remove-semester" src="/img/icons/x.png"></img>              
              </h3>
              <ul class="sortable connectedSortable" data-term={$term}>
                {if array_key_exists($term, $enrollments)}
                  {foreach $enrollments[$term] as $enrollment}
                    {if $enrollment}
                      {assign var='credits' value=$credits+$enrollment['credit_hours']}
                      {assign var='points'  value=$points+$enrollment['credit_hours']*$enrollment['GPA']}
                      {assign var='preReqResult' value='preReqFailed'}
                      {if $enrollment['PreReqSatisfied']==1}
                        {assign var='preReqResult' value='preReqPassed'}
                      {/if}
                      {assign var='cssClasses' value=$preReqResult|cat:" "|cat:"ui-state-default"}
                      <li class="{$cssClasses}" data-cid={$enrollment['id']} data-credits={$enrollment['credit_hours']} data-gpa={$enrollment['GPA']}>
                        <div class="course-title">{$enrollment['subject']} {$enrollment['course_number']} - {$enrollment['name']}</div>
                        <img class="remove" src="/img/icons/x.png"></img>
                      </li>
                    {/if}
                  {/foreach}
                  
                  {if $credits != 0}
                    {assign var='avg_gpa' value=$points/$credits}
                  {else}
                    {assign var='avg_gpa' value=0}
                  {/if}
                {/if}
              </ul>
              <h5 class="pull-right" style="margin-right:10px">{number_format($avg_gpa, 2)} GPA</h5>
              <h5 class="pull-left" style="margin-left:10px">{$credits} credit hours</h5>
            </div>
      		</div>
        {/foreach}

          <!-- start: New semester bucket -->
          <div class="span3">
              <div id="new-semester" class="color-cccddd bucket">
                <h3 align="center">New semester</h3>
              </div>
        		</div>
            <!-- end: New semester bucket -->

    		</div>
	      <!-- end: Row -->

      </div>
      <!-- end: Table -->

    </div>
    <!-- end: Row -->

  </div>
  <!-- end: Container -->

</div>
<!-- end: Wrapper -->

{/block}
