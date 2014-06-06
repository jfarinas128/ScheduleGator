<!DOCTYPE html>
<?php
$email = $this->session->userdata('email');
?>

<html lang="en">
<head>
<?php
$data = array();
if(isset($title)){
	$data['title'] = $title;
}
$this->load->view('template/header_files',$data);
?>
</head>
<body>
	<?php $this->load->view('template/navbar');?>
	<div class="container">
		<div class="jumbotron">
		<h1 align = "center">Welcome to ScheduleGator!</h1>
		</div>
		<p>ScheduleGator is a web application built for University of Florida students. With ScheduleGator you can generate a schedule tailored to your lifestyle! Courses are selected based on professor rating and average GPA while accommodating your timing preferences and keeping you on track to graduate. ScheduleGator is now in open beta! </p>
		
		<table width="95%" border="0" cellpadding="50" style="text-align:center;">
			<tr>
				<td style="width:30%;">
					<h2> Rate My Professor integration </h2> 
					<p>Be taught by the best instructors and TAs UF has to offer. </p> 
					<img src="http://upload.wikimedia.org/wikipedia/en/0/09/RateMyProfessors.com_Logo.jpg" height="75px" />
				</td>
				
				<td style="width:30%;">
					<h2> No more early morning or late night classes </h2>
					<p>Get class times to fit your schedule and personal preferences. </p>
					<img src="http://colouringbook.org/SVG/2011/COLOURINGBOOK.ORG/CBOOK/orologio_clock_alarm_icon_coloring_book_colouring-1969px.png" height="75x" /> </p>
				</td>
				
				<td style="width:30%">
					<h2> Easily search and browse courses </h2>
					<p> Search by course, department, or professor using our clean interface. </p>
					<img src="http://www.userlogos.org/files/logos/ingalls/isis.png" height="75px" /> </p>
				</td>
			</tr>
		</table>

		
		<hr>
		<h2> Get started with these easy steps: </h2> 
		<ol>
			<li> Browse courses and view professor ratings </li>
			<li> Add classes you're interested to the schedule creator.  </li> 
			<li> Choose your timing preferences. </li>
			<li> Decide how many credits you want to take. </li>
			<li> Automatically generate your course schedule </li> 
		</ol>

		
	</div>

	<!-- /container -->

	<?php $this->load->view('template/footer_scripts'); ?>

</body>
</html>
