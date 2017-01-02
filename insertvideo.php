<?php session_start(); 
include "dbcon.php";
$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname']; ?>
<div class="full-width addvideos">
 <?php include "header.php"; ?>
<div class="wrapper">
<div class="container">

<?php

include 'dbcon.php';
$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname'];
 if(isset($_POST['btn-save']))
{

$video_caption = $_POST['video_caption'];
$video_desc = $_POST['video_desc']; 
$video_url = $_POST['video_url'];

$insert_token= mysql_query("INSERT INTO `videos` ( `shop_address` ,`name` ,`description` ,`url` ,`id`) VALUES ('$shop_name', '$video_caption', '$video_desc', '$video_url', '$shop_id')");


$show = '<a href="viewall.php"> View Video</a>';
$msg = 'Video has been added successfully';
}
?>

<div class="insert-wrap">
<div class="left-insert-video-wrap"> 
<div class="left-section">
<h2> Post Video information </h2>
<p> Some basic information about video post.</p>

</div>
</div>

<div class="insert-video-wrap">
 <div class="wrapper">
<div class="container">
 
 <div class="show_all">
			


		    

			<div id="form-content">
 <form method='post' name="myForm" enctype="multipart/form-data" action=""id="reg-form" autocomplete="off">
       <div class="form_wrapper">
       <div class="input_addbox_wrapper">
               <label>Video Caption</label>
                <div class="input_box"><input type='text' id="video_caption" name='video_caption' class='form-control' placeholder='Video Caption' value="" /></div>
     </div>

 <div class="input_addbox_wrapper">
                <label>Video Url</label>
                <div class="input_box"><input type='url' id='video_url' name='video_url' class='form-control' placeholder='EX : https://www.youtube.com/watch?v=iCaYJS4QufY' value="" required /></div>
     </div>
      
        

<div class="input_addbox_wrapper" id="ebutton">
             <div class="input_box_submit ebtn"><button type="submit" class="btn_add_review evmbtn btn btn-info" name="btn-save" id="btn_save submit" >Save</button>  </div>

			  </div>
<div id="message"><?php if(!empty($msg)){ echo $msg;}?></div>
</div>
</form>
</div>



</div>
</div>
</div>

</div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#reg-form').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'insertvideo.php',
			type: 'POST',
			data: $(this).serialize() // it will serialize the form data
		})
		.done(function(data){
			$('#form-content').fadeOut('slow', function(){
				$('#form-content').fadeIn('slow').html(data);
			});
		})
		.fail(function(){
			alert('Ajax Submit Failed ...');	
		});
	});
	
	
	
});
</script>

