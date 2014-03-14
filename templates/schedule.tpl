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
  <div id="container">

    <!-- start: Accordian -->
    <div id="courses">
      <div class="span2">

        <div id="accordion">
          <h3>
            <span class="subject">{$userInfo['major']}</span>
            <img class="remove-subject" src="/img/icons/x.png"></img> 
          </h3>
          {assign var='courses' value=getCourses($userInfo['major'])}
          <div id="accordionWrapper" class="color-cccddd">
            <ul class="pending connectedSortable" data-term="000000">    
              {foreach $courses as $course}
                <li data-cid={$course['id']}>{$course['subject']} {$course['course_number']}</li>
              {/foreach}
            </ul>
          </div>
        </div>
      
        <div id="addDept">
            <select id="deptDropDown">
              {foreach $departments as $dept} 
              <option value={$dept['subject']}>{$dept['subject']}</option>
              {/foreach}
            </select>
            <button id="deptButton">Add</button>
        </div>

      </div>
    </div>
    <!-- end: Accordian -->

    <!-- start: Table -->
    <div id="table">

      <!-- start: Row -->
  		<div class="row" id="semester-buckets">

      {foreach $terms as $term}
    		<div class="span3">
          <div id="semester" class="color-cccddd bucket">
            <h3 id="semester-header" align="center">
              {$season[substr($term,4,2)]} {substr($term,0,4)}
              <img class="remove-semester" src="/img/icons/x.png"></img>              
            </h3>
            <ul class="sortable connectedSortable" data-term={$term}>
              {if array_key_exists($term, $enrollments)}
                {foreach $enrollments[$term] as $enrollment}
                  {if $enrollment}
                    <li class="ui-state-default" data-cid={$enrollment['id']}>
                      <div class="course-title">{$enrollment['subject']} {$enrollment['course_number']} - {$enrollment['name']}</div>
                      <img class="remove" src="/img/icons/x.png"></img>
                    </li>
                  {/if}
                {/foreach}
              {/if}
            </ul>
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
  <!-- end: Container -->

</div>
<!-- end: Wrapper -->

{/block}
