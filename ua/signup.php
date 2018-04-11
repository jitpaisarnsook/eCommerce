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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $address = $_POST['address'];
    
    $link = mysqli_connect("localhost", "root", "", "test");

	if (!$link) {
	    echo "Error: Unable to connect to MySQL." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}

	$errors = array();
	$error_count = 0;
	if (!($password === $passwordConfirm)){
	    array_push($errors, "Passwords do not match! Please make sure the Password and Password Confirmation fields match.");
	    $error_count += 1;
	}
	if (!(preg_match('/^\w{3,20}$/', $username) == True)){
	    array_push($errors, "Username must be between 3 and 20 characters and can only contain the letters A-Z (upper or lower case), numbers, and underscores.");
	    $error_count += 1;
	}
	if (!(preg_match('/^[A-Za-z]+\s[A-Za-z]+$/', $name) == True)){
	    array_push($errors, "Name must be in format 'Firstname Lastname', with a single whitespace between first and last name and only alphabetical charactes in the names.");
	    $error_count += 1;
	}
	if (!(preg_match('/^[A-Za-z.\s]+[A-Za-z.]+$/', $city) == True)){
	    array_push($errors, "Invalid city name.");
	    $error_count += 1;
	}
	if (!(filter_var($email, FILTER_VALIDATE_EMAIL))){
	    array_push($errors, "Email is invalid - please make sure it is in the format 'email@sitename.domain'");
	    $error_count += 1;
	}
	if (!(preg_match('/^[a-zA-Z0-9-. ]+$/', $address) == True)){
	    array_push($errors, "Please enter a valid street address.");
	    $error_count += 1;
	}
	if (!(strlen($zip) == 5 && ctype_digit($zip) == True)){
	    array_push($errors, "ZIP code must be a 5-digit number.");
	    $error_count += 1;
	}

    if ($error_count === 0){
        $sql = $sql = "INSERT INTO Users (USERNAME, NAME, EMAIL, PASS, CITY, STATE, ADDRESS, ZIP)
					        VALUES ('$username','$name','$email','$hashed_password', '$city', '$state', '$address', '$zip')";
        if (mysqli_query($link, $sql)) {
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

            $mail->setFrom('contactmememarket@gmail.com', 'Meme Market');
            $mail->addAddress($email);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Meme Market Registration';
            $mail->Body    = 'Thank you for signing up for Meme Market! We hope you find the website useful for all your memeing endeavors. -Meme Market';
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                header("Location: ../li/index.php");
                exit;
            }
        } else {
            echo mysqli_error($link);
        }
    }

    else {
        for ($i = 0; $i < count($errors); $i++){
           echo $errors[$i] . "\n";
        }
    }
	
	mysqli_close($link);
}
?>
									<form method="post" >
										<div class="row">
											<div class="12u">
												<input name="username" placeholder="Username" type="text" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="name" placeholder="Name (First and Last)" type="text" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" pattern="[a-zA-Z][a-zA-Z ]{2,}" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="email" placeholder="Email" type="email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="password" placeholder="Password (at least 5 characters)" type="password" pattern=".{5,}" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="passwordConfirm" placeholder="Confirm Password" pattern=".{5,}" type="password" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="address" placeholder="Street Address" type="text" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : ''; ?>" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="city" placeholder="City" type="text" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" required/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
                                                <select name="state" required>
                                                    <option selected="selected" disabled="disabled">State</option>
                                                    <?php
                                                    $states = array(
                                                        'AL'=>'Alabama',
                                                        'AK'=>'Alaska',
                                                        'AZ'=>'Arizona',
                                                        'AR'=>'Arkansas',
                                                        'CA'=>'California',
                                                        'CO'=>'Colorado',
                                                        'CT'=>'Connecticut',
                                                        'DE'=>'Delaware',
                                                        'DC'=>'District of Columbia',
                                                        'FL'=>'Florida',
                                                        'GA'=>'Georgia',
                                                        'HI'=>'Hawaii',
                                                        'ID'=>'Idaho',
                                                        'IL'=>'Illinois',
                                                        'IN'=>'Indiana',
                                                        'IA'=>'Iowa',
                                                        'KS'=>'Kansas',
                                                        'KY'=>'Kentucky',
                                                        'LA'=>'Louisiana',
                                                        'ME'=>'Maine',
                                                        'MD'=>'Maryland',
                                                        'MA'=>'Massachusetts',
                                                        'MI'=>'Michigan',
                                                        'MN'=>'Minnesota',
                                                        'MS'=>'Mississippi',
                                                        'MO'=>'Missouri',
                                                        'MT'=>'Montana',
                                                        'NE'=>'Nebraska',
                                                        'NV'=>'Nevada',
                                                        'NH'=>'New Hampshire',
                                                        'NJ'=>'New Jersey',
                                                        'NM'=>'New Mexico',
                                                        'NY'=>'New York',
                                                        'NC'=>'North Carolina',
                                                        'ND'=>'North Dakota',
                                                        'OH'=>'Ohio',
                                                        'OK'=>'Oklahoma',
                                                        'OR'=>'Oregon',
                                                        'PA'=>'Pennsylvania',
                                                        'RI'=>'Rhode Island',
                                                        'SC'=>'South Carolina',
                                                        'SD'=>'South Dakota',
                                                        'TN'=>'Tennessee',
                                                        'TX'=>'Texas',
                                                        'UT'=>'Utah',
                                                        'VT'=>'Vermont',
                                                        'VA'=>'Virginia',
                                                        'WA'=>'Washington',
                                                        'WV'=>'West Virginia',
                                                        'WI'=>'Wisconsin',
                                                        'WY'=>'Wyoming',
                                                    );
                                                    foreach($states as $key => $value):
                                                        echo '<option value="' . $key . '"' . (isset($_POST["state"]) && $_POST["state"] == $key ? ' selected="selected"' : '') . '>' . $value . '</option>';
                                                    endforeach;
                                                    ?>
                                                </select>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="zip" placeholder="5 Digit ZIP" type="text" maxlength="5" pattern=".{5,}" value="<?php echo isset($_POST["zip"]) ? $_POST["zip"] : ''; ?>"/>
											</div>
										</div>
										<div class="row">
											<div class="12u">
												<input name="submit" type="submit" class="form-button-submit button icon fa-sign-in"/>
												<!--<a href="../li/index.php" class="form-button-submit button icon fa-sign-in">Sign Up</a>-->
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
<!--
<select name="state" required>
												    <option selected="selected" disabled="disabled">State</option
                                                    <option value="AL" <?= isset($_POST['state']) == 'AL' ? 'selected' : '' ?>>Alabama</option>
                                                    <option value="AK" <?= isset($_POST['state']) == 'AK' ? 'selected' : '' ?>>Alaska</option>
                                                    <option value="AZ" <?= isset($_POST['state']) == 'AZ' ? 'selected' : '' ?>>Arizona</option>
                                                    <option value="AR" <?= isset($_POST['state']) == 'AR' ? 'selected' : '' ?>>Arkansas</option>
                                                    <option value="CA" <?= isset($_POST['state']) == 'CA' ? 'selected' : '' ?>>California</option>
                                                    <option value="CO" <?= isset($_POST['state']) == 'CO' ? 'selected' : '' ?>>Colorado</option>
                                                    <option value="CT" <?= isset($_POST['state']) == 'CT' ? 'selected' : '' ?>>Connecticut</option>
                                                    <option value="DE" <?= isset($_POST['state']) == 'DE' ? 'selected' : '' ?>>Delaware</option>
                                                    <option value="DC" <?= isset($_POST['state']) == 'DC' ? 'selected' : '' ?>>District Of Columbia</option>
                                                    <option value="FL" <?= isset($_POST['state']) == 'FL' ? 'selected' : '' ?>>Florida</option>
                                                    <option value="GA" <?= isset($_POST['state']) == 'GA' ? 'selected' : '' ?>>Georgia</option>
                                                    <option value="HI" <?= isset($_POST['state']) == 'HI' ? 'selected' : '' ?>>Hawaii</option>
                                                    <option value="ID" <?= isset($_POST['state']) == 'ID' ? 'selected' : '' ?>>Idaho</option>
                                                    <option value="IL" <?= isset($_POST['state']) == 'IL' ? 'selected' : '' ?>>Illinois</option>
                                                    <option value="IN" <?= isset($_POST['state']) == 'IN' ? 'selected' : '' ?>>Indiana</option>
                                                    <option value="IA" <?= isset($_POST['state']) == 'IA' ? 'selected' : '' ?>>Iowa</option>
                                                    <option value="KS" <?= isset($_POST['state']) == 'KS' ? 'selected' : '' ?>>Kansas</option>
                                                    <option value="KY" <?= isset($_POST['state']) == 'KY' ? 'selected' : '' ?>>Kentucky</option>
                                                    <option value="LA" <?= isset($_POST['state']) == 'LA' ? 'selected' : '' ?>>Louisiana</option>
                                                    <option value="ME" <?= isset($_POST['state']) == 'ME' ? 'selected' : '' ?>>Maine</option>
                                                    <option value="MD" <?= isset($_POST['state']) == 'MD' ? 'selected' : '' ?>>Maryland</option>
                                                    <option value="MA" <?= isset($_POST['state']) == 'MA' ? 'selected' : '' ?>>Massachusetts</option>
                                                    <option value="MI" <?= isset($_POST['state']) == 'MI' ? 'selected' : '' ?>>Michigan</option>
                                                    <option value="MN" <?= isset($_POST['state']) == 'MN' ? 'selected' : '' ?>>Minnesota</option>
                                                    <option value="MS" <?= isset($_POST['state']) == 'MS' ? 'selected' : '' ?>>Mississippi</option>
                                                    <option value="MO" <?= isset($_POST['state']) == 'MO' ? 'selected' : '' ?>>Missouri</option>
                                                    <option value="MT" <?= isset($_POST['state']) == 'MT' ? 'selected' : '' ?>>Montana</option>
                                                    <option value="NE" <?= isset($_POST['state']) == 'NE' ? 'selected' : '' ?>>Nebraska</option>
                                                    <option value="NV" <?= isset($_POST['state']) == 'NV' ? 'selected' : '' ?>>Nevada</option>
                                                    <option value="NH" <?= isset($_POST['state']) == 'NH' ? 'selected' : '' ?>>New Hampshire</option>
                                                    <option value="NJ" <?= isset($_POST['state']) == 'NJ' ? 'selected' : '' ?>>New Jersey</option>
                                                    <option value="NM" <?= isset($_POST['state']) == 'NM' ? 'selected' : '' ?>>New Mexico</option>
                                                    <option value="NY" <?= isset($_POST['state']) == 'NY' ? 'selected' : '' ?>>New York</option>
                                                    <option value="NC" <?= isset($_POST['state']) == 'NC' ? 'selected' : '' ?>>North Carolina</option>
                                                    <option value="ND" <?= isset($_POST['state']) == 'ND' ? 'selected' : '' ?>>North Dakota</option>
                                                    <option value="OH" <?= isset($_POST['state']) == 'OH' ? 'selected' : '' ?>>Ohio</option>
                                                    <option value="OK" <?= isset($_POST['state']) == 'OK' ? 'selected' : '' ?>>Oklahoma</option>
                                                    <option value="OR" <?= isset($_POST['state']) == 'OR' ? 'selected' : '' ?>>Oregon</option>
                                                    <option value="PA" <?= isset($_POST['state']) == 'PA' ? 'selected' : '' ?>>Pennsylvania</option>
                                                    <option value="RI" <?= isset($_POST['state']) == 'RI' ? 'selected' : '' ?>>Rhode Island</option>
                                                    <option value="SC" <?= isset($_POST['state']) == 'SC' ? 'selected' : '' ?>>South Carolina</option>
                                                    <option value="SD" <?= isset($_POST['state']) == 'SD' ? 'selected' : '' ?>>South Dakota</option>
                                                    <option value="TN" <?= isset($_POST['state']) == 'TN' ? 'selected' : '' ?>>Tennessee</option>
                                                    <option value="TX" <?= isset($_POST['state']) == 'TX' ? 'selected' : '' ?>>Texas</option>
                                                    <option value="UT" <?= isset($_POST['state']) == 'UT' ? 'selected' : '' ?>>Utah</option>
                                                    <option value="VT" <?= isset($_POST['state']) == 'VT' ? 'selected' : '' ?>>Vermont</option>
                                                    <option value="VA" <?= isset($_POST['state']) == 'VA' ? 'selected' : '' ?>>Virginia</option>
                                                    <option value="WA" <?= isset($_POST['state']) == 'WA' ? 'selected' : '' ?>>Washington</option>
                                                    <option value="WV" <?= isset($_POST['state']) == 'WV' ? 'selected' : '' ?>>West Virginia</option>
                                                    <option value="WI" <?= isset($_POST['state']) == 'WI' ? 'selected' : '' ?>>Wisconsin</option>
                                                    <option value="WY" <?= isset($_POST['state']) == 'WY' ? 'selected' : '' ?>>Wyoming</option>
                                                </select> -->