<?php
	include("addons/config.php");
	include("addons/classes/Account.php");
	include("addons/classes/Constants.php");

	$account = new Account($con);

	include("addons/handlers/register-handler.php");
	include("addons/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="icon" href="assets/images/logo-svg.svg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;800&display=swap" rel="stylesheet">
    <title>Welcome to Nexus Music!</title>

    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <link rel="stylesheet" type="text/css" href="assets/css/register-mobile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>

<body>
    <?php

	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>


    <div id="background">
        <div id="whole">
            <div id="loginContainer">

                <div id="inputContainer">
                    <form id="loginForm" action="register.php" method="POST">
                        <h2>Login to your account</h2>
                        <p>
                            <?php echo $account->getError(Constants::$loginFailed); ?>
                            <label for="loginUsername">Username</label>
                            <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>" spellcheck="false" required>
                        </p>
                        <p>
                            <label for="loginPassword">Password</label>
                            <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" spellcheck="false" required>
                        </p>

                        <button type="submit" name="loginButton">LOG IN</button>

                        <div class="hasAccountText">
                            <span id="hideLogin">Don't have an account? <b>SignUp here.</b></span>
                        </div>

                    </form>



                    <form id="registerForm" action="register.php" method="POST">
                        <h2>Create your free account</h2>
                        <p>
                            <?php echo $account->getError(Constants::$usernameCharacters); ?>
                            <?php echo $account->getError(Constants::$usernameTaken); ?>
                            <label for="username">Username</label>
                            <input id="username" name="username" type="text" placeholder="e.g. bartSimpson" spellcheck="false" value="<?php getInputValue('username') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                            <label for="firstName">First name</label>
                            <input id="firstName" name="firstName" type="text" placeholder="e.g. Bart" spellcheck="false" value="<?php getInputValue('firstName') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                            <label for="lastName">Last name</label>
                            <input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" spellcheck="false" value="<?php getInputValue('lastName') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$emailInvalid); ?>
                            <?php echo $account->getError(Constants::$emailTaken); ?>
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" spellcheck="false" value="<?php getInputValue('email') ?>" required>
                        </p>

                        <p>
                            <label for="email2">Confirm email</label>
                            <input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com" spellcheck="false" value="<?php getInputValue('email2') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                            <?php echo $account->getError(Constants::$passwordCharacters); ?>
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" placeholder="Your password" required>
                        </p>

                        <p>
                            <label for="password2">Confirm password</label>
                            <input id="password2" name="password2" type="password" placeholder="Your password" required>
                        </p>

                        <button type="submit" name="registerButton" class="custom-btn btn">SIGN UP</button>

                        <div class="hasAccountText">
                            <span id="hideRegister">Already have an account? <b>LogIn here.</b></span>
                        </div>

                    </form>


                </div>
                <div class="loginTextContainer">
                    <div id="loginText">
                        <h1>May the music be with you</h1>
                        <h2>Listen to loads of songs for free</h2>
                        <ul>
                            <li>Discover songs you'll fall in love with</li>
                            <li>Create your own playlists</li>
                            <li>Follow your favourite artists</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
