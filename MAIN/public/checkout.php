<!--
        Checkout Page
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
    <!--    <link rel="stylesheet" href="../css/bootstrap.min.css"/>-->
    <!--    <link rel="stylesheet" href="../css/bootstrap-theme.min.css"/>-->
    <style>
        body {
            display: none;
        }
    </style>
</head>
<body>
<?php include_once(COMP . 'navbar.php'); ?>
<div class="container">
    <div class="row">
        <div class="section">
            <div class="card-panel">
                <div class="row">
                    Grand Total: $
                   <?php
                       echo  number_format((float)$_SESSION['Shopper']['CART_GRAND'], 2, '.', '');
                   ?>
                    <div class="row">
                    <div class="col s12 l6">
                        <div class="card-panel" style="min-height: 570px;">
                            <h1 class="header" style="margin-bottom: 80px;">Billing</h1>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="Credit" id="Credit" type="password" class="validate"
                                           pattern="[0-9]{12,16}" value="<?php echo $auth->getUserInfo('CardNumber'); ?>">
                                    <label for="Credit">Credit Card No.</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input name="CreditExpMonth" id="CreditExpMonth" type="text" class="validate" pattern="[0-9]{2}" value="<?php echo substr($auth->getUserInfo('CardExp'),0,2);?>" >
                                    <label for="CreditExpMonth">Expiration Month</label>
                                </div>
                                <div class="input-field col s6">
                                    <input name="CreditExpYear" id="CreditExpYear" type="text" class="validate"
                                           pattern="[0-9]{2}" value="<?php echo substr($auth->getUserInfo('CardExp'),2); ?>">
                                    <label for="CreditExpYear">Expiration Year</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input name="CreditSec" id="CreditSec" type="text" class="validate"
                                           pattern="[0-9]{3}" value="<?php echo $auth->getUserInfo('CardSec'); ?>">
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
        </div>
    </div>
</div>
</div>
<div class="row">
    <button class="btn waves-effect waves-light" type="button" name="action"
            id="PayNow">
        Pay &amp; Ship!
        <i class="material-icons right">local_shipping</i>
    </button>
</div>
<div id="modal-notify-pay" class="modal">
    <div class="modal-content">
        <h4>Account Notification</h4>
        <h6>Thank you for your order!</h6>
        <?php foreach($_SESSION['CART'] as $product) { ?>
        <p><b>Product: </b> <?php echo $product['Name'] ?>&nbsp;<b>Price: </b><?php echo $product['Price'] ?>&nbsp; <b>Qty: </b><?php echo $product['Quantity'] ?></p>
        <?php }?>
        <p><b>Grand Total:</b> <span class="red-text"> $<?php echo number_format((float)$_SESSION['Shopper']['CART_GRAND'],2,'.',''); ?></span></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Sweet!</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

<!--<script src="../js/bootstrap.min.js"></script>-->
<script>
    $(window).load(function () {
        $('body').hide();
        $('body').delay(500).fadeIn(1200);
    })

    (function ($) {
        $('#PayNow').on('click',function(e) {
            $('#modal-notify-pay').openModal();
            $('.modal-close').on('click', function (e) {
                window.location.href = 'index.php';
            });

            });
    }(jQuery));
</script>
</body>
</html>