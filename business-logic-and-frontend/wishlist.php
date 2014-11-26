<?php
if(isset($_POST['searchQuery'])){
	session_start();
	$query = 'insert into wishlist values ("'.$_SESSION['user_id'].'","'.$_POST['searchQuery'].'")';
	echo $query;	
	$con = mysql_connect("localhost","root","");
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("repo", $con);
	$result = mysql_query($query);
	if (!$result) {
			die('Invalid query: ' . mysql_error());
			
	}
}
header('Location: ' . $_SERVER['HTTP_REFERER']."&msg='added'");

?>