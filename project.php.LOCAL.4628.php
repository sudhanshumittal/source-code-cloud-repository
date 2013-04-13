<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();

//echo $_SESSION['user_id'];
//$alert = 0;
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
	 if(isset($_GET['file'])){
		$project =  $_GET['project'];
		$query = "select * from code where code_id = ".$_GET['file'].";";
		$result = mysql_query($query );
		//echo 	$query;	
		$i = mysql_fetch_assoc($result);
		 $code_name = $i["title"];
		 $extension = $i["extension"]; 
	 }
	 if(isset($_REQUEST['comment'])){
		//echo $_REQUEST['comment'];
		$secs = time();
		$time= date('Y-m-d')." ".($secs / 3600 % 24 ).":".($secs / 60 % 60).":".($secs % 60);
		$query = "insert into comments values(".$_SESSION['user_id'].",".$_GET['project'].",'".$_REQUEST['comment']."','".$time."');";
		//echo $query;
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
	 }
}
else {
	header("Location: ./index.php");
}//redirect

if(isset($_GET['file'])){
 $file =  $_GET['file'];
$url.="&file=".$file;
 }
//echo "\nuser_id =".$user_id;
//echo "\nproject =".$project;
//echo "./project.php?".$user_id."&".$project."&".$file ;
if(isset($_FILES["file"]["name"])) echo upload($user_id,$project);
if(isset($_REQUEST["project_title"])) echo create_project($user_id, $project, $_REQUEST['project_title'],$_REQUEST['language'], $_REQUEST['description'] );
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<link href="assets/css/prettify.css" type="text/css" rel="stylesheet" />
	<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
		padding-left: 60px;
		padding-right: 60px;
	  }
    </style>
	<title>IITG Code Repository</title>
