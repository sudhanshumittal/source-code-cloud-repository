<?php 
require_once "include.php" ;
if(isset($_REQUEST['rating'])){
	//echo $_POST['rating']."<br>".$_POST['user_id'];
	$con = mysql_connect("localhost","root","");
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("repo", $con);
	$query = 'insert into rates values ("'.$_POST['user_id'].'", "'.$_POST['project_id'].'", "'.$_REQUEST['rating'].'" );';
	echo $query;
	$result = mysql_query($query);
	if (!$result) {
			die('Invalid query: ' . mysql_error());
	}
	
	header("Location: ./project.php?user_id=".$_POST['user_id']."&project=".$_POST['project_id']);
}else
	header("Location: ./index.php");
?>
