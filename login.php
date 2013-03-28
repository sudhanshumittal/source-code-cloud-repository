<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="wnameth=device-wnameth, initial-scale=1.0">
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
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand disabled" href="#">Code Repo</a>
			  <form class="form-inline pull-right" method="POST" action= "./enter.php">
				  <input type="text" class="input" placeholder="Email" name="loginEmail">
				  <input type="password" class="input" placeholder="Password" name="loginPassword">
				  <button type="submit" class="btn">Sign in</button>
				</form>
			</div>
		  </div>
	</div>
	<div class="container-fluname">
		<h1>Create A New Account</h1>
		<form class="form-horizontal" method="GET" action ="./enter.php">
		  <div class="control-group">
			<label class="control-label" for="inputEmail">Email</label>
			<div class="controls">
			  <input type="text" name="inputEmail" placeholder="Email">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
			  <input type="text" name="inputFirstName" placeholder="First Name">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="last_name">Last Name</label>
			<div class="controls">
			  <input type="text" name="inputLastName" placeholder="Last Name">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="designation">Designation</label>
			<div class="controls">
			<select name="designation">
				<option value =0>B.Tech</option>
				<option value =1>M.Tech</option>
				<option value =2>PhD</option>
				<option value =3>Faculty</option>
				<option value =4>Other</option>
			</select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="inputPassword">Password</label>
			<div class="controls">
			  <input type="password" name="inputPassword" placeholder="Password">
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			  <label class="checkbox">
				<input type="checkbox"> Remember me
			  </label>
			  <button type="submit" class="btn">Sign in</button>
			</div>
		  </div>
		</form>
	</div>
	
	
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	</body>
</html>
