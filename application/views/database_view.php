<?php
/*
 A Page for simple Database Manipulation
*/
$error = true;
$message = false;
if(isset($query))
	$error = false;
$this->load->view('template/header_files');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="NBA BELT CHAMPIONSHIP">

<title>Database Querying</title>
<style>
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #eee;
}
</style>
</head>

<body>
	<?php $this->load->view('template/navbar');?>

	<div class="container">
		<?php
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
	<?php $this->load->view('template/footer_scripts'); ?>
</body>
</html>
