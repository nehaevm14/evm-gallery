<?php 
session_start();
$shop_name= $_SESSION['shopname'];
?>
<html>
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link href ='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' type="text/css">
<link rel="stylesheet" href="stylesheet.css" type="text/css" >
</head>

<div class="settings">	
<div class="container">	
<?php include 'settings_submit.php' ;?>		
</div>
</div>




<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#reg-form').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'settings_submit.php',
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



</html>