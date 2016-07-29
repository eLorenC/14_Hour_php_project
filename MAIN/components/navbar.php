<nav>
    <div class="nav-wrapper teal lighten-2">
        <a href="index.php" style="margin-left: 10px;" class="brand-logo">Pointless Shopping Inc.</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <?php if(isset($_SESSION['ADMIN_USER'])) { ?>
                <li><a href="manage.php" class="red-text">Manage</a></li>
            <?php } ?>
            <li><a href="products.php">Products</a></li>
            <?php
                $pCount = 0;
                if (isset($_SESSION['CART']) && count($_SESSION['CART'])>0) {
                    foreach($_SESSION['CART'] as $product) {
                        $pCount += $product['Quantity'];
                    }
                }
                ?>
            <li><a href="cart.php">Cart<span id="product_count" class="badge"><?php echo $pCount; ?></span></a></li>
            <?php if(isset($auth) && $auth->check()) { ?>
                <li><a href="signout.php">Logout</a></li>
                <a href="account.php"><i class="material-icons">account_box</i></a>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
