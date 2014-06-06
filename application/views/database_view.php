<?php
/*
 A Page for simple Database Manipulation
*/
$error = true;
$message = false;
if(isset($query))
	$error = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="NBA BELT CHAMPIONSHIP">

<title>Database Querying</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css"
	rel="stylesheet">

<!-- Custom styles for this template -->
<style>
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #eee;
}
</style>

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body>
	<?php $this->load->view('template/navbar');?>

	<div class="container">
		<?php

		/*

		Check if there was an Error

		*/
		if($error) {
            echo '<div class="row"><div class="bg-danger"><p class="lead text-danger">'.$message.'</p></div></div>';
        }
        ?>
		<h1>Enter Query Below:</h1>
		<form class="form" role="form" method="POST"
			action="<?php echo base_url()."landing/database"?>">
			<div class="form-group">
				<textarea name="query" class="form-control" rows="6"></textarea>
			</div>
			<button type="submit" class="btn btn-lg btn-primary">Get Results!</button>
		</form>

		<?php
		if(!$error) {
    ?>
		<div class="row">
			<div class="col-md-8">
				<?php  
				echo '<h4> Query Used: <small class="text-info">'.$q.'</small></h4>'."\n";
				echo "<pre>"; var_dump($query); echo "</pre>";
				?>
			</div>
		</div>
		<?php
        }
        ?>
	</div>
	<!-- /container -->

	<?php $this->load->view('template/footer_scripts'); ?>

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
