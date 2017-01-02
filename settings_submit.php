<?php

 $shop_name= $_SESSION['shopname']; 
 $query_params['shop'] = $_GET['shop'];
include "dbcon.php";

//$shop_name=$_SESSION['shopname'];

// include 'dbcon.php';
//echo $shop_name = $_GET['shop_address'];
$stmt= mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '$shop_name'");

$records = mysql_num_rows($stmt);
if($records > 0)
{ 
 while($row=mysql_fetch_array($stmt))
{
$videogallerytheme= $row['videogallerytheme'];
$noofimg=$row['noi'];
 $shop_name = $row['shop_address'];
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
if(empty($noofimg))
{
$noofimg=$noofimg;
}
$select_settings = mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '$shop_name'");


 $rec = mysql_num_rows($select_settings);
if($rec > 0)
{  
$update_token=mysql_query("UPDATE  `gallery_settings` SET  `videogallerytheme` =  '$videogallerytheme',    `noi` =  '$noofimg' WHERE  `shop_address` = '$shop_name'");

}
else
{
$insert_token= mysql_query("INSERT INTO `gallery_settings` ( `shop_address` , `videogallerytheme` ,  `noi` ) VALUES ('$shop_name', '$videogallerytheme',  '$noofimg')");

}
echo $msg="Settings have been saved successfully";

}





?>



<div class="wrapper">
<form method="post" id="reg-form" autocomplete="off" enctype="multipart/form-data" name="myForm">
  <input type="hidden" name="shop_name" value="<?php echo $shop_name;?>"/>
  <div id="form-content">
    <div class="form_wrapper">
      <div class="input_box_wrapper">
        <div class="span-6 section-summary">
          <label>Layout</label>
        </div>
        <div class="span-8 section-summary radiobtns">
         
          <div class="radiosection input_box">
		 
        <input type="radio" name="videogallerytheme" value="grid"  class="radio" id="grid" <?php if ($videogallerytheme=="grid") {echo "checked";} elseif ($gallerytheme=="grid") {echo "checked";}?>  />
            <label for="grid"><i class="fa fa-th" aria-hidden="true"></i> <span>Grid</span><div class="overlay-checked"></div></label>
          </div> 
          <!--<div class="radiosection input_box">
            <input type="radio" name="videogallerytheme"  class="radio" value="list" id="list" <?php if ($videogallerytheme=="list") {echo "checked";} elseif ($gallerytheme=="list") {echo "checked";}?>  />
            <label for="list"> <i class="fa fa-list" aria-hidden="true"></i> <span>List</span><div class="overlay-checked"></div></label>
          </div> -->
		  <div class="input_box_wrapper" id="imgoptions">
            <label>No of images in one row </label>
            <div class="input_box radiosection">
              <div class="input_box">
<input type = "text" name="noi" value="<?php if(!empty($noofimg)) {echo $noofimg;} elseif(!empty($noofimg)){echo $noofimg;} else{echo "4";}?>" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  

  <div class="input_box_submit ebtn">
    <button type="submit" class="btn btn" name="btn-settings" id="btn_settings">Save</button>
  </div>  </div>
  </div>
</form>

</div>


<script src="https://code.jquery.com/jquery-1.11.2.js"></script>
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



