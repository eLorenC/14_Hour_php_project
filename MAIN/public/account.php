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
    <link rel="stylesheet" href="/css/cdstyles.css">
    <!--    <link rel="stylesheet" href="../css/bootstrap.min.css"/>-->
    <!--    <link rel="stylesheet" href="../css/bootstrap-theme.min.css"/>-->
    <style>
        body {
            display: none;
        }
    </style>
</head>
<body>
<?php include_once('../components/navbar.php'); ?>

<?php if ($auth->check()) { ?>

<div class="container">
    <div class="section">
        <h1 class="header">Account Details</h1>
        <div class="row">
            <form class="col s12" action="account_update.php" method="post">
                <div class="divider" style="margin-top: 40px; margin-bottom: 40px;"></div>
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s6">
                            <input name="FName" id="FName" type="text" class="validate"
                                   value="<?php echo $auth->getUserInfo('FName'); ?>">
                            <label for="FName">First Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="LName" id="LName" type="text" class="validate"
                                   value="<?php echo $auth->getUserInfo('LName'); ?>">
                            <label for="LName">Last Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="UserName" id="UserName" type="text" class="validate"
                                   value="<?php echo $auth->getUserInfo('UserName'); ?>">
                            <label for="UserName">UserName</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="button" name="action" id="NameEdit">Change Name Info
                        <i class="material-icons right">mail</i>
                    </button>
                    <div class="divider" style="margin-top: 40px; margin-bottom: 40px;"></div>
                    <div class="row">
                        <div class="section">
                            <div id="PasswordContainer">
                                <div class="input-field col s12">
                                    <input name="PasswordOld" id="PasswordOld" type="password" class="validate">
                                    <label for="PasswordOld">Old Password</label>
                                </div>
                                <div class="input-field col s12">
                                    <input name="PasswordNew" id="PasswordNew" type="password" class="validate"
                                           pattern="^[A-Za-z0-9]{9,30}" required>
                                    <label for="PasswordNew">New Password</label>
                                </div>
                            </div>
                            <button type="button" class="btn waves-effect waves-light" id="PasswordEdit">Change Password
                                <i class="material-icons right">lock_outline</i>
                            </button>
                        </div>
                    </div>
                    <div class="divider" style="margin-top: 40px; margin-bottom: 40px;"></div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="EMail" id="EMail" type="email" class="validate"
                                   value="<?php echo $auth->getUserInfo('EMail'); ?>" required>
                            <label for="EMail">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light" type="button" name="action" id="changeEmail">Change
                                Email
                                <i class="material-icons right">mail</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="divider" style="margin-top: 60px; margin-bottom: 60px;"></div>
                <div class="section">
                    <div class="row">


<!--           BILLING SECTION             -->
                        <div class="col s12 l6">
                            <div class="card-panel" style="min-height: 570px;">
                                <h1 class="header" style="margin-bottom: 80px;">Billing</h1>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input name="Credit" id="Credit" type="password" class="validate"
                                               pattern="[0-9]{12,16}">
                                        <label for="Credit">Credit Card No.</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input name="CreditExpMonth" id="CreditExpMonth" type="text" class="validate"
                                               pattern="[0-9]{2}">
                                        <label for="CreditExpMonth">Expiration Month</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input name="CreditExpYear" id="CreditExpYear" type="text" class="validate"
                                               pattern="[0-9]{2}">
                                        <label for="CreditExpYear">Expiration Year</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input name="CreditSec" id="CreditSec" type="text" class="validate"
                                               pattern="[0-9]{3}">
                                        <label for="CreditSec">Security Code</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 l6">
                                        <button class="btn waves-effect waves-light" type="button" name="action"
                                                id="updateBilling">
                                            Update Billing
                                            <i class="material-icons right">credit_card</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col s12 l6">
                            <div class="card-panel" style="min-height: 570px;">
                                <h1 class="header" style="margin-bottom: 80px;">Shipping</h1>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input name="Address" id="Address" type="text" class="validate"
                                               pattern="[0-9]{4,7}" value="<?php echo $auth->getUserInfo('Address'); ?>">
                                        <label for="Address">Address</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input name="Street" id="Street" type="text" class="validate"
                                               pattern="[A-Za-z0-9]{4,75}" value="<?php echo $auth->getUserInfo('Street'); ?>">
                                        <label for="Street">Street</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s4">
                                        <input name="City" id="City" type="text" class="validate"
                                               pattern="[A-Za-z0-9]{4,75}" value="<?php echo $auth->getUserInfo('City'); ?>">
                                        <label for="City">City</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input name="State" id="State" type="text" class="validate"
                                               pattern="[A-Za-z0-9]{4,75}" value="<?php echo $auth->getUserInfo('State'); ?>">
                                        <label for="State">State</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input name="Zip" id="Zip" type="text" class="validate" pattern="[0-9]{4,9}" value="<?php echo $auth->getUserInfo('Zip'); ?>">
                                        <label for="Zip">Zip</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 l6">
                                        <button class="btn waves-effect waves-light" type="button" name="action"
                                                id="updateShipping">
                                            Update Shipping
                                            <i class="material-icons right">local_shipping</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <div class="divider"></div>
</div>
<div id="modal-notify-acct" class="modal">
    <div class="modal-content">
        <h4>Account Notification</h4>
        <h6>Account Update Successful</h6>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Sweet!</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
<!--<script src="../js/bootstrap.min.js"></script>-->
<script async defer>

    (function ($) {

        $('input#PasswordOld').on('blur', function (e) {

            var oldpass = $(this).val();

            $.ajax({
                type: "POST",
                url: "check_pass.php",
                data: {pass: oldpass},
                dataType: "json"
            }).done(function (data) {

                if (!(oldpass == "" || oldpass == undefined || oldpass == null))
                    if (data.resp === "true") {
                        $('input#PasswordOld').removeClass('invalid');
                        $('input#PasswordOld').addClass('valid');
                    } else {
                        $('input#PasswordOld').removeClass('valid');
                        $('input#PasswordOld').addClass('invalid');
                    }
                else {
                    $('input#PasswordOld').removeClass('valid');
                    $('input#PasswordOld').removeClass('invalid');
                }
            });
        });

        $('body').on('click', '#PasswordEdit', function (e) {

            if ($('input#PasswordOld').hasClass('valid') && $('input#PasswordNew').hasClass('valid')) {
                var newpass = $('input#PasswordNew').val();

                $.ajax({
                    type: "POST",
                    url: "change_pass.php",
                    data: {pass: newpass},
                    dataType: "json"
                }).done(function (data) {
                    if (data.resp === "true") {
                        $('.modal-content h6').text("Password Updated!");
                        $('#modal-notify-acct').openModal().delay(3000).closeModal();
                    }
                    else {
                        $('.modal-content h6').text("Something Went Wrong, Please Try Again");
                        $('#modal-notify-acct').openModal().delay(3000).closeModal();
                    }

                });
            }
        }).on('click', '#changeEmail', function (e) {
            var email = $('#EMail').val();

            $.ajax({
                type: "POST",
                url: "change_email.php",
                data: {email: email},
                dataType: "json"
            }).done(function (data) {
                if (data.resp === "true") {
                    $('.modal-content h6').text("Email Updated!");
                    $('#modal-notify-acct').openModal();
                    $('#EMail').val(data.uemail);
                }
                else {
                    $('.modal-content h6').text("Something Went Wrong, Please Try Again");
                    $('#modal-notify-acct').openModal();
                }

            });
        }).on('click', '#NameEdit', function (e) {
            var fn = $('#FName').val(),
                ln = $('#LName').val(),
                un = $('#UserName').val();
            console.log(fn);

            $.ajax({
                type: "POST",
                url: "change_name.php",
                data: {fname: fn, lname: ln, uname: un},
                dataType: "json"
            }).done(function (data) {
                if (data.resp === "true") {
                    $('.modal-content h6').text("Naming Info Updated!");
                    $('#modal-notify-acct').openModal();
                }
                else {
                    $('.modal-content h6').text("Something Went Wrong, Please Try Again");
                    $('#modal-notify-acct').openModal();
                }

            });


        }).on('click','#updateBilling', function(e) {
            var ccn = $('#Credit').val(),
                cce = $('#CreditExpMonth').val() + $('#CreditExpYear').val(),
                ccs = $('#CreditSec').val();

            $.ajax({
                type: "POST",
                url: "change_billing.php",
                data: {ccn: ccn, cce: cce, ccs: ccs},
                dataType: "json"
            }).done(function (data) {
                if (data.resp === "true") {
                    $('.modal-content h6').text("Billing Info Updated!");
                    $('#modal-notify-acct').openModal();
                }
                else {
                    $('.modal-content h6').text("Something Went Wrong, Please Try Again");
                    $('#modal-notify-acct').openModal();
                }
            });


        }).on('click', '#updateShipping', function(e) {
            var ad = $('#Address').val(),
                str = $('#Street').val(),
                ci = $('#City').val(),
                st = $('#State').val(),
                zi = $('#Zip').val();

            $.ajax({
                type: "POST",
                url: "change_shipping.php",
                data: {ad: ad, str: str, ci: ci, st: st, zi: zi},
                dataType: "json"
            }).done(function (data) {
                if (data.resp === "true") {
                    $('.modal-content h6').text("Shipping Info Updated!");
                    $('#modal-notify-acct').openModal();
                }
                else {
                    $('.modal-content h6').text("Something Went Wrong, Please Try Again");
                    $('#modal-notify-acct').openModal();
                }

            });
        });
    }(jQuery));

    $(window).load(function () {
        $('body').delay(500).fadeIn(1200);
    });
    $(window).on('beforeunload', function (e) {
        $('body').fadeOut(1000);
    });
</script>
</body>
</html>