<?php
session_start();
require 'connect.php';

$action = isset($_GET['a']) ? $_GET['a'] : "";
$itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$_SESSION['formid'] = sha1('itoffside.com' . microtime());
if (isset($_SESSION['qty'])) {
	$meQty = 0;
	foreach ($_SESSION['qty'] as $meItem) {
		$meQty = $meQty + $meItem;
	}
} else {
	$meQty = 0;
}
if (isset($_SESSION['cart']) and $itemCount > 0) {
	$itemIds = "";
	foreach ($_SESSION['cart'] as $itemId) {
		$itemIds = $itemIds . $itemId . ",";
	}
	$inputItems = rtrim($itemIds, ",");
	$meSql = "SELECT * FROM products WHERE id in ({$inputItems})";
	$meQuery = mysql_query($meSql);
	$meCount = mysql_num_rows($meQuery);
} else {
	$meCount = 0;
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
<script type="text/javascript">
	function updateSubmit(){
		if(document.formupdate.order_fullname.value == ""){
			alert('Please enter your name!');
			document.formupdate.order_fullname.focus();
			return false;
		}
			if(document.formupdate.order_address.value == ""){
			alert('Please enter the address!');
			document.formupdate.order_address.focus();
			return false;
		}
			if(document.formupdate.order_phone.value == ""){
			alert('Please enter your phone number!');
			document.formupdate.order_phone.focus();
			return false;
		}
		document.formupdate.submit();
		return false;
	}
</script>
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
			<h3>SHIPPING ADDRESS</h3>
            <!-- Main component for a primary marketing message or call to action -->
            <?php
            if ($action == 'removed')
            {
                echo "<div class=\"alert alert-warning\">ลบสินค้าเรียบร้อยแล้ว</div>";
            }

            if ($meCount == 0)
            {
                echo "<div class=\"alert alert-warning\">ไม่มีสินค้าอยู่ในตะกร้า</div>";
            } else
            {
                ?>
                
                <form action="updateorder.php" method="post" name="formupdate" role="form" id="formupdate" onsubmit="JavaScript:return updateSubmit();">
                	<div class="form-group">
    					<label for="exampleInputEmail1">Name - Surname</label>
    					<input type="text" class="form-control" id="order_fullname" placeholder="ใส่ชื่อนามสกุล" style="width: 300px;" name="order_fullname">
  					</div>
                	<div class="form-group">
    					<label for="exampleInputAddress">Address</label>
    					<textarea class="form-control" rows="3" style="width: 500px;" name="order_address" id="order_address" placeholder="ใส่ที่อยู่"></textarea>
  					</div>
                	<div class="form-group">
    					<label for="exampleInputPhone">Phone Number</label>
    					<input type="text" class="form-control" id="order_phone" placeholder="ใส่เบอร์โทรศัพท์ที่สามารถติดต่อได้" style="width: 300px;" name="order_phone">
  					</div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID PRODUCT</th>
                                <th>NAME PRODUCT</th>
                                <th>DETAILS</th>
                                <th>THE NUMBER OF ITEM</th>
                                <th>PRICE/ITEM</th>
                                <th>TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_price = 0;
                            $num = 0;
                            while ($meResult = mysql_fetch_assoc($meQuery))
                            {
                                $key = array_search($meResult['id'], $_SESSION['cart']);
                                $total_price = $total_price + ($meResult['product_price'] * $_SESSION['qty'][$key]);
                                ?>
                                <tr>
                                    <td><?php echo $meResult['product_code']; ?></td>
                                    <td><?php echo $meResult['product_name']; ?></td>
                                    <td><?php echo $meResult['product_desc']; ?></td>
                                    <td>
                                    	<?php echo $_SESSION['qty'][$key]; ?>
                                    	<input type="hidden" name="qty[]" value="<?php echo $_SESSION['qty'][$key]; ?>" />
                                    	<input type="hidden" name="product_id[]" value="<?php echo $meResult['id']; ?>" />
                                    	<input  type="hidden" name="product_price[]" value="<?php echo $meResult['product_price']; ?>" />
                                    </td>
                                    <td><?php echo number_format($meResult['product_price'], 2); ?></td>
                                    <td><?php echo number_format(($meResult['product_price'] * $_SESSION['qty'][$key]), 2); ?></td>
                                </tr>
                                <?php
								$num++;
								}
                            ?>
                            <tr>
                                <td colspan="8" style="text-align: right;">
                                    <h4>Total  prices:<?php echo number_format($total_price, 2); ?> Bath</h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right;">
                                	<input type="hidden" name="formid" value="<?php echo $_SESSION['formid']; ?>"/>
                                	<a href="cart.php" type="button" class="btn btn-danger btn-lg">Back</a>
                                    <button type="submit" class="btn btn-primary btn-lg">Confirm Order</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php
				}
            ?>

        </div> <!-- /container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="bootstrap/js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
<?php
mysql_close();
