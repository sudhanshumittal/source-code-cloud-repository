<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['user_id'])) header("Location : ./login.php");
//echo $_SESSION['user_id'];
$alert = 0;
$msg="";
$user_id = -1;
$project = -1;
$user_name = "";
$project_name ="";
$file ="";
$url="./project.php";
$con;
if(isset($_GET['user_id'])){
	$user_id =  $_GET['user_id'];
	$url.="?user_id=".$user_id;
	//create db connection
	$con = mysql_connect("localhost","root","");
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	else{
		mysql_select_db("repo", $con);
		$result = mysql_query("select * from user where user_id = ".$user_id.";");
		$i = mysql_fetch_assoc($result);
		$user_name = $i["first_name"]." ".$i['last_name'];
	}
	if(isset($_GET['del_project']))
		delete_project($_GET['del_project']);
	if(isset($_GET['del_code']))
		delete_code($_GET['del_code']);
		
	if(isset($_GET['project'])){
		 $project =  $_GET['project'];
		 $url.="&project=".$project;
		 $result = mysql_query("select * from project where project_id = ".$project.";");
		 $i = mysql_fetch_assoc($result);
		 $project_name = $i["title"];
		 //echo $project_name;
	 }
}
else {
}//redirect

if(isset($_GET['file'])){
 $file =  $_GET['file'];
$url.="&file=".$file;
 }
//echo "\nuser_id =".$user_id;
//echo "\nproject =".$project;
//echo "./project.php?".$user_id."&".$project."&".$file ;
if(isset($_FILES["file"]["name"])) echo upload($user_id,$project);
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<link href="assets/css/prettify.css" type="text/css" rel="stylesheet" />
	<title>IITG Code Repository</title>
</head>
<body onload="prettyPrint()">
	<div class="navbar navbar-inverse">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand" href="#">Code Repo</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li class="active"><a href="#"> Home</a></li>
				  <li><a href="#about">Profile</a></li>
				  <li><a href="#about">About</a></li>
				  <li><a href="#contact">Contact</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
				<form class="navbar-search pull-right" method ="GET" action = "search.php">
					<div class="input-prepend">					  
					  <input class="search-query span4" id="inputIcon" type="text" name ="searchText" placeholder="Search someone or something…">
					</div>				  
				</form>
			</div>
		  </div>
		</div>
	<div id="alert_field"><?php
	?></div>
	<div class="container-fluid">
  	   <div class="row-fluid">
		<div class = "row-fluid">
		<h1>Sudhanshu Mittal</h1>
		<div class="btn-group offset6">
			  <button class="btn <?php if($user_id !== $_SESSION['user_id']) echo "disabled" ;?>" href="#addProjectModal" data-toggle="modal">Add project</button>
			  <button class="btn <?php if($user_id !== $_SESSION['user_id'] or !isset($_GET['project'])  ) echo "disabled" ;?>" href="#addFileModal" data-toggle="modal">Add file</button>
			  <button class="btn" onClick= "download()" >Download</button>
			</div>
		</div>
		<hr>
	 <!-- body-->
	  <div class="row-fluid">
			<div class="span9 " >
			<div class="row-fluid" >
				<ul class="breadcrumb" style = "background-color:#E8EFFD;">
				<?php 
					if(isset($_GET['user_id'])){ //user page
						$user_id = $_GET['user_id'];
						if(!isset($_GET['project'])){
							echo '<li class="active">'.$user_name.'</li>';
						}
						else{
							echo '<li><a href="?user_id='.$user_id.'">'.$user_name.'</a> <span class="divider">/</span></li>';
							$project = $_GET['project'];
								if(!isset($_GET['file']))
								echo '<li class="active">'.$project_name.'</li>';
								else{
									echo '<li><a href="?user_id='.$user_id.'&project='.$project.'">'.$project_name.'</a> <span class="divider">/</span></li>';
									echo '<li class="active">'.$_GET['file'].'</li>';	
								}
						}
					}
				?>
				</ul>
				<?php
				if(isset($_GET['file'])){	//file page
					$user_id = $_GET['user_id'];
					$project = $_GET['project'];
					$file = $_GET['file'];
			
					echo '<pre class="prettyprint linenums languague-cpp" >';
					$code = file_get_contents('./data/'.$user_id.'/'.$project.'/'.$file);
					echo $code;
					echo '</pre>';
				}
				else if(isset($_GET['project'])){	//project page
					echo '<div class="container" >';
					echo '<h5>Files</h5>';
					
					$user_id = $_GET['user_id'];
					$project = $_GET['project'];
					$query = 'select c.code_id, c.title from code c, contains co where c.code_id = co.code_id and co.project_id = '.$project.';';
					$result = mysql_query( $query);
					if (!$result) {
							die('Invalid query: ' . mysql_error());
						}
					while($i = mysql_fetch_assoc($result)){
						if($user_id == $_SESSION['user_id']) 
							echo '<button type="button" class="btn close" href="#dropFileModal" data-toggle="modal" onClick="drop_code('.$i["code_id"].',\''.$i["title"].'\')" >×</button>';
						echo '<a href="?user_id='.$user_id.'&project='.$project.'&file='.$i['code_id'].'">'.$i["title"].'</a> <span class="divider"></span><br>';
						
					}
					echo'</div><hr>';
						
					about(0);
				}
				else if(isset($_GET['user_id'])){ //user page
							$user_id = $_GET['user_id'];
							//$user_id = 1;
							$query = 'select p.project_id, p.title from project p,shares s where p.project_id = s.project_id and s.user_id = '.$user_id.';';
							echo '<div class="container" >';
							echo '<h5>Projects</h5>';
								
							$result = mysql_query($query);
							if (!$result) {
								die('Invalid query: ' . mysql_error());
							}
							while($i = mysql_fetch_assoc($result)){
								if($user_id == $_SESSION['user_id']) 
									echo '<button type="button" class="btn close" href="#dropProjectModal" data-toggle="modal" onClick="drop_project('.$i["project_id"].',\''.$i["title"].'\')" >×</button>';
								echo '<a href="?user_id='.$user_id.'&project='.$i["project_id"].'">'.$i["title"].'</a> <span class="divider"></span><br>';
								echo'</div><hr>';
							}
							echo '<div class="container-fluid">';
								about(1);
							echo '</div>';
					
				}
					?>			

			</div>		
			</div>
		  <!--Body content-->
			<div class="span3">
			  <?php 
			   if( isset($_GET['project'])) comments();
			  ?>
			  <!--Sidebar content-->
			</div>
		</div>
	  
	</div>
	<!-- add project form -->
	<div id="addProjectModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Add a new Project</h3>
	  </div>
	  <div class="modal-body">
		<p>One fine body…</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
	  </div>
	</div>
	<!-- drop project form -->
	<div id="dropProjectModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Drop Project</h3>
	  </div>
	  <div class="modal-body">
		<p id ="delete_project_para"></p>
		<p>Are you sure you want to continue?</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<a class="btn btn-primary" id="delete_project" >Continue</a>
	  </div>
	</div>
	<!-- add file form -->
	<div id="addFileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Add a new file to this Project</h3>
	  </div>
	  <form action="<?php echo $url ;?>" method="post"enctype="multipart/form-data">
	  <div class="modal-body">
		
		<input type="file" name="file" id="file" class =""><br>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary" type="submit">Upload</button>
	  </div>
	  </form>

	</div>
	<!-- drop file form -->
	<div id="dropFileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Drop files from this Project</h3>
	  </div>
	  <div class="modal-body">
		<p id ="delete_code_para">asjdhkh</p>
		<p>Are you sure you want to continue?</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<a class="btn btn-primary" id="delete_code" >Continue</a>
	  </div>
	</div>
	
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/prettify.js"></script>

	</body>
