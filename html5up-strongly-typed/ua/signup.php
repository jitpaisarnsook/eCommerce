<!DOCTYPE HTML>
<!--
	Strongly Typed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Meme Market</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body class="homepage">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<div id="header" class="container">

						<!-- Logo -->
							<img src="../images/MemeMarket.png" height=250/>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li><a class="icon fa-home" href="../index.php"><span>Home</span></a></li>
									<li><a class="icon fa-retweet" href="about_us.php"><span>About Us</span></a></li>
									<li><a class="icon fa-sitemap" href="contact_us.php"><span>Contact Us</span></a></li>
									<li><a class="icon fa-plus" href="signup.php"><span>Sign Up</span></a></li>
									<li><a class="icon fa-male" href="login.php"><span>Log In</span></a></li>
								</ul>
							</nav>

					</div>
				</div>

								<!--Sign Up -->
				<div id="main-wrapper">
					<div id="main" class="container" align="center">
						<header>
							<h2>Sign Up</h2>
						</header>
						<div>
							<div class="6u 12u(mobile)">
								<section align="center" >
									<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    
    $link = mysqli_connect("localhost", "root", "", "test");

	if (!$link) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}
	if ($password == $passwordConfirm) {
		$sql = "INSERT INTO Users (USERNAME, EMAIL, PASS)
	VALUES (" + $username + ", "+ $email + ", " + $password + ")";
		if (mysqli_query($conn, $sql)) {
	    	echo "New record created successfully";
		} else {
	    	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	else {
		echo "not equal";
	}
	
	mysqli_close($link);
}
?>
									<form method="post" action="../li/index.php">
										<div class="row">
											<div class="12u">
												<input name="username" placeholder="Username" type="text" />
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="email" placeholder="Email" type="email" />
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="password" placeholder="Password" type="password" />
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="passwordConfirm" placeholder="Confirm Password" type="text" />
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="submit" type="submit" class="form-button-submit button icon fa-sign-in"/>
												<!--<a href="../li/index.php" class="form-button-submit button icon fa-sign-in">Sign Up</a>-->
											</div>
										</div>
										<?php
$link = mysqli_connect("localhost", "root", "", "test");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);
?>
									</form>
								</section>
							</div>
						</div>
					</div>
					<div id="copyright" class="container">
						<ul class="links">
							<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</div>
				</div>

		</div>
		
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/skel-viewport.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>