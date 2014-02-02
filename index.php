<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";
$user_email='vercetti21@gmail.com';
$num_sem=4;

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$query="CREATE TABLE IF NOT EXISTS `classes` (
  `CID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Department` varchar(255) NOT NULL,
  `Number` int NOT NULL,
  PRIMARY KEY (`CID`)
);";
$result = mysql_query($query) or die('Error, create table classes failed');

$query="CREATE TABLE IF NOT EXISTS `enrollments` (
  `EID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CID` int(10) unsigned NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `Semester` varchar(255) NOT NULL,
  PRIMARY KEY (`EID`),
  FOREIGN KEY (CID) REFERENCES classes(CID)
);";
$result = mysql_query($query) or die('Error, create table enrollments failed');

//TODO Replace BY SELECT TOP 4 dates....
$dates=array(
 '2013-08-15',
 '2014-01-15',
 '2014-08-15',
 '2015-01-15'
);

for($i=0;$i<$num_sem;$i++){
    $query = "SELECT * 
    FROM enrollments
    INNER JOIN classes ON classes.CID = enrollments.CID
    WHERE enrollments.user_email =  '".$user_email."'
    AND enrollments.Semester =  '".$dates[$i]."';";
    $result = mysql_query($query) or die('Error, query failed');

    if (mysql_num_rows($result) == 0) { 
        $column[$i] = '';
    }
    else {
        while ($row = mysql_fetch_array($result)) {
            $column[$i] .= '<li id="entry_' . $row['Department'].$row['Number'] . '" class="ui-state-default">' .  $row['Department']." ".$row['Number'] . '</li>';
        }
    }

}


?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; utf-8" />
<title>DegreePath</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>

<style type="text/css">
    #sortable0, #sortable1, #sortable2, #sortable3{ width:48%; min-height:400px; border:1px solid #ccc; background:#f3f3f3;list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; }
    #sortable0 li, #sortable1 li, #sortable2 li, #sortable3 li { display:block; background:#e3e3e3; cursor:move;margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em;}
</style>
</head>
<body>

<p class="success" style="display:none;">Success</p>

<?php
for($i=0;$i<$num_sem;$i++){
    echo '<ul id="sortable'.$i.'" class="connectedSortable">';
        echo $column[$i];
    echo '</ul>';
}
?>

<script type="text/javascript">
$(function() 
{
    $('#sortable0, #sortable1, #sortable2, #sortable3').sortable(
    {
        connectWith: '.connectedSortable',
        receive: function(event, ui) {
         $.ajax(
            {
                type: "POST",
                url: "draggable.php",
                data: 
                {
                    reciever:this.id,
                    cls:ui.item.html(),
                    sender:ui.sender.attr("id")
                },
                success: function(html)
                {
                    $('.success').fadeIn(500);
                }

            });
        } 
    }).disableSelection();
});
</script>

</body>
</html>
