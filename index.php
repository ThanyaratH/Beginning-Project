<?php
session_start();
require 'connect.php';

$meSql = "SELECT * FROM products ";
$meQuery = mysql_query($meSql);

$action = isset($_GET['a']) ? $_GET['a'] : "";
$itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
if(isset($_SESSION['qty'])){
    $meQty = 0;
    foreach($_SESSION['qty'] as $meItem){
        $meQty = $meQty + $meItem;
    }
}else{
    $meQty=0;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BOHO HUAHIN</title>

        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/nava.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div class="container">

            <!-- Static navbar -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">BOHO HUAHIN</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="index.php">SHOP</a></li>
                            <li><a href="cart.php">CART<span class="badge"><?php echo $meQty; ?></span></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </div>

            <!-- Main component for a primary marketing message or call to action -->
            
            <h1 style="font-weight: bold; font-size: 40px;">B O H O   H U A H I N</h1>
            <br>
                <h2 style="font-style: italic; font-size: 30px; margin-top: -25px;">Bohemian style</h2>
                <br>
                <p style="margin-top: -25px;">Fashion circuit like this Starting from a nomadic gypsy tribe
                <br>
                And bohemian dress a man of the middle class Not tied to tradition too
                <br>
                It can be seen that This style of dress often have a lot of time Including
                <br>
                items such as rings, bracelets, earrings, colorful stones, and good luck charm.
                <br></p>
        <?php
        if($action == 'exists'){
            echo "<div class=\"alert alert-warning\">เพิ่มจำนวนสินค้าแล้ว</div>";
        }
        if($action == 'add'){
            echo "<div class=\"alert alert-success\">เพิ่มสินค้าลงในตะกร้าเรียบร้อยแล้ว</div>";
        }
        if($action == 'order'){
        	echo "<div class=\"alert alert-success\">สั่งซื้อสินค้าเรียบร้อยแล้ว</div>";
        }
        if($action == 'orderfail'){
        	echo "<div class=\"alert alert-warning\">สั่งซื้อสินค้าไม่สำเร็จ มีข้อผิดพลาดเกิดขึ้นกรุณาลองใหม่อีกครั้ง</div>";
        }
        ?>
            <table class="table table-striped">
                <thead>
                    <tr class="table table-striped2" style="width: auto; height: 40px; background-color: #00a651; color: #fff;">
                        <th>PRODUCT</th>
                        <th>ID PRODUCT</th>
                        <th>NAME PRODUCT</th>
                        <th>DETAILS</th>
                        <th>PRICE/ITEM</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($meResult = mysql_fetch_assoc($meQuery))
                    {
                        ?>
                        <tr>
                            <td><img src="images/<?php echo $meResult['product_img_name']; ?>" border="0"></td>
                            <td><?php echo $meResult['product_code']; ?></td>
                            <td><?php echo $meResult['product_name']; ?></td>
                            <td><?php echo $meResult['product_desc']; ?></td>
                            <td><?php echo number_format($meResult['product_price'],2); ?></td>
                            <td>
                                <a class="btn btn-primary btn-lg" href="updatecart.php?itemId=<?php echo $meResult['id']; ?>" role="button">
                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                    ADD TO CART</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>


        </div> <!-- /container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="bootstrap/js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
<?php
mysql_close();
