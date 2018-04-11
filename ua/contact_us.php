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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="homepage">
		<div id="page-wrapper">

			<?php include("base_ua.php"); ?>

			<!-- Footer -->
				<!--<div id="main-wrapper">-->
					<div id="main" class="container">
						<header>
							<h2>Questions or comments? <strong>Get in touch:</strong></h2>
						</header>
						<div class="row">
							<div class="6u 12u(mobile)">
								<section>
								    <?php
                                    if (isset($_POST['send'])) {
                                        require '../PHPMailer/src/PHPMailerAutoload.php';
                                        require '../PHPMailer/src/Exception.php';
                                        require '../PHPMailer/src/PHPMailer.php';
                                        require '../PHPMailer/src/SMTP.php';

                                        $mail = new PHPMailer\PHPMailer\PHPMailer();

                                        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                                        $mail->IsSMTP(); // enable SMTP
                                        $mail->SMTPAuth = true; // authentication enabled
                                        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                                        $mail->Host = "smtp.gmail.com";
                                        $mail->Port = 465; // or 587
                                        $mail->IsHTML(true);
                                        $mail->Username = "contactmememarket@gmail.com";
                                        $mail->Password = "password123!";

                                        $mail->setFrom($_POST['email'], $_POST['name']);
                                        $mail->addAddress('contactmememarket@gmail.com', 'Meme Market');

                                        $mail->isHTML(true);                                  // Set email format to HTML

                                        $mail->Subject = 'Website Contact';
                                        $mail->Body    = $_POST['message'];

                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
                                    }
                                    ?>
									<form method="post" action="#">
										<div class="row 50%">
											<div class="6u 12u(mobile)">
												<input name="name" placeholder="Name" type="text" />
											</div>
											<div class="6u 12u(mobile)">
												<input name="email" placeholder="Email" type="text" />
											</div>
										</div>
										<div class="row 50%">
											<div class="12u">
												<textarea name="message" placeholder="Message"></textarea>
											</div>
										</div>
										<div class="row 50%">
											<div class="12u">
												<input name="send" type="submit" value="Send Message" class="form-button-submit button icon fa-envelope">
											</div>
										</div>
									</form>
								</section>
							</div>
							<div class="6u 12u(mobile)">
								<section>
									<p></p>
									<div class="row">
										<div class="6u 12u(mobile)">
											<ul class="icons">
												<li class="icon fa-home">
													420 Dank Street<br />
													Chicken, AK 99732<br />
													USA
												</li>
												<li class="icon fa-phone">
													(420) 777-6969
												</li>
												<li class="icon fa-envelope">
													<a href="#">contactmememarket@gmail.com</a>
												</li>
											</ul>
										</div>
										<div class="6u 12u(mobile)">
											<ul class="icons">
												<li class="icon fa-twitter">
													<a href="#">@FpTc_Productions</a>
												</li>
												<li class="icon fa-instagram">
													<a href="#">instagram.com/Dank_Memes_For_the_Soul</a>
												</li>
												<li class="icon fa-dribbble">
													<a href="#">dribbble.com/Bigger_Baller_Brand</a>
												</li>
												<li class="icon fa-facebook">
													<a href="#">facebook.com/FpTc_Clan</a>
												</li>
											</ul>
										</div>
									</div>
								</section>
							</div>
						</div>
					</div>
					<div id="copyright" class="container">
						<ul class="links">
							<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</div>
				<!--</div>-->

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