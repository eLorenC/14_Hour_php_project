<!--
        Index Page
-->
<?php
    require_once('../app/core/init.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

    <title>Pointless Shopping</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
    <link rel="stylesheet" href="../css/cdstyles.css">
<!--    <link rel="stylesheet" href="../css/bootstrap.min.css"/>-->
<!--    <link rel="stylesheet" href="../css/bootstrap-theme.min.css"/>-->
    <style>

    </style>
</head>
<body>
<?php include_once('../components/navbar.php'); ?>

<?php if ($auth->check()) { ?>
    <div class="parallax-container">
        <!--        IMAGE CREDIT: http://cdn.pcwallart.com/images/whiskey-glass-wallpaper-2.jpg        -->
        <div class="parallax"><img src="http://cdn.pcwallart.com/images/whiskey-glass-wallpaper-2.jpg"></div>
    </div>
    <div class="section white">
        <div class="row container">
            <?php if(isset($_SESSION['ADMIN_USER'])) { ?>
        <h2 class="header">Welcome Back, <span class="red-text">ADMIN</span> </h2>
        <p class="grey-text text-darken-3 lighten-3">You've been working hard, take a load off.</p>
        </div>
        <div class="row container">
            <a class="btn-large waves-effect red waves-light highlight" type="button" name="action" href="manage.php">Manage
                <i class="material-icons right">power_settings_new</i>
            </a>
        </div>
            <?php } else { ?>
            <h2 class="header">Welcome Back, <?php echo $_SESSION['Shopper']['FName']; ?></h2>
            <p class="grey-text text-darken-3 lighten-3">Shop the best selection of whiskeys in the world...maybe.</p>
        </div>
        <div class="row container">
            <a class="btn-large waves-effect waves-light" type="button" name="action" href="products.php">Shop Now
                <!--                    <i class="material-icons">shopping_cart</i>-->
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="parallax-container">
        <!--        IMAGE CREDIT: http://blog.sauceyapp.com/wp-content/uploads/2015/06/Health-Benefits-of-Whiskey_Saucey_41.jpg        -->
        <div class="parallax"><img src="http://blog.sauceyapp.com/wp-content/uploads/2015/06/Health-Benefits-of-Whiskey_Saucey_41.jpg"></div>
    </div>
<?php } else { ?>
<div class="container">
    <div class="section">
        <h1>Create An Account</h1>
        <div class="row">
            <form class="col s12" action="signup.php" method="post">
                <div class="row">
                    <div class="input-field col s6">
                        <input name="FName" id="FName" type="text" class="validate" required>
                        <label for="FName">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="LName" id="LName" type="text" class="validate" required>
                        <label for="LName">Last Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="UserName" id="UserName" type="text" class="validate" required>
                        <label for="UserName">UserName</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="Password" id="Password" type="password" class="validate" pattern="^[A-Za-z0-9]{9,30}" required>
                        <label for="Password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="EMail" id="EMail" type="email" class="validate" required>
                        <label for="EMail">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="btn waves-effect waves-light" type="submit" name="action" id="signup-submit">Submit
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <div class="divider"></div>
</div>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

<?php if($auth->check()) { ?>
<script>
    $(document).ready(function(){
        $('.parallax').parallax();
    });
    $(window).load(function () {
        $('body').hide();
        $('body').delay(500).fadeIn(1200);
    })
</script>
<?php } ?>
<!--<script src="../js/bootstrap.min.js"></script>-->
</body>
</html>