</html>
<?php
	function comments(){
		echo '<h4>Comments</h4><hr>';
		//echo '<div class="media">
		echo '<dl class = "">';
		echo '<dt><small><textarea rows="3" placeholder="Say something..." class= "span12"></textarea></small><dt>';
		echo '<button class ="btn btn-primary">comment</button><hr>';
		
		
		for( $i=0; $i<3; $i++){
			//echo '<div class="row span12 pull-right">';
			//echo '<div class="row span12 pull-right">
			echo '<dt><a href="#">sudhanshu mittal</a></dt>
			<dd><small>commments...</small><dd><hr>';
			//</div>';
		}
		echo '</dl>';
	}
	function about($type){
	if($type==1){
		echo '<dl class = "dl-horizontal">';
		echo	'<dt>Skill rating</dt>
			<dd><small>8/10</small><dd>';
		echo	'<dt>About</dt>
			<dd><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small><dd>';

		echo '</dl>';	
		}
	else{
		echo '<dl class = "dl-horizontal">';
		echo	'<dt>Project rating</dt>
			<dd><small>8/10</small><dd>';
		echo	'<dt>About</dt>
			<dd><small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small><dd>';

		echo '</dl>';
	}
}
function upload($user_id, $project){
$allowedExts = array("c", "cpp", "txt","php","java");
$extension = end(explode(".", $_FILES["file"]["name"]));
if (in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
     alert_error( $_FILES["file"]["error"] . "<br>");
    }
  else
    {
	if (file_exists("data/".$user_id."/".$project."/".$_FILES["file"]["name"]))
      {
       alert_error("A file already exists with the given name.");
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "data/".$user_id."/".$project."/".$_FILES["file"]["name"]);
       //add file to db as well
	   
	   alert_success("file successfully uploaded !");
      }
    }
  }
else
  {
  //return  "Invalid file";
  }

}
function alert_success($msg){
	//if($alert==1){
		echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.$msg.'</strong></div>';
//	}
	
}
function alert_error($msg){
	//if($alert==1){
		echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Oh snap ! '.$msg.'</strong></div>';
//	}
	
}
function delete_project($pro_id){
	/*drop all codes in the project*/
		$query = 'select code_id from contains where project_id='.$pro_id.';';		
		$result = mysql_query($query);
		while($i = mysql_fetch_assoc($result)){
				$query = 'delete from code where code_id='.$i["code_id"].';';
				$result = mysql_query($query);			
		}
		/* drop project */
		$query = 'delete from project where project_id='.$pro_id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		/*delete folder not done yet*/
		
}
function delete_code($id){

		/* drop file */
		$query = 'delete from code where code_id='.$id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		/*delete folder not done yet*/
		
}
mysql_close($con);
?>
 <script>
 function drop_project(pro, title){
	//alert(title);
	document.getElementById("delete_project").href = "./project.php?user_id="+<?php echo $user_id; ?>+"&del_project="+pro;
	document.getElementById("delete_project_para").innerHTML = "You are about to delete the project named - <strong>"+title+"</strong>";
 } 
 function drop_code(code_id, title){
	//alert(code_id+" "+title);
	document.getElementById("delete_code").href = "./project.php?user_id="+<?php echo $user_id; ?>+"&project_id="+<?php echo $project; ?>+"&del_code="+code_id;
	document.getElementById("delete_code_para").innerHTML = "You are about to delete the file named - <strong>"+title+"</strong>";
 }
 </script>
