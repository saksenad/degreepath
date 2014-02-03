<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";
$user_email='vercetti21@gmail.com';
$num_sem=4;

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);
//TODO Replace BY SELECT TOP num_sem dates....
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
            $column[$i] .= '<slot id="entry_' . $row['Department'].$row['Number'] . '" class="ui-state-default" data-cid="'.$row['CID'].'">' .  $row['Department']." ".$row['Number'] . '</slot>';
            $semester[$i]=$row["Semester"];
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
    
    body {background-color:#0E5FAB;font-family:"Myriad Pro";color:#ffffff}
    #pending{ width:20%; min-height:100%; border:1px solid #ccc; background:#B9D5E7;list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; }
    #pending slot { display:block; color:#ffffff; background:#232C39; text-align:center; border-radius:10px; cursor:move;margin: 5px 5px 5px 5px; padding: 5px; font-size: 1.2em;font-family:"Myriad Pro";}

    #sortable0, #sortable1, #sortable2, #sortable3{ width:25%; min-height:250px; border:1px solid #ccc; background:#232C39; border-radius:5px; list-style-type: none; margin: 5; padding: 0; float: left; margin-right: 10px; }
    #sortable0 slot, #sortable1 slot, #sortable2 slot, #sortable3 slot { display:block; color:#ffffff; background:#637CA1; text-align:center; border-radius:10px; cursor:move;margin: 5px 5px 5px 5px; padding: 5px; font-size: 1.2em;font-family:"Myriad Pro";}
</style>
</head>
<body>

<?php


echo '<h1 align="center"> YOUR MOMS DEGREEPATH </h1>';
echo '<ul id="pending" class="connectedSortable">';
    echo '<h1 align="center"> PENDING </h1>';

$query = "SELECT * 
    FROM enrollments
    INNER JOIN classes ON classes.CID = enrollments.CID
    WHERE enrollments.user_email =  '".$user_email."'
    AND enrollments.Semester =  '0000-00-00';";
    $result = mysql_query($query) or die('Error, query failed');

    if (mysql_num_rows($result) == 0) { 
        $pending = '';
    }
    else {
        while ($row = mysql_fetch_array($result)) {
            $pending .= '<slot id="entry_' . $row['Department'].$row['Number'] . '" class="ui-state-default" data-cid="'.$row['CID'].'">' .  $row['Department']." ".$row['Number'] . '</slot>';
        }
    }

echo $pending;

echo '</ul>';

for($i=0;$i<$num_sem;$i++){
    echo '<ul id="sortable'.$i.'" class="connectedSortable" data-semester="'.$semester[$i].'" >';
        echo $column[$i];
    echo '</ul>';
}
?>

<script type="text/javascript">
$(function() 
{
    $('#pending, #sortable0, #sortable1, #sortable2, #sortable3').sortable(
    {
        connectWith: '.connectedSortable',
        receive: function(event, ui) {
            console.log(this);
         $.ajax(
            {
                type: "POST",
                url: "classShiftedAJAX.php",
                data: 
                {
                    
                    receiver:this.getAttribute("data-semester"),
                    user:'<?php echo $user_email?>',
                    classId:ui.item.attr("data-cid"),
                    sender:ui.sender.attr("data-semester")
                },
                success: function(html)
                {
                    alert(html);
                }

            });
        } 
    }).disableSelection();
});
</script>
</body>
</html>