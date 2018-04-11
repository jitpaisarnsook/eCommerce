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
						    <?php
						        echo '<h2><strong>'.$_SESSION["username"].'</strong></h2>';
						    ?>
						</header>
                            <?php
                                $username = $_SESSION['username'];
                                $link = mysqli_connect("localhost", "root", "", "test");
                                $mysqli = new mysqli("localhost", "root", "", "test");

                                $query = "SELECT NAME, EMAIL, STATE, CITY, ADDRESS, ZIP FROM users WHERE USERS.USERNAME='$username'";
                                $result = mysqli_query($link, $query);
                                if (!$result) {
                                    printf("Error: %s\n", mysqli_error($link));
                                    exit();
                                }

                                while($row = mysqli_fetch_array($result)){
                                    $GLOBALS['NAME'] = $row['NAME'];
                                    $GLOBALS['EMAIL'] = $row['EMAIL'];
                                    $GLOBALS['STATE'] = $row['STATE'];
                                    $GLOBALS['CITY'] = $row['CITY'];
                                    $GLOBALS['ADDRESS'] = $row['ADDRESS'];
                                    $GLOBALS['ZIP'] = $row['ZIP'];
                                }
                            ?>
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
        $sql = $sql = "UPDATE Users
					        SET NAME='$name', EMAIL='$email', CITY='$city', STATE='$state', ADDRESS='$address', ZIP='$zip' WHERE USERNAME='$username'";
        if (mysqli_query($link, $sql)) {
            header("Location: profile.php");
            exit;
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
                                <input type="hidden" name="username" placeholder="Username" type="text" value="<?php echo $_SESSION['username']; ?>"/>
                                <div class="row">
                                    <div class="12u">
                                        <input name="name" placeholder="Name (First and Last)" type="text" value="<?php echo $GLOBALS['NAME']; ?>" pattern="[a-zA-Z][a-zA-Z ]{2,}" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="12u">
                                        <input name="email" placeholder="Email" type="email" required value="<?php echo $GLOBALS['EMAIL']; ?>" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="12u">
                                        <input name="address" placeholder="Street Address" type="text" value="<?php echo $GLOBALS['ADDRESS']; ?>" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="12u">
                                        <input name="city" placeholder="City" type="text" value="<?php echo $GLOBALS['CITY']; ?>" required/>
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
                                                echo '<option value="' . $key . '"' . ($GLOBALS["STATE"] == $key ? ' selected="selected"' : '') . '>' . $value . '</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="12u">
                                        <input name="zip" placeholder="5 Digit ZIP" type="text" maxlength="5" pattern=".{5,}" value="<?php echo $GLOBALS['ZIP']; ?>"/>
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