<?php
session_start();
$formid = isset($_SESSION['formid']) ? $_SESSION['formid'] : "";
if ($formid != $_POST['formid']) {
	echo "E00001!! SESSION ERROR RETRY AGAINT.";
} else {
	unset($_SESSION['formid']);
	if ($_POST) {
		require 'connect.php';
		$order_fullname = mysql_real_escape_string($_POST['order_fullname']);
		$order_address = mysql_real_escape_string($_POST['order_address']);
		$order_phone = mysql_real_escape_string($_POST['order_phone']);

		$meSql = "INSERT INTO orders (order_date, order_fullname, order_address, order_phone) VALUES (NOW(),'{$order_fullname}','{$order_address}','{$order_phone}') ";
		$meQeury = mysql_query($meSql);
		if ($meQeury) {
			$order_id = mysql_insert_id();
			for ($i = 0; $i < count($_POST['qty']); $i++) {
				$order_detail_quantity = mysql_real_escape_string($_POST['qty'][$i]);
				$order_detail_price = mysql_real_escape_string($_POST['product_price'][$i]);
				$product_id = mysql_real_escape_string($_POST['product_id'][$i]);
				$lineSql = "INSERT INTO order_details (order_detail_quantity, order_detail_price, product_id, order_id) ";
				$lineSql .= "VALUES (";
				$lineSql .= "'{$order_detail_quantity}',";
				$lineSql .= "'{$order_detail_price}',";
				$lineSql .= "'{$product_id}',";
				$lineSql .= "'{$order_id}'";
				$lineSql .= ") ";
				mysql_query($lineSql);
			}
			mysql_close();
			unset($_SESSION['cart']);
			unset($_SESSION['qty']);
			header('location:index.php?a=order');
		}else{
			mysql_close();
			header('location:index.php?a=orderfail');
		}
	}
}
