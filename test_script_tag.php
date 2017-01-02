<?php
session_start(); 
$shop_name= $_SESSION['shopname']; 
 //echo $shop_name= $query_params['shop'] = $_GET['shop'];
 //$query_params['shop'] = $_GET['shop'];
//include "dbcon.php";
function send_header() {
    $expires_offset = -1; // 1 year

    header('Content-Type: application/x-javascript; charset=UTF-8');
    header('Vary: Accept-Encoding'); // Handle proxies
    header('Expires: ' .gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
    header("Cache-Control: public, max-age=$expires_offset");
}
send_header(); 
?> 


<?
$query_params['shop'] = $_GET['shop'];
$shop_name = $query_params['shop'] = $_GET['shop'];
include "dbcon.php";
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '$shop_name'");
$shop_details=mysql_fetch_array($select_store_data);
$charge_status=$shop_details['charge_status'];

//$shop_name=$shop_details['shop_address'];
//if($charge_status == "accepted")
//{
 $shop_name=$shop_details['shop_address'];
$path = "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/upload/".$shop_name."/";
$settings = mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '".$shop_name."'");

$records = mysql_num_rows($settings);
if($records > 0)
{  
while($row=mysql_fetch_array($settings))
{
 $view = $row['videogallerytheme'];

 $no_of_img=$row['noi'];
 $shop_name=$row['shop_address'];
 $show_captions=$row['show_captions'];
 
}
}




if(empty($no_of_img))
{
$no_of_img = "4";
}

$grid_width = 96/$no_of_img;
$grid_margin=4/$no_of_img;
$grid_margin=$grid_margin/2;  



 
?>


jQuery(document).ready(function(){
$(document).ready(function() 
{
var $div = $("#evm-video-gallery"); 
$('<style>.page-container{transform:none!important}</style>').appendTo('body');

<?php 
 $s_a_t = mysql_query("SELECT * FROM `videos` where `shop_address` = '$shop_name' ORDER BY id DESC");
 
$records = mysql_num_rows($s_a_t);
if($records > 0)
{   
while($l_a_t=mysql_fetch_array($s_a_t))
{
// $id=$l_a_t['id'];	 
//$img_name=$l_a_t['name'];
 $url=$l_a_t['url'];
//$video_url = explode("https://youtu.be/",$url);
//$video_id = $video_url[1];
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
   // echo "Vimeo ID: $output_array[5]";
	 $values = $id[5];
}
else {

}

?>
<?php $box = "evm-box";?>
$("#evm-video-gallery").append("<div id='evm-video-box-<?php echo $values;?>' class='<?php echo $box;?>' style='width:<?php echo $grid_width;?>%; margin:<?php echo $grid_margin;?>%; float:left; '><div class='gallery-wrap' style='position:relative; width:100%; float:left;'> <a  class='js-open-modal modal-btn' href='#' data-modal-id='popup-<?php echo $values;?>'><img src='http://img.youtube.com/vi/<?php echo $values;?>/0.jpg'/><div class='circle'><div class='circle_inner'> </div></div></a></div><?php if(!empty($show_captions)){ ?><p class='caption'><?php echo $l_a_t['name'];?></p><?php }?></div>");

$("#evm-video-box-<?php echo $values; ?> ").append("<div id='popup-<?php echo $values;?>' class='modal-box' ><a  class='js-modal-close close'  >&times;</a><iframe id='popup-youtube-player' frameborder='0'  src='https://www.youtube.com/embed/<?php echo $values; ?>' frameborder='0' allowfullscreen ></iframe><?php  if(!empty($show_captions)){  ?><p class='caption'><?php echo $l_a_t['name'];?></p><?php }?> </div>");


$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
		
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();



 
});
$(document).mouseup(function (e) {
     var popup = $("#popup-<?php echo $values;?>");
     if (!$('.close').is(e.target) && !popup.is(e.target) && popup.has(e.target).length == 0) {
         popup.hide();
	 $(".modal-overlay").remove();

	
     }
 });



<?php 

}
}
?>


});               
}); 
