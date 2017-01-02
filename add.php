<?php session_start(); 
include "dbcon.php";
$query_params['shop'] = $_GET['shop'];
 $shop_name=$_SESSION['shopname']; ?>
<div class="full-width">
 <?php include "header.php"; ?>
<div class="wrapper">
<div class="container">

<?php  include "dbcon.php";

$query_params['shop'] = $_GET['shop'];
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
$shop_details=mysql_fetch_array($select_store_data);
$shop_name=$shop_details['shop_address'];
$shop_token=$shop_details['shop_token'];
$shop_tbl_id=$shop_details['shop_id'];
$_SESSION['shopid'] = $shop_token;
?>


<div class="container-wrap">
 
  
  <div class="form-group">
   <h2 align="center">Add or Remove input fields</h2>
   <script type="text/javascript">
function validate()
{
var pattern=/\s/;
if(document.getElementById("url").value.match(pattern))
{
alert("Whitespaces are not allowed");
return false;
}
}
</script>
    <form name="add_name" id="add_name"  onsubmit="return validate()">
	

	
      <div class="table-responsive">
        <table class="table table-bordered" id="dynamic_field">
		
          
<tr class="add-remove"> <td class="addmore">
<button type="button" name="add" id="add" class="btn btn-success">Add More</button></td></tr>

            <tr class="add-row2"><td> <p>Videos</p> </td> <td> <p>Link</p> </td> <td> <p>Description</p> </td> <td class="lastrow"> <p>Action</p> </td>   </tr>
			<tr class="add-row3" >
            <td><input type="text" id="name"  name="name[]" placeholder="Video caption" class="form-control name_list" />
			</td>
            <td><input type="url" name="url[]" data-validation="url" placeholder="Enter url" class="form-control url_list" id="url" required /> </td>
			 <td><textarea class="form-control" name="desc[]" type="hidden" placeholder="Enter Description"  ></textarea></td> 
          <td class="lastrow"></td>
          </tr>
       
        </table>
        <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit"  />
      </div>
    </form>
  </div>
</div>


<script>

  
 $(document).ready(function(){  
      var i=1; 
	  //  var name = $("#name").val(); 
	  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="video caption" class="form-control name_list" /></td><td><input type="number" data-validation="url" name="url[]" required placeholder="Enter Url" class="form-control url_list" /></td><td><textarea class="form-control" name="desc[]" placeholder="Enter Description" ></textarea></td><td class="lastrow"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){    
	  
	          
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
				
             success:function(data)  
              {  
               //      alert(data);  
                   $('#add_name')[0].reset();  
				 
               }  
           }); 
		  
		  

      
	  }); 
	   
 });  
 </script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
 
 
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
 <li ><?php echo $row['name']; ?> </li>
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
    echo "Vimeo ID: $output_array[5]";
	 $values = $id[5];
}
else {
// not an youtube video
}

  ?>
 
  <iframe src="https://www.youtube.com/embed/<?php echo $values; ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
  </li>
  <li > <?php echo $row['desc']; ?> </li>



 </ul>
 </div>
 <?php } ?> 


</div>
</div>
</div>
 
 
  
  
  </div> 
  </div>
 
 </div>


