<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();

if(isset($_GET['searchText'])) $searchText1 =  $_GET['searchText'];
else header("Location: ./index.php");

$con=mysqli_connect("localhost","root","","repo");

// Check connection
if (!$con)
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<title>IITG Code Repository</title>
	 <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
		padding-left: 60px;
		padding-right: 60px;
	  }
    </style>
</head>
<body onload="prettyPrint()">
	<?php
	menu('search');
	?>

	<div class="container-fluid span10 offset2">
	   <?php
	   $count=0;
	   $con=mysql_connect("localhost","root","");
	   mysql_select_db("repo");
			
	   $searchText = explode(" ",$searchText1);
	   $projects = Array();
	   foreach( $searchText as $word){
			if ($word =="" or $word ==" ") continue;
			$word = "REGEXP '.*".$word.".*'";
			$query = "select distinct u.user_id,u.first_name,u.last_name, p.project_id,p.title,p.description, p.language, p.rating
								from user u,project p, shares s
								where u.user_id=s.user_id
								and s.project_id=p.project_id
								and ( 
									p.project_id in (select project_id from tag where tag_name ".$word.")
									or u.first_name	 ".$word."
									or u.last_name ".$word."
									or u.email  ".$word."
									or p.title  ".$word."
									or p.description  ".$word."
									or p.language  ".$word."
								);";
			//echo $query ;
			$results = mysql_query($query);
			if (!$results) {
								die('Invalid query: ' . mysql_error());
			}
		   
		   while($i=mysql_fetch_array($results)){
		   	if(!isset($projects[$i["project_id"]])){
			$projects[$i["project_id"]] =1;
			$count++;
			   echo '<div class="row-fluid well" style = "background-color:#E8EFFD;">
					<h3><a href="project.php?user_id='.$i["user_id"].'">'.$i["first_name"]." ".$i["last_name"].
					'</a> / <a href ="project.php?user_id='.$i["user_id"].'&project='.$i["project_id"].'">'.$i["title"].'</a></h3>
					<dl class="dl-horizontal"></d>
					<dt>Rating</dt>
					<dd>'.$i["rating"].'</dd>
					<dt>Language</dt>
					<dd>'.$i["language"].'</dd>
					<dt>Description</dt>
					<dd>'.$i["description"].'</dd>
								   </div><hr>';
		    }
		   }
		}
		mysql_close($con);
	   if($count ==0){
		/*no results were displayed*/
		if(!isset($_GET['msg'])){
		echo '<div class="alert alert-error"><strong>Sorry, no results were found for the search "'.$searchText1.' ".</strong>
		<button type="button" class="close" data-dismiss="alert">&times;</button></div>
		<form action="wishlist.php" method = "post">
		
		<input class = "btn btn-primary" value="Notify me when results related to this search are found" type="submit">
		<input type = "text" class="hidden" name="searchQuery" value="'.$searchText1.'" />
		</form>';
		}
		else{
			alert_success('Query "'.$searchText1.'" successfully added to your wishlist');
		}
	   }
	   
	   ?>
	</div>
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	
	</script>
</body>
</html>