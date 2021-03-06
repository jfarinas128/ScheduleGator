<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
    <title>Generated Schedule</title>
    <?php $this->load->view('template/header_files'); ?>
    <link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/jquery.toastmessage.css" rel="stylesheet">
    <?php $this->load->view('template/navbar');?>
</head>

<body>
<div class="container">
  <div class="jumbotron">
    <div class="thumbnail box span4">
<?php
//echo '<p>Smallest Group: '.$smallest;
foreach($selected_courses as $index => $course_group)
{
    echo '<p>Group: '.$index.' Size:'.sizeof($course_group).'</p>';
    foreach ($course_group as $course) 
      {
        echo '<pre>';
        print $course['course_name'];
        echo '<br/>';
        print_r($course['lecture_period_array']);
        print_r($course['lecture_day']);
        echo '</pre>';
      }
}

echo '<p>Generated SQL</p>';
echo '<pre>';
print_r($openinfo);
echo '<br/>';
echo '</pre>';

echo '<p>Discussions</p>';
echo '<pre>';
print_r($course_availability);
echo '<br/>';
echo '</pre>';

echo '<p>Ineligible Courses</p>';
echo '<pre>';
print_r($ineligible_courses);
echo '<br/>';
echo '</pre>';

echo '<p>Selected Courses</p>';
echo '<pre>';
print_r($selected_courses);
echo '<br/>';
echo '</pre>';

?>
    </div>
  </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.toastmessage.js"></script>
</html>
