<?php  $shop_name=$_GET['shop_name']; ?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
<script type="text/javascript">
     ShopifyApp.ready(function(){
    ShopifyApp.init({
      apiKey: 'a87d3fc622c17aa99bfd2308dfb69e74',
      shopOrigin: '<?php echo $shop_name;?>'
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
 <div class="update-wrapper">
<div class="app-header">
  <div class="header">
  <div class="logo"><img src="images/Logo_Blue.jpg"/></div>
    <div class="app-heading">
      <ul>
	  <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">Dashboard</a></li>
	  <li><a href="">How to use</a></li>
	  <!-- <li><a href="settings.php?shop_name=<?php echo $shop_name;?>">Settings</a></li> -->
	  <li><a href="">Support</a></li>
	  </ul>
    </div>
  </div>
</div>

<div class="wrapper">
<div class="container">
<div class="inner_header">
<ul>
<li><a href="insertvideo.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Videos</a></li>
<li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">View all</a></li>
</ul>
</div>
</div>
</div>





<?php
include 'dbcon.php';
if(isset($_GET['id'])) {
$id=$_GET['id'];
if(isset($_POST['submit'])){
$name = $_POST['name'];
$url=$_POST['url'];
$update_query= mysql_query("update videos set `name` = '$name', `url`='$url' where id='$id' ");
if($update_query){ echo "<script type='text/javascript'>add('Settings have been saved successfully!')</script>"; }
}
}
$query1= mysql_query("select `id`,`name`,`url` from `videos` where `id`= '$id'");
 while ($row1=mysql_fetch_array($query1)){
$url=$row1['url'];
$name=$row1['name'];

}



if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/',  $url,$id)) {
  $values = $id[1];
} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/',  $url, $id)) {
  $values = $id[1];
} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/',  $url, $id)) {
  $values = $id[1];
} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
  $values = $id[1];
}
else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/',  $url, $id)) {
    $values = $id[1];
} else if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $id)) {
     "Vimeo ID: $output_array[5]";
	 $values = $id[5];
}
else {
// not an youtube video
}
?>

 <div class="edit-wrapper">
  <iframe src="https://www.youtube.com/embed/<?php echo $values; ?>"  frameborder="0" allowfullscreen> </iframe>
<form method="post" action="">
<input type="text" name="name" placeholder="Enter Title" value="<?php echo $name; ?>" /><br />
<input type="text" name="url" placeholder="Enter Url" value="<?php echo $url; ?>" /><br /><br />
<input type="submit" name="submit" value="update" onClick="add();" />
</form>
</div>



</div>


</body>
</html>

