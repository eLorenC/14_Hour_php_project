<!--
        Manage
-->
<?php
    require_once('../app/core/init.php');
    if (!isset($_SESSION['ADMIN_USER'])) {
        header('Location: index.php');
    }

    $db->prep("SELECT * FROM `products`");
    $db->runQuery();
    $product_list = $db->getAll();

    $total = 0;
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
        td {
            overflow: hidden;
            height: 50px;
        }

        tr {
            height: 50px;
        }

        #manage-products {
            font-size: .8em;
        }

        /*div.card.product {*/
            /*height: 432px;*/
        /*}*/
    </style>
</head>
<body>
<?php include_once('../components/navbar.php'); ?>

<div class="container">
    <div class="row">
        <div class="section">
            <div class="col s12">
                <h1 class="heading">
                    Edit Products
                </h1>
                <div class="divider"></div>
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
                <div class="card-panel">
                    <table class="bordered highlight table-responsive">
                        <thead>
                        <tr>
                            <th>*</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Inventory</th>
                            <th>Image Path</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="manage-products">
                        <?php
                            $count = 1;
                            foreach ($product_list AS $product) {
                                $total += ($product['Price'] * $product['Inventory']);
                                ?>
                                <tr class="product" data-id="<?php echo $product['ProductID']; ?>">
                                    <td class="select">
                                        <input type="checkbox" id="select<?php echo $count; ?>" class="filled-in"
                                               title="Select Product">
                                        <label for="select<?php echo $count; ?>"></label>
                                    </td>
                                    <td class="ID"
                                        data-id="<?php echo $product['ProductID']; ?>"><?php echo $product['ProductID']; ?></td>
                                    <td class="Name"
                                        data-id="<?php echo $product['Name']; ?>"><?php echo substr($product['Name'],0,20); ?></td>
                                    <td class="Description"><?php echo substr($product['Description'], 0, 30); ?></td>
                                    <td class="Price"
                                        data-id="<?php echo $product['Price']; ?>"><?php echo $product['Price']; ?></td>
                                    <td class="Inventory" data-id="<?php echo $product['Inventory']; ?>">
                                        <span class="Inventory"><?php echo $product['Inventory']; ?></span>
                                        <input style="width: 30px;" title="!" class="InventoryEdit"
                                               value="<?php echo $product['Inventory']; ?>"
                                               data-inventory="<?php echo $product['Inventory']; ?>"
                                               data-id="<?php echo $product['ProductID']; ?>">
                                    </td>
                                    <td class="ImagePath"><?php echo substr($product['ImagePath'], 0, 20); ?></td>
                                    <td class="Actions">
                                        <button class="delete-product btn red waves-effect waves-light" type="button"
                                                name="action">
                                            <i class="material-icons">delete_forever</i>
                                        </button>
                                    </td>
                                </tr>
                                <?php $count++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row"><br><br><br><br></div>
            <div class="section">

                <br><br><br><br><br>
                <div class="divider"></div>
                <br><br>
                <?php foreach ($product_list AS $product) { ?>
                    <div data-id="<?php echo $product['Name'] ?>" class="col s12 m6 l3">
                        <div class="card product">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator" src="<?php echo $product['ImagePath']; ?>">
                            </div>
                            <div class="card-content">
                                <span
                                    class="card-title activator grey-text text-darken-4"><?php echo substr($product['Name'],0,20); ?>
                                    <i class="material-icons right">more_vert</i></span>
                                <p>
                                    <?php echo $product['Price']; ?>
                                </p>
                                <p>
                                    <a class="Add-to-cart" href="#" data-id="<?php echo $product['ProductID']; ?>">Add
                                        To Cart</a>
                                    <span class="not-in-cart red-text">In Cart</span>
                                </p>
                            </div>
                            <div class="card-reveal">
                                <span class="card-title grey-text text-darken-4"><?php echo $product['Name']; ?><i
                                        class="material-icons right">close</i></span>
                                <p><?php echo $product['Description']; ?></p>
                                <p><span class="red-text">stock: </span><?php echo $product['Inventory']; ?></p>
                                <p>
                                    <a class="Add-to-cart" data-id="<?php echo $product['ProductID']; ?>">Add To
                                        Cart</a>
                                    <span class="not-in-cart red-text">In Cart</span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<!--
        ADD PRODUCT

-->
        <div class="row">
            <form class="col s12" id="add-product" action="global_update_inventory.php" enctype="multipart/form-data" method="post">
                <div class="divider" style="margin-top: 40px; margin-bottom: 40px;"></div>
                <div class="card-panel">
                    <h2 class="header">Add New Product</h2>
                    <div class="row">
                        <div class="input-field col s6">
                            <input name="Name" id="Name" type="text" class="validate">
                            <label for="Name">Product Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="Description" id="Description" type="text" class="validate">
                            <label for="Description">Product Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="Inventory" id="Inventory" type="text" class="validate">
                            <label for="Inventory">Inventory (Stock)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="Price" id="Price" type="text" class="validate">
                            <label for="Price">Price</label>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="header">
                            Product Image
                        </h4>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="ImagePath" id="ImagePath">
                                </div>
                                <div class="file-path-wrapper">
                                    <input title="Image Path Wrapper" class="file-path validate" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a type="submit" id="addNewProduct" class="btn-floating btn-large waves-effect waves-light red" style="position: relative; right: -80%; margin-bottom: 25px;"><i class="material-icons">add</i></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.2.min.js"
        integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>

<?php if ($auth->check()) { ?>
    <script>
        $(document).ready(function () {
            $('.parallax').parallax();


            $('input.InventoryEdit').hide();

            $('button.delete-product').on('click', function (e) {
                var tr_parent = $(this).closest('tr.product').data('id');

                var xhr = $.ajax({
                    type: "POST",
                    url: "update_inventory.php",
                    data: {ProductID: tr_parent, Inventory: 0},
                    dataType: "json"
                });

                $.when(xhr).done(function (data) {
                    window.location.reload();
                });
            });
        });

        $('td.Inventory').on('dblclick', function (e) {
            var self = $(this);
            self.children('span').hide();
            self.children('input.InventoryEdit').show();

            var initialVal = self.children('input.InventoryEdit').data('inventory');
            var ProductID = self.children('input.InventoryEdit').data('id');

            $(this).children('input.InventoryEdit').on('blur', function (e) {
                e.preventDefault();
                var afterBlur = self.children('input.InventoryEdit').val();

                if (afterBlur != initialVal) {
                    var xhr = $.ajax({
                        type: "POST",
                        url: "update_inventory.php",
                        data: {ProductID: ProductID, Inventory: afterBlur},
                        dataType: "json"
                    });
                }

                $.when(xhr).done(function (data) {
                    self.children('input.InventoryEdit').data('inventory', afterBlur);
                    self.children('input.InventoryEdit').hide();
                    self.children('span').val(afterBlur);
                    self.children('span').text(afterBlur);
                    self.children('span').show();
                });

                console.log(afterBlur);
            });

        });

        $('#addNewProduct').on('click', function(e) {
            e.preventDefault();
//            var file_data = $('#upload').prop('files')[0];

//            var form_data = new FormData($('form#add-product')[0]);
            var form_data = new FormData($('#add-product')[0]);

            var xhr = $.ajax({
                    type: "POST",
                    url: $('form#add-product').attr('action'),
                    dataType: 'json',
                    data: form_data,
                    contentType: false,
                    processData:false
            });

            $.when(xhr).done(function (data) {
                console.log(data.resp)
            });
        });


        $(window).load(function () {
            $('body').hide();
            $('body').delay(500).fadeIn(1200);
        });
    </script>
<?php } ?>
<!--<script src="../js/bootstrap.min.js"></script>-->
</body>
</html>