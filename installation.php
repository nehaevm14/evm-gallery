<?php
session_start();
 require 'shopify.php';
    include "dbcon.php";
$shop_name=$_GET['shop_name'];
     $select_shop_record=mysql_query("SELECT * FROM  `app_data_tbl` WHERE  `shop_address` =  '$shop_name'");
        $shop_record=mysql_fetch_array($select_shop_record);
        $shop_token=$shop_record['shop_token'];
  define('SHOPIFY_API_KEY','b4e1fa4bf25f6bfb071bfe11a1ce136c');
    define('SHOPIFY_SECRET','bf722894926470d79509147b9a767737');
	define('SHOPIFY_SCOPE','read_script_tags,write_script_tags,read_themes, write_themes'); 
	$shopifyClient = new ShopifyClient($shop_token, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
    $sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
     $themes = $sc->call('GET', '/admin/themes.json', array('published_status'=>'published'));
	 $shop_details = $sc->call('GET', '/admin/shop.json');
	$shop_email= $shop_details[email];
foreach ($themes as $themedetails) {
if($themedetails['role']=="main")
{
$themeid=$themedetails['id']; 
}
}
 
?>
<title>Evm Gallery by Expert Village Media Technologies</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="wrapper" id="howtouse">
<div class="container">
<div class="howtouse-container">
<div class="inner_wrapper">
<div class="inner_wrapper_container">

<section id="introduction" class="introduction">
<h4>Video Gallery App</h4>

</section>
<section id="add_video">
<h4>Add Videos to Gallery</h4>
<p>To add Videos in Gallery, click on the add Video tab on top and add the Video Url to show the Videos.</p>
<img src ="https://www.apps.expertvillagemedia.com/shopify/evm-gallery/images/addimg.png" style="margin-bottom:10px;"/>
</section>

<section id="view_all">
<h4>Show All Videos</h4>
<p>Here you can see all the Videos of your Gallery.You can edit or delete the videos from here.</p>
<img src ="https://www.apps.expertvillagemedia.com/shopify/evm-gallery/images/deleteandedit.png" />
</section>
<section id="settings">
<h4>Grid Settings</h4>
<p>From settings section you can choose the number of videos you want to display in Grid.</p>
<img src ="https://www.apps.expertvillagemedia.com/shopify/evm-gallery/images/gridedit.png" />
</section>
<section id="settings">
<h4>Add a code in your liquid file,where you want to show Video Gallery.</h4>
<p>
Paste the following code in your liquid file, where you want to show Video Gallery.</p>
<p><textarea>{% include 'evm-gallery' %}</textarea></p>
You can click <a href="https://<?php echo $shop_name;?>/admin/themes/<?php echo $themeid;?>?key=templates/index.liquid" target="_blank" style="color:#ff0000;">here</a> to reach directly to your theme files section. Click on online store in left panel in Shopify admin. <br/>


<h4>Add a link to your Video Gallery in your navigation.</h4> 
<p><a href="https://help.shopify.com/manual/sell-online/online-store/menus-and-links#add-a-link-to-a-menu" target="_blank">Refer this for more clear understanding.</a></p>

<p>1.In your Shopify store go to your the navigation section and select the link list in which you would like your Video Gallery to appear on.</p>
<p>2.Click <b>"ADD ANOTHER LINK".</b></p>
<p>3.Add the "Link Name" whatever you would like to see in your navigation bar on front end. Under "Links to" select "PAGE". In the 3rd column you will see that the app has created a page called "Video Gallery" select this page and save your changes.</p>

</section>
<section id="layouts">
<h4>Layouts preview on front end</h4>

<div class="grid">
<img src ="https://www.apps.expertvillagemedia.com/shopify/evm-gallery/images/galleryfront.png" style="width:100%;float:left;"/>
</div>

</section>


</div>
</div>
</div>

</div>
</div>
<style>
#nav{display:none;}
</style>