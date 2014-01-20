<?php 

$dbhost = "localhost";
$dbuser = "DB USER";
$dbpass = "DB PASS";
$dbname = "demo_draggable";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$contest_id = '1';
$judge_id = '1';
$ip_address = $_SERVER['REMOTE_ADDR'];
$column1 = '';
$column2 = '';

$query = "SELECT entry_id FROM ranking WHERE contest_id = '$contest_id' AND judge_id = '$judge_id' AND ranking_column = '0' ORDER BY ranking_value ASC";
$result = mysql_query($query) or die('Error, query failed');

if (mysql_num_rows($result) == 0) { 
	$column1 = '';
	}
else {
	while ($row = mysql_fetch_array($result)) {
		$column1 .= '<li id="entry_' . $row['entry_id'] . '" class="ui-state-default">Entry #' .  $row['entry_id'] . '</li>';
		}
	}


$query2 = "SELECT entry_id FROM ranking WHERE contest_id = '$contest_id' AND judge_id = '$judge_id' AND ranking_column = '1' ORDER BY ranking_value ASC";
$result2 = mysql_query($query2) or die('Error, query failed');

if (mysql_num_rows($result2) == 0) { 
	$column2 = '';
	}
else {
	while ($row2 = mysql_fetch_array($result2)) {
		$column2 .= '<li id="entry_' . $row2['entry_id'] . '" class="ui-state-default">Entry #' .  $row2['entry_id'] . '</li>';
		}
	}
	
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; utf-8" />
<title>Pilotmade Sortables Demo</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>

<style type="text/css">
	#sortable1, #sortable2 { width:48%; min-height:400px; border:1px solid #ccc; background:#f3f3f3;list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; }
	#sortable1 li, #sortable2 li { display:block; background:#e3e3e3; cursor:move;margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em;}
</style>
</head>
<body>

<p class="success" style="display:none;">Success</p>

<ul id="sortable1" class="connectedSortable">
	<?php echo $column1; ?>
</ul>

<ul id="sortable2" class="connectedSortable">
	<?php echo $column2; ?>
</ul>

<script type="text/javascript">
$(function() 
{
    $("#sortable1, #sortable2").sortable(
    {
        connectWith: '.connectedSortable',
        update : function () 
        { 
            $.ajax(
            {
                type: "POST",
                url: "draggable.php",
                data: 
                {
                    sort1:$("#sortable1").sortable('serialize'),
                    sort2:$("#sortable2").sortable('serialize')
                },
                success: function(html)
                {
                    //$('.success').fadeIn(500);
                }
            });
        } 
    }).disableSelection();
});
</script>

</body>
</html>