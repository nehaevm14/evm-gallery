<?php

    require 'shopify.php';
    include "dbcon.php";
    /* Define your APP`s key and secret*/
  define('SHOPIFY_API_KEY','b4e1fa4bf25f6bfb071bfe11a1ce136c');
    define('SHOPIFY_SECRET','bf722894926470d79509147b9a767737');
    /* Define requested scope (access rights) - checkout https://docs.shopify.com/api/authentication/oauth#scopes   */


    define('SHOPIFY_SCOPE','read_products,write_products,read_script_tags,write_script_tags,write_themes,read_content, write_content');

    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        session_unset();
        $create_date=date('Y-m-d');
        // Now, request the token and store it in your session.
        $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
        if ($_SESSION['token'] != '')
        $_SESSION['shop'] = $_GET['shop'];
        $shop_name = $_SESSION['shop'];
        $shop_token = $_SESSION['token'];
        $id=$shop_token;
        if(isset($shop_name))
        {    
        $select_shop_record=mysql_query("SELECT * FROM  `app_data_tbl` WHERE  `shop_address` =  '$shop_name'");
        $shop_record=mysql_fetch_array($select_shop_record);
        $shop_address=$shop_record['shop_address'];
        if($shop_address == $shop_name)
        {
            echo "Application Installed. Redirecting...";
            ?>
             <a href="https://<?php echo $shop_name;?>/admin/apps/">Click here</a>;
             <?php // echo "<script>parent.location.href='https://$shop_name/admin/apps/13727db2c8d98f9a00c192e7f91f4b40'</script>"; ?>
        <?php
        }
        else
        {
        $insert_store_info=mysql_query("INSERT INTO `app_data_tbl` (`shop_id`, `shop_token`, `shop_address`,  `create_date`) VALUES (NULL, '$shop_token', '$shop_name', '$create_date')");
        if($insert_store_info== 0)
        {
            echo "Installation Failed....!!!";
        }
        else
        {?>
            <style>.middle{text-align: center;text-transform: capitalize; font-size: 13px;}i{color: green;}</style>
        <div class="middle"></div>
<?php
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
// ===================Get Theme Details ================================================================================
$sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
           $themes = $sc->call('GET', '/admin/themes.json', array('published_status'=>'published'));
		   		    $shop_details = $sc->call('GET', '/admin/shop.json');
			 $shop_email= $shop_details[email];
			$shop_owner= $shop_details[shop_owner];

 foreach ($themes as $themedetails) {
  if($themedetails['role']=="main")
{
$themeid=$themedetails['id']; 
}
}

    // ===================add new snippet ================================================================================
$ch = curl_init("https://$shop_name/admin/themes/$themeid/assets.json");
    $cssurl = "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/evm-gallery-snippet.php";
	$fetch_css = @file_get_contents( $cssurl );
    $postpage = array( 'asset'=> array(
                                'key'=> 'snippets/evm-gallery.liquid',
                                'value'=> $fetch_css
                          ));
     $resp_assets_arr = $sc->call('PUT', "/admin/themes/$themeid/assets.json", $postpage);
	 $fetch_css = @file_get_contents( $cssurl );
     $page = str_replace('\\/', '/', json_encode($resp_assets_arr));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $page); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    
    
?>
    <div style="display:none"><?php $chargeout = curl_exec($ch);?></div>
        <?php

$ch = curl_init("https://$shop_name/admin/pages.json");
    $cssurl = "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/evm-gallery-snippet.php";
	$fetch_css = @file_get_contents( $cssurl );
    $postpage = array( 'page'=> array(
                                'title'=> 'Video Gallery',
                                'body_html'=> $fetch_css
                            ));
    $page = str_replace('\\/', '/', json_encode($postpage));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $page); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
   <div style="display:none"><?php $output = curl_exec($ch); ?></div>
<?php
// =========add script tag======================================================================================

    $ch = curl_init("https://$shop_name/admin/script_tags.json");
    $callback = 'https://www.apps.expertvillagemedia.com/shopify/evm-gallery/test_script_tag.php?shop='.$shop_name;
    $postdata = array( 'script_tag'=> array(
                                'event'=> 'onload',
                                'src'=> $callback 
                            ));
    $script_tag = str_replace('\\/', '/', json_encode($postdata));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $script_tag); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
    <div style="display:none"><?php $result = curl_exec($ch); ?></div>
    <?php



// ============================== add uninstall webhook ============================================================
 
    $ch = curl_init("https://$shop_name/admin/webhooks.json");
    $callback = 'https://www.apps.expertvillagemedia.com/shopify/evm-gallery/webhook.php?shop='.$shop_name; 

    $postwebhook = array("webhook" => array( "topic"=>"app/uninstalled",
                        "address"=> $callback,
                        "format"=> "json"));
     
    $webhook = str_replace('\\/', '/', json_encode($postwebhook));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $webhook); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
    <div style="display:none"><?php $out = curl_exec($ch); ?></div>
    <?php

