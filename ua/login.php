<!DOCTYPE HTML>
<?php
session_start();
setcookie(session_name(), session_id(), NULL, '/');
?>
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="homepage">
		<div id="page-wrapper">

			<?php include("base_ua.php"); ?>

				<!--Log in -->
				<div id="main-wrapper">
					<div id="main" class="container" align="center">
						<header>
							<h2>Log In</h2>
						</header>
						<div>
							<div class="6u 12u(mobile)">
								<section align="center" >
									<?php
									if (isset($_POST['submit'])) {
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];

                                        $link = mysqli_connect("localhost", "root", "", "test");

                                        if (!$link) {
                                            echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                            exit;
                                        }

                                        $sql = "SELECT PASS
                                            FROM Users
                                            WHERE USERNAME='$username';";
                                        $result = $link->query($sql);
                                        $data = $result->fetch_assoc();
                                        if (password_verify($password, implode("|",$data))) {
                                            $_SESSION['username'] = $username;
                                            header("Location: ../li/index.php");
                                            exit;
                                        }
                                        else {
                                            echo "Username or password is not correct.";
                                        }

                                        mysqli_close($link);
                                    }
                                    ?>
									<form method="post">
										<div class="row">
											<div class="12u">
												<input name="username" placeholder="Username" type="text" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="password" placeholder="Password" type="password" pattern=".{5,}" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="submit" type="submit" class="form-button-submit button icon fa-sign-in"/>
											</div>
										</div>
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