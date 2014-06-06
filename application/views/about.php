<!DOCTYPE html>
<?php
?>

<html lang="en">
<head>

<?php $this->load->view('template/header_files');
$this->load->model('User_model');
?>
</head>

<body>

	<div class='container'>

		<?php $this->load->view('template/navbar');?>
		<div class="jumbotron">
			<h1>About Us</h1>

		</div>
		<div class='container'>
			<div class='row'>
			Rag tag group of developers making an awesome site!
			</div>
		</div>

	</div>


	<?php $this->load->view('template/footer_scripts'); ?>
</body>
</html>
