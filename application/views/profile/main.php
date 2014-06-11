<!DOCTYPE html>
<html lang="en">
<head>
<?php
$this->load->view('template/header_files');
$user = $this->tank_auth->get_username();
?>

</head>

<body>
	<?php $this->load->view('template/navbar');?>

	<div class="container">
		<div class="jumbotron">
			<h1>Profile page</h1>
		</div>


		<div class="row">
			<div class="col-md-8">
				<img src="<?php echo base_url("/assets/img/missing.jpg"); ?>"width="500">
				<form action="<?php echo base_url();?>profile/upload" method="post"
					enctype="multipart/form-data">
					<label for="file">Filename:</label> <input type="file" name="file"
						id="file"><br> <input type="submit" name="submit" value="Submit">
				</form>
			</div>
			<div class="col-md-4">
				<h2>UserName</h2>
				<p>
					<?php 
					echo $user;
					?>
				</p>

				
				<h2>Description</h2>
				<p>Hello World</p>
			</div>

		</div>
		<!--/row-->
	</div>



	<!-- /container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
</body>
</html>
