<?php
 $shop_name= $_SESSION['shopname']; 
 $query_params['shop'] = $_GET['shop'];
include "dbcon.php";

$stmt= mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '$shop_name'");

$records = mysql_num_rows($stmt);
if($records > 0)
{ 
 while($row=mysql_fetch_array($stmt))
{
$videogallerytheme= $row['videogallerytheme'];
$noofimg=$row['noi'];
 $shop_name = $row['shop_address'];
 $showcaptions=$row['show_captions'];
}
}
if($_POST)
{
$videogallerytheme = $_POST['videogallerytheme'];
$shop_name=$_POST['shop_name'];
if(empty($videogallerytheme))
{
$videogallerytheme=$gallerytheme;
}

 $noofimg = $_POST['noi'];
 $shop_name=$_POST['shop_name'];
  $show_captions=$_POST['show_captions'];
if(empty($show_captions))
{
$showcaptions=$show_captions;
}
if(!empty($noofimg))
{

$noofimg=$noofimg;
}
else {$noofimg=4;}
$select_settings = mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '$shop_name'");


 $rec = mysql_num_rows($select_settings);
if($rec > 0)
{  
$update_token=mysql_query("UPDATE  `gallery_settings` SET  `videogallerytheme` =  '$videogallerytheme',    `noi` =  '$noofimg',`show_captions`= '$show_captions' WHERE  `shop_address` = '$shop_name'");

}
else
{
$insert_token= mysql_query("INSERT INTO `gallery_settings` ( `shop_address` , `videogallerytheme` ,  `noi`,`show_captions` ) VALUES ('$shop_name', '$videogallerytheme',  '$noofimg','$show_captions')");

}

echo "<script type='text/javascript'>add('Settings have been saved successfully!')</script>";
}
?>

<div class="setting-wrapper">
<form method="post" id="reg-form" autocomplete="off" enctype="multipart/form-data" name="myForm">
  
  
  
    <div class="input_box_wrapper" id="imgoptions">
	<input type="hidden" name="shop_name" value="<?php echo $shop_name;?>"/>
	<div style="display:none;"> <input type="radio" name="videogallerytheme" value="grid"  class="radio" id="grid" <?php {echo "checked";} ?>  /></div>
            <label>No. of videos </label>
			<div class="input_box radiosection">
              <div class="input_box">
			
			  <input  name="noi" value="<?php echo $noofimg; ?>" type="number"  min="1" max="6" />
              </div>
            </div>
          </div>
		
	

 
          <div class="input_box_wrapper">
            <label>Show captions</label>
            <div class="input_box radiosection">
              <div class="input_box">
                <input type='checkbox' id="show_captions" name='show_captions' class='form-control' value="show_captions" <?php if($show_captions=="show_captions"){echo "checked";}elseif($showcaptions=="show_captions") {echo "checked";}?>/>
             <!--   <label for ="show_captions">Enable</label> -->
              </div>
            </div>
     </div>
	 
	<script src="./js/jscolor.js"></script>
	<!--<div class="one-third">
          <div class="input_box_wrapper">
            <label>Font Color</label>
            <div class="input_box radiosection">
              <div class="input_box">
               <input type='text' id="font_color" name='plus_font_color' class='form-control jscolor' value="<?php if(!empty($plus_font_color)){echo $plus_font_color;}elseif(!empty($plusfcolor)) {echo $plusfcolor;} else{echo "#000";}?>"/>
              </div>
            </div>
          </div>
   </div> 	-->  
  
  <div class="input_box_submit ebtn">
    <button type="submit" class="btn btn" name="btn-settings" id="btn_settings" >Save</button>
  </div>
  
  
  
  
</form>
   </div>