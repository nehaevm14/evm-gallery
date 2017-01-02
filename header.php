<?php 
session_start(); 
 $shop_name = $_SESSION['shopname'];

?>
<!DOCTYPE html>
<html>
<head>
<title>Evm Gallery by Expert Village Media Technologies</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
<script type="text/javascript">
     ShopifyApp.ready(function(){
    ShopifyApp.init({
      apiKey: 'b4e1fa4bf25f6bfb071bfe11a1ce136c',
      shopOrigin: '<?php echo $shop_name;?>'
	  debug: true
    });
	 });
  </script>
<script type="text/javascript">
    ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize();
    title: "Title",
    icon: "<%= asset_path('favicon.ico') %>"
  });
</script>




</head>
<body>
<div class="app-header">
  <div class="header">
  <div class="logo"><img src="images/evm-logo.png"/></div>
    <div class="app-heading">
      <ul>
	  <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">Dashboard</a></li>
	  <li><a href="installation.php?shop_name=<?php echo $shop_name;?>">How to use</a></li>
	 <li><a href="https://www.expertvillagemedia.com/app-support/">Support</a></li>
	
	  </ul>
    </div>
  </div>
</div>

<div class="wrapper">
<div class="container">


<div class="left_inner_header">
<ul>

       <li><a href="insertvideo.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Videos</a></li>
	    <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">View all</a></li>
      </ul>
</div>

<div class="right_inner_header">
<div class="right_inner_header_container"><?php include "add_setting.php";?></div>
 </div>

</div>
</div>