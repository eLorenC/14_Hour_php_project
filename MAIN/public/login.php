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
        body {
            display: none;
        }

        .sign {
            height: 450px;
            padding-top: 80px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="section">
        <h1 class="regular">Login</h1>
        <h1 class="admin">Admin <span class="black-text">Login</span></h1>
        <div class="row">
            <div class="col s6">
                <div class="regular card-panel sign">
                    <div class="row">
                        <form class="col s12" action="signin.php" method="post">
                            <div class="row">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input name="UserName" id="UserName" type="text" class="validate" required>
                                        <label for="UserName">Username</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input name="Password" id="Password" type="password" class="validate" required>
                                        <label for="Password">Password</label>
                                    </div>
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
                </div>
            </div>
            <div class="col s6">
                <div class="admin sign card-panel cyan lighten-5">
                    <form class="col s6" action="signin_admin.php" method="post">
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="UserName" id="UserName" type="text" class="validate" required>
                                    <label for="UserName">Username</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="Password" id="Password" type="password" class="validate" required>
                                    <label for="Password">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <button class="btn red waves-effect waves-light" type="submit" name="action" id="admin-submit">Admin Sign-in
                                    <i class="material-icons right">power_settings_new</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="divider" style="margin-bottom: 100px;"></div>
    <div class="fixed-action-btn horizontal" style="bottom: 20%; right: 24px;">
        <a id="admin_show" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">update</i></a>
        <ul><li class="grey-text lighten-2">Click To<br>Access Admin Portal</li></ul>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
<script>
    $(window).load(function () {
        $('body').hide();
        $('body').delay(500).fadeIn(1200);
    });

    (function ($) {
        $('.admin').hide();

        $('.regular').show();


        $('a#admin_show').on('click', function (e) {
            e.preventDefault();

            $('.regular').hide();
            $('.admin').delay(1000).fadeIn(2000);

        })
    }(jQuery));
</script>
<!--<script src="../js/bootstrap.min.js"></script>-->
</body>
</html>