<!DOCTYPE html>
<?php
$user = "";
$project ="";
$file ="";
$url="./project.php";
if(isset($_GET['user'])){
 $user =  $_GET['user'];
$url.="?user=".$user;

}
else {
}//redirect
if(isset($_GET['project'])){
 $project =  $_GET['project'];
 $url.="&project=".$project;
 }
if(isset($_GET['file'])){
 $file =  $_GET['file'];
$url.="&file=".$file;
 }
//echo "\nuser =".$user;
//echo "\nproject =".$project;
//echo "./project.php?".$user."&".$project."&".$file ;
if(isset($_FILES["file"]["name"])) upload();
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

	<div class="container-fluid">
  	   <div class="row-fluid">
		<div class = "row-fluid">
		<h1>Sudhanshu Mittal</h1>
		<div class="btn-group offset6">
			  <button class="btn <?php if($user !== "sudhanshumittal") echo "disabled" ;?>" href="#addProjectModal" data-toggle="modal">Add project</button>
			  <button class="btn <?php if($user !== "sudhanshumittal") echo "disabled" ;?>" href="#dropProjectModal" data-toggle="modal">Drop project</button>
			  
			  <button class="btn <?php if($user !== "sudhanshumittal" or !isset($_GET['project'])  ) echo "disabled" ;?>" href="#addFileModal" data-toggle="modal">Add file</button>
			  <button class="btn <?php if($user !== "sudhanshumittal" or !isset($_GET['project'])) echo "disabled" ;?>" href="#dropFileModal" data-toggle="modal">Drop file</button>
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
					if(isset($_GET['user'])){ //user page
						$user = $_GET['user'];
						if(!isset($_GET['project'])){
							echo '<li class="active">'.$user.'</li>';
						}
						else{
							echo '<li><a href="?user=sudhanshumittal">'.$user.'</a> <span class="divider">/</span></li>';
							$project = $_GET['project'];
								if(!isset($_GET['file']))
								echo '<li class="active">'.$project.'</li>';
								else{
									echo '<li><a href="?user=sudhanshumittal&project='.$project.'">'.$project.'</a> <span class="divider">/</span></li>';
									echo '<li class="active">'.$_GET['file'].'</li>';	
								}
						}
					}
				?>
				</ul>
				<?php
				if(isset($_GET['file'])){
					$user = $_GET['user'];
					$project = $_GET['project'];
					$file = $_GET['file'];
			
					echo '<pre class="prettyprint linenums languague-cpp" >';
					$code = file_get_contents('./data/'.$user.'/'.$project.'/'.$file);
					echo $code;
					echo '</pre>';
				}
				else if(isset($_GET['project'])){
					echo '<div class="container" >';
					echo '<h5>Files</h5>';
					
					$user = $_GET['user'];
					$project = $_GET['project'];
					if ($handle = opendir('./data/'.$user.'/'.$project.'/')) {
					//echo '<ul>';
						while (false !== ($entry = readdir($handle))) {
							if( $entry =='.' || $entry =='..' ) continue;
							echo '<a href="?user='.$user.'&project='.$project.'&file='.$entry.'">'.$entry.'</a> <span class="divider">/</span><br>';
						}
						echo'</div><hr>';
						closedir($handle);
						}
						about(0);
				}
				else if(isset($_GET['user'])){ //user page
							$user = $_GET['user'];
							if ($handle = opendir('./data/'.$user.'/')) {
							echo '<div class="container" >';
							echo '<h5>Projects</h5>';
							while (false !== ($entry = readdir($handle))) {
								if( $entry =='.' || $entry =='..' ) continue;
								echo '<a href="?user='.$user.'&project='.$entry.'">'.$entry.'</a> <span class="divider">/</span><br>';
							}
							echo'</div><hr>';
							 closedir($handle);
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
		<h3 id="myModalLabel">Drop the following Projects</h3>
	  </div>
	  <div class="modal-body">
		<p>One fine body…</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
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
		<p>One fine body…</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
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
function upload(){
$allowedExts = array("c", "cpp", "txt");
$extension = end(explode(".", $_FILES["file"]["name"]));
if (true || (($_FILES["file"]["type"] == "text/txt")
|| ($_FILES["file"]["type"] == "text")
|| ($_FILES["file"]["type"] == "text")
|| ($_FILES["file"]["type"] == "text"))
&& ($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    //return  "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    //return  "Upload: " . $_FILES["file"]["name"] . "<br>";
    //return  "Type: " . $_FILES["file"]["type"] . "<br>";
    //return  "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    //return  "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      //return  $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      //return  "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  //return  "Invalid file";
  }

}
?>
