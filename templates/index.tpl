{extends file="layout.tpl"}
{block name=body}
  <ul id="pending" class="connectedSortable">    
    {foreach $courses as $course}
      <li class="ui-state-default">{$course['subject']} {$course['course_number']}</li>
    {/foreach}
  </ul>
  {assign var="num" value="0"}
  {foreach $enrollments as $term }
    <div id="bucket">
      <h3 align="center">{$season[substr($terms[$num],4,2)]} {substr($terms[$num],0,4)}</h3>
      <ul id="sortable" class="connectedSortable" data-term={$terms[$num]}>
        {foreach $term as $enrollment}
          {if $enrollment}
            <li class="ui-state-default" data-cid={$enrollment['id']}>{$enrollment['subject']} {$enrollment['course_number']} - {$enrollment['name']}</li>
          {/if}
        {/foreach}
      </ul>
      {assign var="num" value=$num+1}
    </div>
  {/foreach}
{/block}
