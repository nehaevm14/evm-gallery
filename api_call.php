<?php
session_start();
$query_params['shop'] = $_GET['shop'];
 $shop_name=$_SESSION['shopname']; 
include "dbcon.php";
 ?>
<div class="full-width">
<?php
$query_params['shop'] = $_GET['shop'];
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
$shop_details=mysql_fetch_array($select_store_data);
 $shop_name=$shop_details['shop_address'];
$shop_token=$shop_details['shop_token'];
$shop_tbl_id=$shop_details['shop_id'];
 $status=$shop_details['charge_status'];
 $confirmation_url = $shop_details['confirm_url'];
$_SESSION['shopid'] = $shop_token;
 $_SESSION['shopname'] = $shop_address;
?>

<?php
$query = mysql_query("SELECT * FROM `videos` WHERE `shop_address` = '$shop_name' ");
$records = mysql_num_rows($query);
if ($records > 0)
{
include 'viewall.php';
} else {
include 'insertvideo.php';

}





 ?>


</div>









