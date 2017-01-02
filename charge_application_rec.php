<?php
    session_start();
    require 'shopify.php';
  define('SHOPIFY_API_KEY','b4e1fa4bf25f6bfb071bfe11a1ce136c');
    define('SHOPIFY_SECRET','bf722894926470d79509147b9a767737');
    include "dbcon.php";
    
    $chargeId = $_GET['charge_id'];
    if($chargeId == '')
    {
       
    }
    else
    {
    $query_params['shop'] = $_GET['shop'];
    $select_store_data = mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
    $shop_details = mysql_fetch_array($select_store_data);
    $shop_id=$shop_details['shop_id'];
    $shop_name=$shop_details['shop_address'];
    $shop_token=$shop_details['shop_token'];
    $confirmation_url=$shop_details['confirm_url'];
    $sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
    if($shop_details)
    {
        $received = $sc->call('GET', "/admin/recurring_application_charges/{$chargeId}.json");
        $value = $received['status'];
        // Activate the charge
        $charge_stat = $sc->call('GET', "/admin/recurring_application_charges/{$chargeId}.json");
        if ($charge_stat['status'] == "accepted") {
            $billing_on = date("Y-m-d") . "T00:00:00+00:00";
            $create_at = date("Y-m-d\TH:i:s") . "+05:30";
            $updated_at = date("Y-m-d\TH:i:s") . "+05:30";
            $trial_ends_on = date("Y-m-d\TH:i:s", strtotime("+7 days")) . "+05:30";
            $act_recurring_charge_arr = array("recurring_application_charge" =>
                    array("activated_on" => null,
                        "billing_on" => $billing_on,
                        "cancelled_on" => null,
                        "created_at" => $create_at,
                        "id" => $chargeId,
                        "name" => "Basic Plan",
                        "price" => 2.00,
                        "return_url" => "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/index.php",
                        "status" => "accepted",
                        "test" => false,
                        "trial_days" => 7,
                        "trial_ends_on" => $trial_ends_on,
                        "updated_at" => $updated_at
                ));
            try {
                $act_recurring_charge_call = $sc->call('POST', "/admin/recurring_application_charges/{$chargeId}/activate.json", $act_recurring_charge_arr);
                $update= mysql_query("UPDATE  `app_data_tbl` SET `charge_status` =  '$value' WHERE  `shop_id` =  '$shop_id'");
                
         	echo "<script>parent.location.href='https://$shop_name/admin/apps/evm-video-gallery'</script>";
            } catch (Exception $e) {

            }
        } else {
            echo "<script>parent.location.href='$confirmation_url'</script>";
        }

        
        
        
        /*$postdata = array( 'recurring_application_charge'=> array(
        'id' => $chargeId, 
        'type' => 'number',
        'status' => 'accepted',
        'activated_on'=> date('Y-m-d H:i:s')
        ));*/
        /*$recurring_application_charge = str_replace('\\/', '/', json_encode($act_recurring_charge_arr));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $recurring_application_charge);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));*/
        ?>
        <div style="display:none;"><?php //$app_charge = curl_exec($ch);?></div>
        <?php
        // echo "<script>parent.location.href='$confirmation_url'</script>";
// =====================================================================================

        //$sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
        try
        {
            // Get all products
        $received = $sc->call('GET', "/admin/recurring_application_charges/{$chargeId}.json");
        echo "<pre>"; print_R($received); exit;
        $idvalue = $received['id'];
        $value = $received['status'];

        if($value=='accepted')
        {
        
        }
        else if($value=="declined")
        {
            //$update= mysql_query("UPDATE  `app_data_tbl` SET `charge_status` =  'declined' WHERE  `shop_id` =  '$shop_id'");
            

            ?> 
          <style>
        <style>
            .center{
            background: #fff;
                margin: 0 auto;
                padding: 20px 0;
                text-align: center;
                text-transform: capitalize;
                width: 50%;
            }
            .image-wrap {
                height: 50px;
                margin-left: auto;
                margin-right: auto;
                width: 50px;
            }img {
                float: left;
                width: 100%;
            }
            p span {
                font-size: 30px;
                color: #00ff00;
                padding: 2px 7px;
            }

        </style>
          <div class="center">
            <p><span id="seconds">1</span></p>
            <div class="image-wrap"><img src="./images/loadingAnimation.gif"/></div>
            <script>
                    // Countdown timer for redirecting to another URL after several seconds
                    var seconds = 1; // seconds for HTML
                    var foo; // variable for clearInterval() function
                    function redirect() {
                        // document.location.href = 'https://www.google.co.in';
                        document.location.href = 'https://<?php echo $shop_name?>/admin/apps/bb1b8bb50081aaef7d52faf8c2dc270b';
                    }
                    function updateSecs() {
                        document.getElementById("seconds").innerHTML = seconds;
                        seconds--;
                        if (seconds == -1) {
                            clearInterval(foo);
                            redirect();
                        }
                    }
                    function countdownTimer() {
                        foo = setInterval(function () {
                            updateSecs()
                        }, 1000);
                    }
                    countdownTimer();
            </script>
           </div>

            <?php 
// ================== Create recurring_application_charges against cencilation========================================
        $received = $sc->call('GET', '/admin/recurring_application_charges.json', array('published_status'=>'published'));
        $charge_id = $received[0]['id'];
        $value = $received['0']['status'];
        $confirmation_url = $received[0]['confirmation_url'];

     $ch = curl_init("https://$shop_name/admin/recurring_application_charges.json");
     $callback = 'http://expertvillagemedia.com/recentlyviewedproducts/charge_application_rec.php?shop='.$shop_name;
    // $callback = 'http://expertvillagemedia.com/shopifyapp/charge_application_rec.php?shop='.$query_params['shop']; 
    $postapplicationcharge = array("recurring_application_charge" => array( "name"=> "Basic Plan",
    "price"=> 5.00,
    "id"=> $charge_id,
    "test" => false,
    "trial_days"=> 7,
    "status"=> $value,
    "return_url"=> $callback,
    ));
     
    $applicationcharge = str_replace('\\/', '/', json_encode($postapplicationcharge));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicationcharge); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
    <div style="display:none;"><?php $chargeout = curl_exec($ch);?></div>

     <?php
     $sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
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
             // 	echo "<script>parent.location.href='https://$shopna/admin/apps/d3ebed10307853d5ce99c1c46b57806a'</script>";
        }
        elseif($value=='pending')
        {
        $update= mysql_query("UPDATE  `app_data_tbl` SET `charge_status` = 'pending',  `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
             echo "<script>parent.location.href='$confirmation_url'</script>";
        }
        else
            {
           $update= mysql_query("UPDATE  `app_data_tbl` SET  `charge_status` = 'pending', `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
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

// =====================================================================================================
        }
        else
        {
            $update= mysql_query("UPDATE  `app_data_tbl` SET `charge_status` =  'pending' WHERE  `shop_id` =  '$shop_id'");
             echo "<script>parent.location.href='$confirmation_url'</script>";
        }
   

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



}
else{
    echo "fail";
}

}

// ========================================================
 ?>