// ============================== add Recurring charge api ============================================================
/*$received = $sc->call('GET', '/admin/recurring_application_charges.json', array('published_status'=>'published'));
        $charge_id = $received[0]['id'];
        $value = $received['0']['status'];
        $confirmation_url = $received[0]['confirmation_url'];
        $billing_on = $received[0]['billing_on'];
        $created_at = $received[0]['created_at'];
        $updated_at = $received[0]['updated_at'];
        $activated_on = $received[0]['activated_on'];
        $trial_ends_on = $received[0]['trial_ends_on'];
    $ch = curl_init("https://$shop_name/admin/recurring_application_charges.json");
    $callback = 'http://expertvillagemedia.com/evmtestimonial/charge_application_rec.php?shop='.$shop_name; 

    $postapplicationcharge = array("recurring_application_charge" => 
                                    array("name" => "Basic Plan",
                                        "price" => 0.99,
                                        "return_url" => $callback,
                                        "trial_days" => 7,
                                        "test" => false
                                    ));

    $applicationcharge = str_replace('\\/', '/', json_encode($postapplicationcharge));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicationcharge); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));*/
    ?>
    <div style="display:none"><?php $chargeout = curl_exec($ch);?></div>
 <?php  
    
echo "<script>parent.location.href='https://$shop_name/admin/apps/evm-video-gallery'</script>";


        try
        {
            // Get all products
        $received = $sc->call('GET', '/admin/recurring_application_charges.json', array('published_status'=>'published'));
        $charge_id = $received[0]['id'];
        $value = $received['0']['status'];
        $confirmation_url = $received[0]['confirmation_url'];
        if($value=='accepted')
        {
        $update= mysql_query("UPDATE  `app_data_tbl` SET  `charge_status` = 'accepted',  `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
echo "<script>parent.location.href='https://$shop_name/admin/apps/d3ebed10307853d5ce99c1c46b57806a'</script>";
        }
        elseif($value=='pending')
        {
        $update= mysql_query("UPDATE  `app_data_tbl` SET `charge_status` = 'pending',  `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");

        }
        else
            {
           $update= mysql_query("UPDATE  `app_data_tbl` SET  `charge_status` = 'pending', `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
           echo "<script>parent.location.href='$confirmation_url'</script>";
            }

        $_SESSION['confirmation_url']= $confirmation_url;

// ==========================================================================================================

            try
            { 
                // API call limit helpers
                // echo $sc->callsMade(); // 2
                // echo $sc->callsLeft(); // 498
                // echo $sc->callLimit(); // 500

            }
            catch (ShopifyApiException $e)
            {
                // If you're here, either HTTP status code was >= 400 or response contained the key 'errors'
                echo '<pre>';
                print_r( $e->getMessage() );
                echo '</pre>';
            }

        }
        catch (ShopifyApiException $e)
        {
            /* 
             $e->getMethod() -> http method (GET, POST, PUT, DELETE)
             $e->getPath() -> path of failing request
             $e->getResponseHeaders() -> actually response headers from failing request
             $e->getResponse() -> curl response object
             $e->getParams() -> optional data that may have been passed that caused the failure

            */
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        catch (ShopifyCurlException $e)
        {
            // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        // header("Location: index.php");
        exit; 


// =====================================================================================
    ?>
    
    <?php

    }
    }
    }

        $sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);
        try
        {
            // Get all products
            $products = $sc->call('GET', '/admin/products.json', array('published_status'=>'published'));
            
            echo '<pre>';
            // print_r( $products );
            echo '</pre>';
            try
            { 
                // API call limit helpers
                echo $sc->callsMade(); // 2
                echo $sc->callsLeft(); // 498
                echo $sc->callLimit(); // 500

            }
            catch (ShopifyApiException $e)
            {
                // If you're here, either HTTP status code was >= 400 or response contained the key 'errors'
                echo '<pre>';
                print_r( $e->getMessage() );
                echo '</pre>';
            }

        }
        catch (ShopifyApiException $e)
        {
            /* 
             $e->getMethod() -> http method (GET, POST, PUT, DELETE)
             $e->getPath() -> path of failing request
             $e->getResponseHeaders() -> actually response headers from failing request
             $e->getResponse() -> curl response object
             $e->getParams() -> optional data that may have been passed that caused the failure

            */
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        catch (ShopifyCurlException $e)
        {
            // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        // header("Location: index.php");
        exit;       
        
    
    }
    else{

    // if they posted the form with the shop name
       // if they posted the form with the shop name
    if(isset($_GET['shop'])) {

    $hmac=$_GET['hmac'];
    $timestamp=$_GET['timestamp'];

        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = $_GET['shop'];
      $select_shop_record=mysql_query("SELECT * FROM  `app_data_tbl` WHERE  `shop_address` =  '$shop'");
        $shop_record=mysql_fetch_array($select_shop_record);
        $shop_address=$shop_record['shop_address'];
        if($shop_address == $shop)
        {
   
   include "api_call.php";
       
        }
     else
    {
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

        // get the URL to the current page
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
        }


        // redirect to authorize url
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
        exit;
        }
    }
    // first time to the page, show the form below
?>

    <?php 
    }
     ?>
	 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-29426573-8', 'auto');
  ga('send', 'pageview');

</script>

<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
  <script type="text/javascript">
ShopifyApp.ready(function(){
    ShopifyApp.init({
      apiKey: 'b4e1fa4bf25f6bfb071bfe11a1ce136c',
      shopOrigin: '<?php echo $shop_name;?>'
    });
	 });
  </script>	
		
		<script type="text/javascript">
  ShopifyApp.ready(function(){
    ShopifyApp.Bar.loadingOn();
	ShopifyApp.Bar.loadingOff();
  });
</script>
