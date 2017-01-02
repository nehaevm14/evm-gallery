<?php
    // echo $_SERVER['REQUEST_URI'];
    require 'shopify.php';
    
    define('SHOPIFY_API_KEY','d3ebed10307853d5ce99c1c46b57806a');
    define('SHOPIFY_SECRET','36540a6d41e646bf3c72715bc62e9899');

    include "dbcon.php";

    $query_params['shop'] = $_GET['shop'];
    $query_params['timestamp'] = @$_GET['timestamp'];
    $query_params['signature'] = @$_GET['signature'];
    $query_params['hmac'] = @$_GET['hmac'];

    $select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
    $shop_details=mysql_fetch_array($select_store_data);

    $shop_name=$shop_details['shop_address'];
    $shop_token=$shop_details['shop_token'];
    
    /* Define requested scope (access rights) - checkout https://docs.shopify.com/api/authentication/oauth#scopes   */
    define('SHOPIFY_SCOPE','read_products,write_products, write_themes '); //eg: define('SHOPIFY_SCOPE','read_orders,write_orders');


    // $ch = curl_init("https://$shop_name/admin/script_tags.json");
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    // $result = curl_exec($ch);
    // echo '<pre>';
    // print_r( json_decode( $result , true )  );
    // echo '</pre>';
    // exit;

    $ch = curl_init("https://$shop_name/admin/script_tags.json");
    $callback = 'https://www.expertvillagemedia.com/instagramfeed/test_script_tag.php?shop='.$query_params['shop'];
    $postdata = array( 'new_script_tag'=> array(
                                'event'=> 'onload',
                                'src'=> $callback 
                            ));
    $new_script_tag = str_replace('\\/', '/', json_encode($postdata));
    echo '<pre>';
    print_r( $new_script_tag );
    echo '</pre>';
       
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $new_script_tag); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
echo "<br>";
echo "<hr>";

$result = curl_exec($ch);

?>