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

<!--<div class="row">-->
<!--    <div class="navbar navbar-fixed-top navbar-inverse">-->
<!--        <div class="container-fluid">-->
<!--            <!-- Brand and toggle get grouped for better mobile display -->
<!--            <div class="navbar-header">-->
<!--                <a class="navbar-brand" href="#">Nonsense Shopping</a>-->
<!--            </div>-->
<!---->
<!--            <!-- Collect the nav links, forms, and other content for toggling -->
<!--            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">-->
<!--                <ul class="nav navbar-nav">-->
<!--                    <li class="active"><a href="#">Home</a></li>-->
<!--                    <li><a href="#">Products</a></li>-->
<!--                    <li><a href="#">Cart</a></li>-->
<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>-->
<!--                        <ul class="dropdown-menu" role="menu">-->
<!--                            <li><a href="#">Home</a></li>-->
<!--                            <li><a href="#">Cart</a><i class="glyphicon glyphicon-cart"></i></li>-->
<!--                            <li><a href="#">Something else here</a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="#">Separated link</a></li>-->
<!--                            <li class="divider"></li>-->
<!--                            <li><a href="#">One more separated link</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </ul>-->
<!---->
<!--                <!--            <form class="navbar-form navbar-left" role="search">-->
<!--                <!--                <div class="form-group">-->
<!--                <!--                    <input type="text" class="form-control" placeholder="Search">-->
<!--                <!--                </div>-->
<!--                <!--                <button type="submit" class="btn btn-default">Submit</button>-->
<!--                <!--            </form>-->
<!---->
<!---->
<!--                <!--     NAV-RIGHT-SIDE - Display either login or user info      -->
<!--                <li class="dropdown navbar-right">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <span class="caret"></span></a>-->
<!--                    <ul class="dropdown-menu login" role="menu">-->
<!---->
<!--                        <li><h2>Login</h2></li>-->
<!--                        <li>-->
<!--                            <form id="login">-->
<!--                                <div class="form-group">-->
<!--                                    <label for="username" class="control-label">Username:</label>-->
<!--                                    <input type="text" name="username" id="username" class="form-control">-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <label for="password" class="control-label">Password</label>-->
<!--                                    <input type="password" name="password" id="password" class="form-control">-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <button type="submit" id="submit" class="login-submit btn btn-success">Login</button>-->
<!--                                    <button type="reset" id="reset" class="login-submit btn btn-danger">Clear</button>-->
<!--                                </div>-->
<!--                            </form>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li class="pull-right"><a href="#">Cart</a><i class="glyphicon glyphicon-cart"></i></li>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->