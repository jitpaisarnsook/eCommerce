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
			<?php include("base_li.php");?>

			<!-- Features -->
				<div id="features-wrapper">
					<section id="features" class="container">
						<header>
							<h2><strong>Your Cart</strong></h2>
						</header>
						<?php
                            if (isset($_POST['submit'])) {
                                $username = $_SESSION["username"];
                                $link = mysqli_connect("localhost", "root", "", "test");
                                $name = mysqli_real_escape_string($link, $_POST['name']);
                                $statement = "DELETE FROM cart WHERE USERNAME='$username' AND NAME='$name';";
                                if ($result=mysqli_query($link , $statement)){
                                    header("Location: ../li/cart.php?username=".$username."");
                                    exit;
                                }
                                else {
                                    echo mysqli_error($link);
                                }
                            }
                            // else if (isset($_POST['checkout'])) {
                            //     $username = $_SESSION["username"];
                            //     $link = mysqli_connect("localhost", "root", "", "test");
                            //     $statement = "DELETE FROM cart WHERE USERNAME='$username';";
                            //     if ($result=mysqli_query($link , $statement)){
                            //         $_SESSION['username'] = $username;
                            //         require '../PHPMailer/src/PHPMailerAutoload.php';
                            //         require '../PHPMailer/src/Exception.php';
                            //         require '../PHPMailer/src/PHPMailer.php';
                            //         require '../PHPMailer/src/SMTP.php';

                            //         $mail = new PHPMailer\PHPMailer\PHPMailer();

                            //         //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                            //         $mail->IsSMTP(); // enable SMTP
                            //         $mail->SMTPAuth = true; // authentication enabled
                            //         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                            //         $mail->Host = "smtp.gmail.com";
                            //         $mail->Port = 465; // or 587
                            //         $mail->IsHTML(true);
                            //         $mail->Username = "contactmememarket@gmail.com";
                            //         $mail->Password = "password123!";

                            //         $link = mysqli_connect("localhost", "root", "", "test");
                            //         $mysqli = new mysqli("localhost", "root", "", "test");
                            //         $overall_price = 0;
                            //         $overall_amount = 0;
                            //         $total_price = 0;
                            //         $query = "SELECT EMAIL FROM users WHERE USERNAME='$username'";
                            //         $result = mysqli_query($link, $query);
                            //         if (!$result) {
                            //             printf("Error: %s\n", mysqli_error($link));
                            //             exit();
                            //         }
                            //         $email = '';

                            //         while($row = mysqli_fetch_array($result)){
                            //             $email = $row['EMAIL'];
                            //         }
                            //         $mail->setFrom('contactmememarket@gmail.com', 'Meme Market');
                            //         $mail->addAddress($email);

                            //         $mail->isHTML(true);                                  // Set email format to HTML

                            //         $mail->Subject = 'Meme Market Purchase';
                            //         $mail->Body    = 'Thank you for buying a meme from Meme Market! Show the world your meme potential! -Meme Market';
                            //         if(!$mail->send()) {
                            //             echo 'Message could not be sent.';
                            //             echo 'Mailer Error: ' . $mail->ErrorInfo;
                            //         } else {
                            //             header("Location: ../li/cart.php?username=".$username."");
                            //             exit;
                            //         }
                            //     }
                            //     else {
                            //         echo mysqli_error($link);
                            //     }
                            // }
                        ?>
						<table class="table table-bordered">
						    <thead>
                                <tr bgcolor='#ED786A'>
                                    <th class="text-center"><strong>Meme Name</strong></th>
                                    <th class="text-center"><strong>Amount</strong></th>
                                    <th class="text-center"><strong>Delete</strong></th>
                                    <th class="text-center"><strong>Price</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $username = $_SESSION['username'];
                                $link = mysqli_connect("localhost", "root", "", "test");
                                $mysqli = new mysqli("localhost", "root", "", "test");
                                $overall_price = 0;
                                $overall_amount = 0;
                                $total_price = 0;
                                $query = "SELECT MEMES.NAME, AMOUNT, PRICE FROM users, memes, cart WHERE USERS.USERNAME='$username' AND USERS.USERNAME=CART.USERNAME AND CART.NAME=MEMES.NAME";
                                $result = mysqli_query($link, $query);
                                if (!$result) {
                                    printf("Error: %s\n", mysqli_error($link));
                                    exit();
                                }

                                while($row = mysqli_fetch_array($result)){
                                    $total_price = $row['AMOUNT'] * $row['PRICE'];
                                    $total_format_price = number_format((float)$total_price, 2, '.', '');
                                    $overall_price += $total_price;
                                    $overall_amount += $row['AMOUNT'];
                                    echo '<tr><td>' . $row["NAME"] . '</td><td>' . $row["AMOUNT"] . '</td><td><form method="post"><input type="hidden" name="name" value="'. $row["NAME"] . '"><input name="submit" type="submit" value="Delete" class="form-button-submit button"/></form></td><td>$' . $total_format_price . '</td></tr>';
                                }
                                $overall_price = number_format((float)$overall_price, 2, '.', '');
                                echo "<tr bgcolor='#FFC5B7'><td> Total </td><td>" . $overall_amount . "</td><td></td><td>$" . $overall_price . "</td></tr>";
                            ?>
                            </tbody>
                        </table>
                            <form action="https://test.bitpay.com/checkout" method="post">
                                <input type="hidden" name="action" value="checkout" />
                                <input type="hidden" name="posData" value="" />
                                <input type="hidden" name="price" value="<?php echo $overall_price;?>" />
                                <input type="hidden" name="data" value="gMCfANQ3fR9Dp9/AcXVGUz1ao6QkotSXFgBPxER+fBLcOmXXLvS1XSqF8LveA5S97nGS6hCgG0SiPzwuf2MpXbV7fa50ZtPGp8Ta/r+zCkmjU5IePzGdVd+bk8FMpeRFqNRJphSGVM4qgxYIZCw4J+FsyDAyvG8rWn6MpVdpLAu+Rt9LkM2TZXp4bVlT95YY" />
                                <input name="checkout" type="submit" value="Checkout" class="form-button-submit button"/>
                            </form>
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