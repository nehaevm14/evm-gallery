<?php session_start(); 
include "dbcon.php";
$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname']; ?>

<div class="viewvideo-wrap">
<?php
include "dbcon.php";

$query_params['shop'] = $_GET['shop'];
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
$shop_details=mysql_fetch_array($select_store_data);
 $shop_name=$shop_details['shop_address'];
$shop_token=$shop_details['shop_token'];
$shop_tbl_id=$shop_details['shop_id'];
$_SESSION['shopid'] = $shop_token;

if($_GET['del_id'])
{
	$did = $_GET['del_id'];	
	$shop = $_GET['shop_name'];	
	$stmt=mysql_query("DELETE FROM `videos` WHERE `id` = '$did' and `shop_address`  = '$shop'");

}
?>
<?php include "header.php";?>


<div class="wrapper">
<div class="container">


  

 
 <div class="show_all">

 <?php 
include "dbcon.php";
$query= "SELECT * FROM `videos` WHERE `shop_address` = '$shop_name'  ";
$result = mysql_query($query);
 
 while($row= mysql_fetch_array($result, MYSQL_ASSOC)){
  $video_url=$row['url'];
 ?>

<div class="videolist">
 <ul>

 <li>
 <?php

if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/',  $video_url,$id)) {
  $values = $id[1];
} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/',  $video_url, $id)) {
  $values = $id[1];
} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/',  $video_url, $id)) {
  $values = $id[1];
} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $video_url, $id)) {
  $values = $id[1];
}
else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/',  $video_url, $id)) {
    $values = $id[1];
} else if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video_url, $id)) {
     "Vimeo ID: $output_array[5]";
	 $values = $id[5];
}
else {

}

  ?>
 
  <iframe src="https://www.youtube.com/embed/<?php echo $values; ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
  
   
  <div class="update-section">
 <div class="caption">
  <p class="video-title"><?php echo $row['name']; ?></p>
  <p class="video-description"> <?php echo $row['description']; ?></p>
  </div>
 <div class="edit-section">
<span class="edit-icon"><a href="edit.php?id=<?php echo $row['id'] ?>&shop_name= <?php echo $shop_name;?>">

<img src="images/edit.png"/>
</a> </span>
 </div>
 <div class="delete-section">
<span class="delete-icon"><a href="viewall.php?del_id=<?php echo $row['id'] ?>&shop_name=<?php echo $shop_name; ?>">

   <img src="images/delete1.png"/> </a></span>
 </div>
 
 </div>
  
  
  </li>
  



 </ul>

 
 
 </div>
 

 <?php } ?> 


</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
<!--<script src="js/jquery-1.11.2.js" ></script> -->
<script type="text/javascript">
$('input[type="radio"]').click(function(){
if($(this).attr("value")=="grid"){
    $("#imgoptions").css('display','block');
}  
   if($(this).attr("value")!="grid"){
    $("#imgoptions").css('display','none');
  }       
});
</script>
