<?php include('../config/constants.php'); ?>
<html >
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">		
	<script type="text/javascript" src="../js/login.js" async></script>
</head>
<body>
	<div class="container-login">
		<div class="login-page" id="login">
			<h1>Welcome !</h1>
			<?php 
			if(isset($_SESSION['login'])) {
				echo $_SESSION['login'];
				unset($_SESSION['login']);
			}
			?>
		<form action="" method="post" >
		<div class="input-box">
				<i class="fa fa-user-o"></i>
				<input type="text" name="username" placeholder="Enter Your Uesername" id="user">
			</div>
			<div class="input-box">
				<i class="fa fa-key"></i>
				<input type="password" name="password" placeholder="Enter Your password" id="pwd">
				<span class="eye" id="eye-icon">
					<i class="fa fa-eye" id="hide-eye"></i>
					<i class="fa fa-eye-slash" id="hide-eye-slash"></i>
				</span>
			</div>
			<div class="save ">
				<input type="checkbox" name="" id="">
				<span>Remember Me</span>
			</div>
			<button type="submit" name="submit" class="login-button" onclick="loginClick()">Login</button>
			<div class="help">
				<p>Need <a href="#">help?</a> </p>
			</div>
		</form>
		
		
		</div>
		<!-- <div class="login-page" id="hello">
			<h3>Hello Guy :v</h3>
			<h1 id="user-name"></h1>
			<button type="button" class="login-button" onclick="logoutClick()">Logout</button>
		</div> -->
	</div>
</body>
</html>


<?php 
	if(isset($_POST['submit']))
	{
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		
		$sql ="select * from tbl_admin where username='$username' and password='$password'";

		$res= mysqli_query($conn,$sql);

		$count=mysqli_num_rows($res);

		if($count==1){
			$_SESSION['login']="<div class='success'> Login Successfully</div>";
			header('location:'.SITEURL.'admin/');
			$_SESSION['user']=$username;
		}
		else{
			$_SESSION['login']="<div class='error text-center'> Login Failed</div>";
			header('location:'.SITEURL.'admin/login');
		}



		
	}

?>