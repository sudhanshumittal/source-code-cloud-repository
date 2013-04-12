<?php
/*all inculded functions */
function in_session(){
	return isset($_SESSION['user_id']);
}
function destroy_session(){
	/*destro session*/
	session_start();
	session_destroy();
	/*redirect to login*/
	header("Location: ./login.php");

}
function menu($page){

//echo $_SESSION['user_id'];
echo'
<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand" href="./index.php">Code Repo</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">';
switch($page){
case'project':			echo' 
				 <li ><a href="./index.php"> Home</a></li>
				  <li class="active"><a href="#">Profile</a></li>
				  <li><a href="#about">About</a></li>
				  <li><a href="#contact">Contact</a></li>
				  <li class="pull right"><a href ="./signout.php">Sign out</a></li>
				</ul>
			  </div>';
			  break;
case 'index':			echo'
				 <li class="active"><a > Home</a></li>
				  <li ><a href="./project.php?user_id='.$_SESSION['user_id'].'">Profile</a></li>
				  <li><a href="#about">About</a></li>
				  <li><a href="#contact">Contact</a></li>
				  <li class="pull right"><a href ="./signout.php">Sign out</a></li>
				</ul>
			  </div>';
			  break;
}
			  echo' <!--/.nav-collapse -->
				<form class="navbar-search pull-right" method ="GET" action = "search.php">
					<div class="input-prepend">					  
					  <input class="search-query span4 " id="inputIcon" type="text" name ="searchText" placeholder="Search someone or something…">
					</div>				  
				</form>
			</div>
		  </div>
		</div>';

		
}
?>