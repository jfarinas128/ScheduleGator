<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
    <title>Generate Schedule</title>
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">
    <?php $this->load->view('template/navbar');?>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <div class="thumbnail box span4">
                <table class="table table-bordered table-condensed">
                    <tr bgcolor="#EFE8E8">
                        <th>Course Selected</th>
                        <th>Section Selected</th>
                    </tr>
                    <?php 
                      $arr= $this->nativesession->get('tempcourses'); 
                      $user_courses = $this->nativesession->get('tempcoursenames'); 
                      foreach($user_courses as $course) { 
              print '<tr>
                        <td>'.$course['course_name'].'</td>
                        <td>'. $course['section'].'
                        </td>
                    </tr>'; 
                    var_dump($arr);} ?>
                </table>
            </div>
            <a href="#" id="clear" class="btn btn-search col-md-2">Clear Courses</a>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $("#clear").click(function () {
            $.post("<?php echo base_url();?>courses/generateschedule", function (data) {
                alert("Courses Cleared!");
                window.location.reload();
            });
        });
    });
</script>

</html>
