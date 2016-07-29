<!--
        Products Page
-->

<?php

    require_once('../app/core/init.php');
    $db->prep("SELECT * FROM `products` WHERE `Inventory` <> 0");
    $db->runQuery();
    $product_list = $db->getAll();

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
        .not-in-cart {
            display: none;
        }

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
            <div class="row container">
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="search_bar" type="text" name="search_txt">
                                <label for="search_bar"><i class="material-icons">search</i></label>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php foreach($product_list AS $product) { ?>
        <div data-id="<?php echo $product['Name'] ?>" class="product col s12 m6 l3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="<?php echo $product['ImagePath']; ?>">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4"><?php echo substr($product['Name'],0,20); ?><i class="material-icons right">more_vert</i></span>
                    <p>
                        <?php echo $product['Price']; ?>
                    </p>
                    <p>
                        <a class="Add-to-cart" href="#" data-id="<?php echo $product['ProductID']; ?>">Add To Cart</a>
                        <span class="not-in-cart red-text">In Cart</span>
                    </p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><?php echo $product['Name']; ?><i class="material-icons right">close</i></span>
                    <p><?php echo $product['Description']; ?></p>
                    <p><span class="red-text">stock: </span><?php echo $product['Inventory']; ?></p>
                    <p>
                        <a class="Add-to-cart" data-id="<?php echo $product['ProductID']; ?>">Add To Cart</a>
                        <span class="not-in-cart red-text">In Cart</span>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

<!--<script src="../js/bootstrap.min.js"></script>-->

<script>
    (function ($) {

        $('#search_bar').on('keyup', function() {
            var searchVal = $('#search_bar').val().toLowerCase();

            if(searchVal != "" && searchVal != undefined && searchVal != null)
            {
                $('.product').hide();
                $('.product').each(function (index) {
                    if($(this).data('id').toLowerCase().indexOf(searchVal) != -1) {
                        $(this).show();
                    }
                });
            } else {
                $('.product').show();
            }


        });

        $('body').on('click', 'a.Add-to-cart', function (e) {
            e.preventDefault();
            var targeted = $(this);
            var ProductID = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "add_product.php",
                data: {ProductID: ProductID},
                dataType: "json"
            }).done(function (data) {
                if (data.resp === "true") {
                    //targeted.hide();
                    targeted.siblings('span').removeClass('not-in-cart');
//                    $('.modal-content h6').text("Password Updated!");
//                    $('#modal-notify-acct').openModal().delay(3000).closeModal();
                }
                else {
//                    $('.modal-content h6').text("Something Went Wrong, Please Try Again");
//                    $('#modal-notify-acct').openModal().delay(3000).closeModal();
                }

            });
        })
    }(jQuery));

    $(window).load(function () {
        $('body').hide();
        $('body').delay(500).fadeIn(1200);
    })
</script>


<!--
    IMAGE CREDITS

    JIM BEAM: https://liquor.s3.amazonaws.com/wp-content/uploads/2014/12/Jim-Beam-Orig1.jpg

    JACK DANIELS: http://spiritedgifts.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/j/a/jack-daniels-black-label-old-no.7-gastroflasche-tennessee-whiskey.jpg

    EVAN WILLIAMS: http://www.liquormart.com/media/catalog/product/cache/1/image/650x650/9df78eab33525d08d6e5fb8d27136e95/e/v/evan_williams_black_label_bourbon_whiskey_750.jpg

    MAKERS MARK: http://www.onefortyonebespoke.com/wp-content/uploads/Attachment-1-63.jpeg

    BUSHMILLS: http://mysupermarket.org.ua/fototovarov/compere/4758.jpg

    JAMESON: https://media2.caskers.com/media/catalog/product/cache/1/thumbnail/1000x/9df78eab33525d08d6e5fb8d27136e95/j/a/jameson-st.-patrick_s-day-limited-edition-original-irish-whiskey-1.jpg

-->
</body>
</html>
