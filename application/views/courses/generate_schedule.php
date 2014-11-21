<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
    <title>Generate Schedule</title>
    <?php $this->load->view('template/header_files'); ?>
    <link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/jquery.toastmessage.css" rel="stylesheet">
    <?php $this->load->view('template/navbar');?>
</head>
<style>
.divider{
    width:5px;
    height:auto;
    display:inline-block;
}
</style>
<body>
    <div class="container">
        <div class="jumbotron">
            <div class="thumbnail box span4">
                <table class="table table-bordered table-condensed" id = "selected">
                    <thead>
                        <tr bgcolor="#EFE8E8">
                            <th>Remove Course</th>
                            <th>Course Selected</th>
                            <th>Section Selected</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $user_courses = $this->nativesession->get('tempcoursenames'); 
                      if($user_courses)
                      {
                          foreach($user_courses as $course) 
                          { 
                              switch($course['section'])
                              {
                                  case "DEPT":
                                      echo '<tr id = "'.$course['ID'].'"><td><a href="#" style="text-decoration: none" class = "add btn btn-primary btn-xs remove" type = "'. $course['section'].'" id = "'.$course['ID'].'">Remove '.$course['course_name'].'</a></td>'; 
                                      break;
                                  case "ALL SECTIONS":
                                      echo '<tr id = "'.$course['course_name'].'"><td><a href="#" style="text-decoration: none" class = "add btn btn-primary btn-xs remove" type = "'. $course['section'].'" id = "'.$course['course_name'].'">Remove '.$course['course_name'].'</a></td>'; 
                                      break;
                                  default:
                                      echo '<tr id = "'.$course['section'].'"><td><a href="#" style="text-decoration: none" class = "add btn btn-primary btn-xs remove" type = "'. $course['section'].'" id = "'.$course['section'].'">Remove '.$course['course_name'].'</a></td>'; 
                                      break;
                              }
                              echo '<td>'.$course['course_name'].'</td>
                                    <td>'. $course['section'].'</td>
                                    </tr>'; 
                          }
                      } 
                    ?>
                    </tbody>
                </table>
            </div>
            <a href="#" id="clear" class="btn btn-search col-md-2">Clear Courses</a>
            <div class="divider"></div>
            <a href="#" id="Generate_Schedule" class="btn btn-search ">Generate Schedule</a>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.toastmessage.js"></script>

<script>

    $(document).ready(function() {
        $("#Generate_Schedule").click(function() {
            var tbody = $("#selected tbody");
            if (tbody.children().length == 0) 
            {
              $().toastmessage('showNoticeToast', 'Add courses to generate a schedule!'); 
            }
            else
            {
              window.location = "<?php echo base_url();?>courses/generated";
            }
        });
    });
    $(function () {
        $("#clear").click(function () {    
            $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>courses/generateschedule',
                  data: {clear:"clear" },
                  cache: false,
                  success: function (data) {
                        $('#selected tbody').empty();
                        $().toastmessage('showSuccessToast', 'Course List Cleared!');
                  }
                });
            });
        });

        $(".remove").click(function () {
            var cdata = $(this).attr("id");
            $("tr[id*='"+cdata+"']").remove();
            $.ajax({
                  type: "POST",
                  url: '<?php echo base_url();?>courses/generateschedule',
                  data: {remove: cdata },
                  cache: false,
                  success: function (data) {
                        $().toastmessage('showSuccessToast', 'Course Removed!');
                  }
                });
            });
    
</script>
</html>