</head>
<body onload="prettyPrint()">
	<?php
	menu('project');
	?>
	<div id="alert_field"><?php
	?></div>
	<div class="container-fluid">
  	   <div class="row-fluid">
		<div class = "row-fluid">
		<h1><?php echo $user_name ;?></h1>
		<div class="btn-group offset6">
			  <button class="btn  <?php if($user_id !== $_SESSION['user_id'] or isset($_GET['project'])) echo '" disabled = "disabled' ;
				else echo 'btn-primary' ;?>" href="#addProjectModal" data-toggle="modal">Add project</button>
			  <button class="btn  <?php if($user_id !== $_SESSION['user_id'] or !isset($_GET['project'])  ) echo '" disabled = "disabled' ;
				else echo 'btn-primary' ;?>" href="#addFileModal" data-toggle="modal">Add file</button>
			  <a class="btn <?php if(!isset($_GET['project'])) echo '" disabled = "disabled' ;
				else echo 'btn-primary' ;?>" 
			  href="<?php if(isset($_GET['project'])) echo './download.php?project_id='.$_GET['project']; 
						  if(isset($_GET['file'])) echo "&file_id=".$_GET['file'] ;
			  ?>" >Download</a>
			</div>
		</div>
		<hr>
	 <!-- body-->
	  <div class="row-fluid">
			<div class="span9 " >
			<div class="row-fluid" >
			<!-- breadcrumbs-->
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
									echo '<li class="active">'.$code_name.'</li>';	
								}
						}
					}
				?>
				
				</ul>
				<div class = "row-fluid"><?php
					
				?>
				</div>
				<?php
					if(isset($_GET['file'])){	//file page
						$user_id = $_GET['user_id'];
						$project = $_GET['project'];
						$file = $_GET['file'];
				
						echo '<pre class="prettyprint linenums languague-'.$extension.'" >';
						$code = file_get_contents('./data/'.$user_id.'/'.$project.'/'.$file.'.'.$extension);
						echo $code;
						echo '</pre>';
					}
					else if(isset($_GET['project'])){	//project page
						echo '<div class="container" >';
						echo '<h3>Files</h3>';
						
						$user_id = $_GET['user_id'];
						$project = $_GET['project'];
						$query = 'select c.code_id, c.title from code c, contains co where c.code_id = co.code_id and co.project_id = '.$project.';';
						$result = mysql_query( $query);
						if (!$result) {
								die('Invalid query: ' . mysql_error());
							}
						while($i = mysql_fetch_assoc($result)){
							if($user_id == $_SESSION['user_id']) 
								echo '<div class = "span6">
								<button type="button" class="btn close" href="#dropFileModal" data-toggle="modal" onClick="drop_code('.$i["code_id"].',\''.$i["title"].'\')" >
								<i class="icon-remove"></i>
								</button>';
							echo '<a href="?user_id='.$user_id.'&project='.$project.'&file='.$i['code_id'].'">'.$i["title"].'</a> <br></div>';
							
						}
						echo'</div><hr>';
							
						about(0);
					}
					else if(isset($_GET['user_id'])){ //user page
							$user_id = $_GET['user_id'];
							//$user_id = 1;
							$query = 'select p.project_id, p.title from project p,shares s where p.project_id = s.project_id and s.user_id = '.$user_id.';';
							echo '<div class="container" >';
							echo '<h3>Projects</h3>';
								
							$result = mysql_query($query);
							if (!$result) {
								die('Invalid query: ' . mysql_error());
							}
							while($i = mysql_fetch_assoc($result)){
								if($user_id == $_SESSION['user_id']) 
									echo '<div class="row span8" >
									<button type="button" class="btn close" href="#dropProjectModal" data-toggle="modal" onClick="drop_project('.$i["project_id"].',\''.$i["title"].'\')" >
									<i class="icon-remove " ></i>
									</button>';
								echo ' <a href="?user_id='.$user_id.'&project='.$i["project_id"].'">'.$i["title"].'</a><br></div>';
								
							}
							echo'</div><hr>';
							echo '<div class="container-fluid">';
								about(1);
							echo '</div>';
					
				}
				?>			

			</div>		
			</div>
		  <!--comments content-->
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
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
		<h3 id="myModalLabel">Create a new Project</h3>
	  </div>
	  <form method ="POST" action ="./project.php?user_id=<?php echo $user_id;?> ">
	  <div class="modal-body">
		<table>
			<tr>
				<td><input type="text" name ="project_title" placeholder ="project title" /></td>
			</tr>
			<tr>
				<td>
					<select name="language" value="language">
					<option>C</option>
					<option>C++</option>
					<option>Php</option>
					<option>Java</option>
					</select>
				</td>
			</tr>
			<tr>
				<td> <input type="text" name ="description" placeholder ="project description" /></td>
			</tr>
		</table>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-primary" type ="submit" >Continue</button>
	  </div>
	  </form>
	</div>
	<!-- drop project form -->
	<div id="dropProjectModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
		<h3 id="myModalLabel">Drop Project</h3>
	  </div>
	  <div class="modal-body">
		<p id ="delete_project_para"></p>
		<p>Are you sure you want to continue?</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<a class="btn btn-primary" id="delete_project" >Continue</a>
	  </div>
	</div>
	<!-- add file form -->
	<div id="addFileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
		<h3 id="myModalLabel">Add a new file to this Project</h3>
	  </div>
	  <form action="<?php echo $url ;?>" method="post" enctype="multipart/form-data">
	  <div class="modal-body">
		
		<input type="file" name="file" id="file" class =""><br>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-primary" type="submit">Upload</button>
	  </div>
	  </form>

	</div>
	<!-- drop file form -->
	<div id="dropFileModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
		<h3 id="myModalLabel">Drop files from this Project</h3>
	  </div>
	  <div class="modal-body">
		<p id ="delete_code_para">asjdhkh</p>
		<p>Are you sure you want to continue?</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
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
		echo '<h3>Comments</h3><hr>';
		//echo '<div class="media">
		echo '<dl class = "">';
		echo '<form action="project.php?user_id='.$_GET['user_id'].'&project='.$_GET['project'].'" method = "POST" >
				<dt><small><textarea rows="3" placeholder="Say something..." class= "span12" name="comment"></textarea></small><dt>';
		echo '<dd><button class ="btn btn-primary">comment</button></dd></form><hr>';
		
		$query = 'select * from user u,comments c where c.project_id = '.$_GET['project'].' and u.user_id = c.user_id order by c.comment_date ';
		//echo $query;
		$result = mysql_query($query);
		while($i = mysql_fetch_assoc($result)){
			//echo '<div class="row span12 pull-right">';
			//echo '<div class="row span12 pull-right">
			echo '<dt><a href="./project.php?user_id='.$i["user_id"].'">'.$i["first_name"].' '.$i["last_name"] .'</a> </dt>
			<dd><small><p class="muted"> on '.$i["comment_date"].'</p>'.$i["comment"].'</small><dd><hr>';
			//</div>';
		}
		echo '</dl>';
	}
	function about($type){
	 
	if($type==1){ /*about some user*/
		echo '<h3>About</h3> ';
		if($_SESSION['user_id'] == $_GET['user_id'] ) echo '<a onClick ="edit_profile()" >edit</a>';
		$query = "select * from user where user_id = ".$_GET['user_id']." ;";
		$result = mysql_query($query);	
		while($i = mysql_fetch_assoc($result)){
			echo '<dl class = "dl-horizontal">';
			echo	'<dt>Email Address</dt>
				<dd><small>'.$i["email"].'</small><dd>';
			echo	'<dt>Skill Rating</dt>
				<dd><small>'.$i["skill_level"].'</small><dd>';
			echo	'<dt>Designation</dt>
				<dd><small>'.$i["designation"].'</small><dd>';
			echo '</dl>';	
		}
	}
	else{ /*about some project*/
		echo '<dl class = "dl-horizontal">';
		echo	'<dt>Project rating</dt>
				<dd><small>';
			/*rating bar*/
			if(isset($_GET['project']) and !isset($_GET['file'])){
				
				$query = "select rating from rates where project_id = '".$_GET['project']."';";
				//echo $query;
				$result = mysql_query($query);
				if (!$result) {
						die('Invalid query: ' . mysql_error());
				}
				$rating =0;
				$count = 0;
				while($i = mysql_fetch_assoc($result)){
					$count++;
					$rating += $i['rating'];
				}
				if($count !=0)
					echo "  ".round($rating/$count, 2)." / 5 ";
				else 
					echo "No one has rated this project yet";
				if($_GET['user_id'] != $_SESSION['user_id']) /*user cannot rate his own project*/
				{
					echo '<form action= "./rate.php" method = "post" class ="form-inline"> ';
					echo '<label><select name="rating" class="span14">';
					for( $i =5; $i>=1 ; $i--)
						echo '<option>'.$i.'</option>';
					echo '</select></label>
					<button class= "btn btn-primary" type="submit"  >Rate</button>
					<input class= "hidden span1" type="text" name="project_id" value ="'.$_GET['project'].'" />
					<input class= "hidden span1" type="text" name = "user_id" value ="'.$_GET['user_id'].'" />					
					
					';
					echo '</form>';
				}
				
			}	
			echo '</small><dd>';
		$query = "select * from project where project_id = ".$_GET['project']." ;";
		$result = mysql_query($query);	
		while($i = mysql_fetch_assoc($result)){
			
			
			echo	'<dt>Language</dt>
				<dd><small>'.$i["langauge"].'</small><dd>';
			echo	'<dt>About</dt>
				<dd><small>'.$i["description"].'</small><dd>';
			
		}
		echo '</dl>';
	}
}
function create_project($user_id, $project,$title, $language, $description){
	/*search if the title already exisits for a user*/
	/*if not create a project in db*/
	$query = 'insert into project(title, description, url , langauge ) 
	values ("'.$title.'", "'.$description.'", "data/'.$user_id.'/ ", "'.$language.'")';
	//echo $query;
	mysql_query($query);
	$query  = "select max(project_id) as max_pro from project" ;
	//echo '<br>'.$query;
	$result = mysql_query($query);
	$i = mysql_fetch_assoc($result);
	$secs = time();
		$time= date('Y-m-d')." ".($secs / 3600 % 24 ).":".($secs / 60 % 60).":".($secs % 60);
	$query = 'insert into shares values('.$_SESSION["user_id"].','.$i["max_pro"].',"'.$time.'");';
	//echo '<br>'.$query;
	$result = mysql_query($query);
	/*cretae a folder for this project in folder data/user_id*/
	mkdir('data/'.$_SESSION['user_id'].'/'.$i['max_pro']);
	alert_success("Project Successfully created.");
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
		
      //add file to db 
	 // echo $extension;
	   $query  = 'insert into code(	description,	url ,	title, extension	 ) 
	   values("","data/'.$user_id.'/'.$project.'/","'.$_FILES["file"]["name"].'","'.$extension.'" )';
	  // echo $query;
	   mysql_query($query);
	   $query  = 'select max(code_id) as max_id from code';
	  // echo '<br>'.$query;
	   $result = mysql_query($query);
	   $i = mysql_fetch_assoc($result);
	   $query = 'insert into contains values('.$project.','.$i['max_id'].')' ;
	  // echo '<br>'.$query;
	   $result = mysql_query($query);
	   alert_success("file successfully uploaded !");
      /*upload file into folder*/
	  //echo "./data/".$_SESSION['user_id']."/".$project."/";
	  
	  move_uploaded_file($_FILES["file"]["tmp_name"],
      "./data/".$_SESSION['user_id']."/".$project."/".$i['max_id']	);
      
	  
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
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		else 
		while($i = mysql_fetch_assoc($result)){
				$query = 'delete from code where code_id='.$i["code_id"].';';
				$result = mysql_query($query);			
		}
		
		/* drop project */
		$query = 'delete from project where project_id = ' .$pro_id;
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$query = 'delete from shares where project_id='.$pro_id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$query = 'delete from comments where project_id='.$pro_id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$query = 'delete from rates where project_id='.$pro_id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		
		/*delete folder*/
		try{
		$dir = ("data/".$_SESSION['user_id']."/".$pro_id);
		$it = new RecursiveDirectoryIterator($dir);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
		foreach($it as $file) {
			if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
			if ($file->isDir()) rmdir($file->getPathname());
			else unlink($file->getPathname());
		}
		rmdir($dir);
		alert_success("Project successfully deleted");
		}
		catch (Exception $e) {
			alert_error('This project does not exist. Caught exception: '.  $e->getMessage());
		}
}
function delete_code($id){
		echo $id .'<br>';
		/* drop file */
		$query = 'delete from contains where code_id='.$id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		$query = 'delete from code where code_id='.$id.';';
		$result = mysql_query($query);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		}
		/*delete folder not done yet*/
		unlink("data/".$_SESSION['user_id']."/".$_GET['project_id']."/".$id);
		alert_success("File successfully deleted from your project ");
}
if($con) mysql_close($con);
?>
 <script>
 function drop_project(pro, title){
	//alert(title);
	document.getElementById("delete_project").href = "./project.php?user_id="+<?php echo $user_id; ?>+"&del_project="+pro;
	document.getElementById("delete_project_para").innerHTML = "You are about to delete the project named - <strong>"+title+"</strong>";
 } 
 function edit_profile(){
	alert("edit_profile");
	//document.getElementById("delete_project").href = "./project.php?user_id="+<?php echo $user_id; ?>+"&del_project="+pro;
	//document.getElementById("delete_project_para").innerHTML = "You are about to delete the project named - <strong>"+title+"</strong>";
 } 
 function drop_code(code_id, title){
	//alert(code_id+" "+title);
	document.getElementById("delete_code").href = "./project.php?user_id="+<?php echo $user_id; ?>+"&project_id="+<?php echo $project; ?>+"&del_code="+code_id;
	document.getElementById("delete_code_para").innerHTML = "You are about to delete the file named - <strong>"+title+"</strong>";
 }
 </script>
