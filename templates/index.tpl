{extends file="layout.tpl"}
{block name=body}
  
<!-- start: Wrapper -->
<div id="wrapper">

  <!-- start: Container -->
  <div id="container">

    <!-- start: Accordian -->


    <!-- end: Accordian -->

    <!-- start: Table -->

      <!-- start: Row -->
  		<div class="row">

        {assign var="num" value="0"}
        {foreach $enrollments as $term }

      		<div class="span4">
        	  <div class="icons-box">

              <div id="bucket" class="color-cccddd">
                <h3 align="center">{$season[substr($terms[$num],4,2)]} {substr($terms[$num],0,4)}</h3>
                <ul id="sortable" class="connectedSortable" data-term={$terms[$num]}>
                  {foreach $term as $enrollment}
                    {if $enrollment}
                      <li class="ui-state-default" data-cid={$enrollment['id']}>{$enrollment['subject']} {$enrollment['course_number']} - {$enrollment['name']}</li>
                    {/if}
                  {/foreach}
                </ul>
              </div>

	          </div>
      		</div>

          {assign var="num" value=$num+1}

        {/foreach}

  		</div>
	    <!-- end: Row -->

    <!-- end: Table -->

  </div>
  <!-- end: Container -->

</div>
<!-- end: Wrapper -->

{/block}
