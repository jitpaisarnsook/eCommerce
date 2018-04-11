<!-- Header -->
				<div id="header-wrapper">
					<div id="header" class="container">

						<!-- Logo -->
							<img src="../images/MemeMarket.png" height=250 alt="" />
                        <?php
                        session_start();
                        setcookie(session_name(), session_id(), NULL, '/');
                        $username = $_SESSION['username'];
                        if (!isset($_SESSION['username']))
						{
						    $query = "SELECT username from users where username='$username'";
						    $link = mysqli_connect("localhost", "root", "", "test");
							$result = mysqli_query($link, $query);

							if(mysqli_num_rows($result) === 0)
							{
							    session_destroy();
							    header("Location: ../ua/login.php");
	                            exit;
							}
						}
                        //$_SESSION['username'] = $_GET['username'];
                        // document.write('<?php session_destroy() >'); ?username=' . $_SESSION["username"] . '
                        if (isset($_POST['logout'])) {
						    session_destroy();
						    header("Location: ../index.php");
                            exit;
						}
                        ?>
						<!-- Nav -->
							<nav id="nav">
								<ul>
								    <?php
								    echo '<li><a class="icon fa-home" href="index.php"><span>Home</a></li>';
                                    echo '<li><a class="icon fa-retweet" href="about_us.php"><span>About Us</a></li>';
                                    echo '<li><a class="icon fa-sitemap" href="contact_us.php"><span>Contact Us</a></li>';
                                    echo '<li><a class="icon fa-shopping-cart" href="cart.php"><span>Shopping Cart</a></li>';
                                    echo '<li><a class="icon fa-user" href="profile.php"><span>My Profile</a></li>';
                                    ?>
                                    <li>
									    <form method="POST">
                                    		<input name="logout" type="submit" value="Logout" onclick="return confirm('Are you sure?');" class="form-button-submit button icon fa-sign-out">
                                    	</form>
                                    </li>
									<!--<li><a href="../ua/login.php" class="icon fa-sign-out" onclick="return confirm('Are you sure?');"><span>Log Out</span></a></li>-->
								</ul>
							</nav>

					</div>
				</div>

				<!-- <li><a class="icon fa-home" href="index.php"><span>Home</span></a></li>
									<li><a class="icon fa-retweet" href="about_us.php"><span>About Us</span></a></li>
									<li><a class="icon fa-sitemap" href="contact_us.php"><span>Contact Us</span></a></li>
									<?php
									echo '<li><a class="icon fa-shopping-cart" href="cart.php?username="><span>'.$_SESSION['username']."'s Cart</a></li>"; ?>
									-->