<!--
        Cart Page
-->
<?php

    require_once('../app/core/init.php');
    //var_dump($_SESSION['CART']);
    $total = 0.00;
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
    <!-- Page Content goes here -->
    <div class="col-sm-12">
        <div class="row">
            <div class="section">
                <div class="row">
                    <h1 class="header">Cart</h1>
                </div>
                <div class="row">
                    <div class="section">
                        <div class="card-panel">
                            <table class="responsive-table highlight bordered">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-body">
                                    <?php
                                        $count=1;
                                        if(isset($_SESSION['CART']) && count($_SESSION['CART']) > 0 ) {

                                        foreach($_SESSION['CART'] AS $product) {
                                            $total += ($product['Price'] * $product['Quantity']);
                                            ?>
                                            <tr class="product" data-id="<?php echo $product['ProductID']; ?>">
                                                <td class="select">
                                                    <input type="checkbox" id="select<?php echo $count; ?>" class="filled-in" title="Select Product">
                                                    <label for="select<?php echo $count; ?>"></label>
                                                </td>
                                                <td class="Name" data-id="<?php echo $product['Name']; ?>"><?php echo $product['Name']; ?></td>
                                                <td class="Description"><?php echo substr($product['Description'], 0, 55); ?></td>
                                                <td class="Price" data-id="<?php echo $product['Price']; ?>"><?php echo $product['Price']; ?></td>
                                                <td class="Quantity" data-id="<?php echo $product['Quantity']; ?>">
                                                    <span class="Quantity"><?php echo $product['Quantity']; ?></span>
                                                    <input style="width: 30px;" title="!" class="QuantityEdit" value="<?php echo $product['Quantity']; ?>" data-quantity="<?php echo $product['Quantity']; ?>" data-id="<?php echo $product['ProductID']; ?>">
                                                </td>
                                                <td class="Actions">
                                                    <button class="delete-product btn red waves-effect waves-light" type="button" name="action">
                                                        <i class="material-icons">remove_shopping_cart</i>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php $count++; }

                                        } else { ?>
                                            <tr class="valign-wrapper">
                                                <td colspan="6" class="valign">Your Cart Is Empty</td>
                                            </tr>
                                    <?php }?>
                                </tbody>

                                <?php if (count($_SESSION['CART']) > 0) { ?>
                                <tfoot style="border-top: 2px grey solid">

                                </tfoot>
                                <?php } ?>
                            </table>
                            <div class="row">
                                <div class="row" style="margin-top: 20px; margin-bottom: 20px;"></div>
                                <h6 class="right-align">
                                    Sub Total: $
                                    <?php
                                        $_SESSION['Shopper']['CART_TOTAL'] = $total;
                                        echo  number_format((float)$_SESSION['Shopper']['CART_TOTAL'], 2, '.', '');
                                    ?>
                                </h6>
                            </div>
                            <div class="row">
                                <h6 class="right-align">
                                    Tax: $
                                    <?php
                                        $_SESSION['Shopper']['CART_TAX'] = ($_SESSION['Shopper']['CART_TOTAL'] * 0.10);
                                        echo  number_format((float)$_SESSION['Shopper']['CART_TAX'], 2, '.', '');
                                    ?>
                                </h6>
                            </div>
                            <div class="row">
                                <h6 class="right-align">
                                    Grand Total: $
                                    <?php
                                        $_SESSION['Shopper']['CART_GRAND'] = ($_SESSION['Shopper']['CART_TOTAL'] + $_SESSION['Shopper']['CART_TAX']);
                                        echo  number_format((float)$_SESSION['Shopper']['CART_GRAND'], 2, '.', '');
                                    ?>
                                </h6>
                            </div>
                            <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
                                <a id="update_cart" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">update</i></a>
                                <ul><li class="grey-text lighten-2">Click To<br>Update Shopping Cart</li></ul>
                            </div>
                            <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
                                <a id="checkout" href="checkout.php" class="btn-floating btn-large waves-effect waves-light blue"><i class="material-icons">fast_forward</i></a>
                                <ul><li class="grey-text lighten-2">Click To<br>Check Out</li></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

<!--<script src="../js/bootstrap.min.js"></script>-->

<script>
    (function ($) {
        $('.QuantityEdit').hide();


        $('button.delete-product').on('click', function (e) {
            var tr_parent = $(this).closest('tr.product').data('id');

                var xhr = $.ajax({
                    type: "POST",
                    url: "update_product.php",
                    data: {ProductID: tr_parent, Quantity: 0},
                    dataType: "json"
                });

            $.when(xhr).done(function (data) {
                window.location.reload();
            });
        });

        $('a#update_cart').on('click', function(e) {
            e.preventDefault();
            window.location.reload();
        });

        $('td.Quantity').on('dblclick', function (e) {
            var self = $(this);
            self.children('span').hide();
            self.children('input.QuantityEdit').show();

            var initialVal = self.children('input.QuantityEdit').data('quantity');
            var ProductID = self.children('input.QuantityEdit').data('id');

            $(this).children('input.QuantityEdit').on('blur', function (e) {
                e.preventDefault();
                var afterBlur = self.children('input.QuantityEdit').val();

                if (afterBlur != initialVal) {
                    var xhr = $.ajax({
                        type: "POST",
                        url: "update_product.php",
                        data: {ProductID: ProductID, Quantity: afterBlur},
                        dataType: "json"
                    });
                }

                $.when(xhr).done(function (data) {
                        self.children('input.QuantityEdit').data('quantity', afterBlur);
                        self.children('input.QuantityEdit').hide();
                        self.children('span').val(afterBlur);
                        self.children('span').text(afterBlur);
                        self.children('span').show();
                    });

                console.log(afterBlur);
            })

        })
    }(jQuery));

    $(window).load(function () {
        $('body').hide();
        $('body').delay(500).fadeIn(1200);
    })
</script>
</body>
</html>
