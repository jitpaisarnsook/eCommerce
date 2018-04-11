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
		<meta http-equiv="refresh" content="10"/>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body class="homepage">
		<div id="page-wrapper">

			<?php include("base_li.php"); ?>

			<div id="features-wrapper">
					<section id="features" class="container">
						<header>
							<?php
							echo "<h2><strong>Welcome to Meme Market, ". $_SESSION['username'] ."!</strong></h2>";
							?>
						</header>
					</section>
				</div>

			<!-- Features -->
				<div id="features-wrapper">
					<section id="features" class="container">
						<header>
							<h3><strong>Popular Meme Products</strong></h3>
							<?php
                            $response = file_get_contents('http://test.bitpay.com/rates/BTC/USD');
                            $response = json_decode($response, true);
                            $GLOBALS['rate'] = $response["data"]["rate"];
                            echo '<p> 1 Bitcoin = $'.$GLOBALS["rate"].'</p>';
                            ?>
						</header>
						<div class="row">

						    <?php
                                if (isset($_POST['submit'])) {
                                    $username = $_SESSION["username"];

                                    $amount = $_POST['amount'];
                                    $price = $_POST['price'];

                                    $db = "test";
                                    $link = mysqli_connect("localhost", "root", "", "test");
                                    $mysqli = new mysqli("localhost", "root", "", "test");
                                    $name = mysqli_real_escape_string($link, $_POST['name']);

                                    if (!$link) {
                                        echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                        exit;
                                    }
                                    $sql = "SELECT AMOUNT FROM cart WHERE USERNAME='$username' AND NAME='$name' LIMIT 1;";
                                    $result = mysqli_query($link, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $data = $row['AMOUNT'];

                                    if ($data > 0) {
                                        $new_amount = $amount + $data;
                                        echo $data;
                                        echo $amount;
                                        echo $new_amount;
                                        $statement = "UPDATE cart SET AMOUNT='$new_amount' WHERE USERNAME='$username' AND NAME='$name';";
                                        if ($result2=mysqli_query($link , $statement)){
                                            header("Location: ../li/cart.php");
                                            exit;
                                        }
                                        else {
                                            echo mysqli_error($link);
                                        }
                                    }
                                    else {
                                        $statement = "INSERT INTO cart (USERNAME, NAME, AMOUNT)
                                            VALUES ('$username','$name','$amount');";
                                        if ($result2=mysqli_query($link , $statement)){
                                            header("Location: ../li/cart.php");
                                            exit;
                                        }
                                        else {
                                            echo mysqli_error($link);
                                        }
                                        mysqli_close($link);
                                    }
                                }
                                else if (isset($_GET['checkout'])) {
                                	if ($_GET['checkout']==="true") {
		                                $username = $_SESSION["username"];
		                                $link = mysqli_connect("localhost", "root", "", "test");
		                                $statement = "DELETE FROM cart WHERE USERNAME='$username';";
		                                if ($result=mysqli_query($link , $statement)){
		                                    $_SESSION['username'] = $username;
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

		                                    $link = mysqli_connect("localhost", "root", "", "test");
		                                    $mysqli = new mysqli("localhost", "root", "", "test");
		                                    $overall_price = 0;
		                                    $overall_amount = 0;
		                                    $total_price = 0;
		                                    $query = "SELECT EMAIL FROM users WHERE USERNAME='$username'";
		                                    $result = mysqli_query($link, $query);
		                                    if (!$result) {
		                                        printf("Error: %s\n", mysqli_error($link));
		                                        exit();
		                                    }
		                                    $email = '';

		                                    while($row = mysqli_fetch_array($result)){
		                                        $email = $row['EMAIL'];
		                                    }
		                                    $mail->setFrom('contactmememarket@gmail.com', 'Meme Market');
		                                    $mail->addAddress($email);

		                                    $mail->isHTML(true);                                  // Set email format to HTML

		                                    $mail->Subject = 'Meme Market Purchase';
		                                    $mail->Body    = 'Thank you for buying a meme from Meme Market! Show the world your meme potential! -Meme Market';
		                                    if(!$mail->send()) {
		                                        echo 'Message could not be sent.';
		                                        echo 'Mailer Error: ' . $mail->ErrorInfo;
		                                    } else {
		                                        header("Location: ../li/index.php");
		                                        exit;
		                                    }
	                                	}
	                                }
	                            }
                                ?>
							<div class="4u 12u(mobile)">

								<!-- Feature -->
									<section>
										<a href="#" class="image featured"><img src="../images/ugandaKnuckles.png" alt="" /></a>
										<header>
											<h3>Ugandan Knuckles</h3>
										</header>
										<p>Do you know de wey?</p>
										<header>
											<h4>$7.99</h4>
										    <?php
										    $bitvalue = number_format(7.99 / $GLOBALS['rate'], 6);
										    echo '<h4>'.$bitvalue.' BTC</h4>';
										    ?>
										</header>
										<form method="post">
                                            <input type="hidden" name="name" value="Ugandan Knuckles">

                                            <input type="hidden" name="price" value="7.99">
                                            <div class="row">
                                                <div class="12u">
                                                    <input type="number" name="amount" min="1" value="1" style="text-align: right; width: 40px;" required/>
                                                    <input name="submit" type="submit" value="Add to Cart" class="form-button-submit button"/>
                                                </div>
                                            </div>
										</form>
									</section>

							</div>
							<div class="4u 12u(mobile)">

								<!-- Feature -->
									<section>
										<a href="#" class="image featured"><img src="../images/pickleRick.jpg" alt="" /></a>
										<header>
											<h3>Pickle Rick</h3>
										</header>
										<p>PICKLE RICK IS IN THE HOUSE TONIGHT</p>
										<header>
											<h4>$4.20</h4>
											<?php
										    $bitvalue = number_format(4.20 / $GLOBALS['rate'], 6);
										    echo '<h4>'.$bitvalue.' BTC</h4>';
										    ?>
										</header>
										<form method="post">
                                            <input type="hidden" name="name" value="Pickle Rick">
                                            <input type="hidden" name="price" value="4.20">
                                            <div class="row">
                                                <div class="12u">
                                                    <input type="number" name="amount" min="1" value="1" style="text-align: right; width: 40px;" required/>
                                                    <input name="submit" type="submit" value="Add to Cart" class="form-button-submit button"/>
                                                </div>
                                            </div>
										</form>
									</section>

							</div>
							<div class="4u 12u(mobile)">

								<!-- Feature -->
									<section>
										<a href="#" class="image featured"><img src="../images/guessilldie.jpg" alt="" /></a>
										<header>
											<h3>Guess I'll Die</h3>
										</header>
										<p>Mike Baldwin Shrugging</p>
										<header>
											<h4>$9.99</h4>
											<?php
										    $bitvalue = number_format(9.99 / $GLOBALS['rate'], 6);
										    echo '<h4>'.$bitvalue.' BTC</h4>';
										    ?>
										</header>
										<form method="post">
                                            <input type="hidden" name="name" value="Guess I'll Die">
                                            <input type="hidden" name="price" value="9.99">
                                            <div class="row">
                                                <div class="12u">
                                                    <input type="number" name="amount" min="1" value="1" style="text-align: right; width: 40px;" required/>
                                                    <input name="submit" type="submit" value="Add to Cart" class="form-button-submit button"/>
                                                </div>
                                            </div>
										</form>
									</section>

							</div>
						</div>
						<ul class="actions">
							<li><a href="#" class="button icon fa-file">View More</a></li>
						</ul>
					</section>
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