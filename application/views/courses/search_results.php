<?php
  $view = True;
  try
  {
    if(empty($courses))
      $view = False;
  }
  catch(Exception $e)
  {
    $view = False;
  }
  $selected = $this->nativesession->get('tempcoursenames');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
<title>Search Results</title>
<?php $this->load->view('template/header_files'); ?>
<link href="<?php echo base_url();?>assets/css/signin.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/jquery.toastmessage.css" rel="stylesheet">
</head>

<body>
<?php  //NEED TO FIX PHP ECHO VS STRAIGHT HTML
    if($this->tank_auth->is_logged_in())
      $this->load->view('template/navbar');
    else  
      $this->load->view('template/navbar_unlogged');
?>
<div class="container">
		<div class="jumbotron" style="text-align: center;">
 			<br><h2>Search Results For: <?php echo $query;?></h2></br>
      <?php if($view):?>
        <p>Number of Matches: <?php echo $matches;?></p>
              <p>Page: <?php echo $current_page+1;?></p>
              <p>Searchid: <?php echo $sid;?></p>
   		 <?php if($DEPT):?>
        <p>Department: <?php echo $DEPT;?></p>
       <?php endif; ?>
 			  <p>*You may add multiple sections of a given course, or the course itself*</p>
              <a href = "#" class = "showAll">Show/Hide All Discussions</a>
      <?php endif; ?>
 </div>

 	<div class="row-fluid">
        <div class="thumbnail span17 box">	
            <table class="table table-bordered table-condensed table-responsive" id="results-table" cellpadding="5px">
                <tr align="center" bgcolor= "#C3C8CE">
                	  <th>Discussion(s)</th>
                    <th>Course Number</th>
                    <th>Section</th>
                    <th>Credits</th>
                    <th>Course Title</th>
                    <th>Course Instructor</th>
                    <th>Lect./Disc. Day</th>
                    <th>Lect./Disc. Period</th>
                    <th>Lect./Disc. Location</th>
                    <th>RateMyProf</th>
                </tr>
<?php
  if($view)
  {
    foreach($courses as $index => $course)
    {
    		echo'
              <tr align="center">';
              if($discussions[$course['section']])
                  echo'<td><a href = "#" class = "show" id = "'.$index.'">Show/Hide Discussions</a></td>';
              else
              {
                  echo'<td>None <p><a href="#" type = "COURSE" style="text-decoration: none" class ="add btn btn-primary btn-xs" id ="'.$course['course_name'].'" >+ '.$course['course_name'].'</a></p>';
                  if($course['section'] != 'DEPT')
                    echo'<a href="#" style="text-decoration: none" class = "add btn btn-primary btn-xs" type = "SECTION" id = "'.$course['section'].'">+'.$course['section'].'</a></td>';
                  else
                    echo'<a href="#" style="text-decoration: none" class = "add btn btn-primary btn-xs" type = "ID" id = "'.$course['ID'].'">+'.$course['section'].'</a></td>';   
              }
              echo '<td><a href ="javascript:openPage(\''.$course['course_name'].'\')">'.$course['course_name'].'</a></td>
                    <td>'.$course['section'].'</td>
                    <td>'.$course['credits'].'</td>
                    <td>'.$course['title'].'</td>
                    <td>'.$course['instructor'].'</td>
                    <td>'.$course['lecture_day'].'</td>
                    <td>'.$course['lecture_period'].'</td>
                    <td>'.$course['lecture_building'].' '.$course['lecture_room'].'</td>
                    <td>'.$course['rating'].'</td></tr>';

              foreach($discussions[$course['section']] as $discussion)
              {
                   if($course['section'] != 'DEPT')
                      echo '<tr align="center" bgcolor= "#E5E5E5" class = "row'.$index.'" id = "'.$index.'" style="display: none;">'.'<td><a href="#" type = "COURSE" style="text-decoration: none" class ="add btn btn-primary btn-xs" id ="'.$course['course_name'].'" >+ '.$course['course_name'].'</a></td><td><a href="#" type = "SECTION" style="text-decoration: none" class = "add btn btn-primary btn-xs" id = "'.$course['section'].'">+'.$course['section'].'</a></td><td></td><td></td><td></td><td></td><td>';
                   else 
                      echo '<tr align="center" bgcolor= "#E5E5E5" class = "row'.$index.'" id = "'.$index.'" style="display: none;">'.'<td><a href="#" style="text-decoration: none" class ="add btn btn-primary btn-xs" id ="'.$course['course_name'].'" >+ '.$course['course_name'].'</a></td><td><a href="#" type="ID" style="text-decoration: none" class = "add btn btn-primary btn-xs" id = "'.$course['ID'].'">+'.$course['section'].'</a></td><td></td><td></td><td></td><td></td><td>';
                   if(!$discussion["discussion_room"] && $course['lecture_building'] && $discussion["discussion_building"] != "WEB")//Fixes error with missing discussion location missing
                      echo $discussion["discussion_day"].'</td><td>'.$discussion["discussion_period"].'</td><td>'.$course['lecture_building'].' '.$discussion["discussion_building"];
                   else
                      echo $discussion["discussion_day"].'</td><td>'.$discussion["discussion_period"].'</td><td>'.$discussion["discussion_building"].' '.$discussion["discussion_room"];
                   echo '</td><td></td></tr>';
               } 
    }
    echo '</table><div style="text-align:center">';
    
    if($pages == 1)
      echo'Page: <a href= "'.base_url().'courses/searchresults/0/'.$sid.'">'.$pages.'</a>';
    elseif($pages != 'p')
    {
      echo'Page: ';
      for($i=0;$i<$pages;$i++)
        echo'<a href= "'.base_url().'courses/searchresults/'.$i.'/'.$sid.'">'.($i+1).'</a>|';
    }
    echo "</div>";

  }
?>
     </div>
    </div>
    <a href = "<?php echo base_url();?>landing/viewcourses"><button class="btn btn-search col-md-2">Back To Search Page</button></a>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.toastmessage.js"></script>
<script>
    var imagePath = "<?php echo base_url();?>assets/images/";
    function UpdatePage() 
    {
      var selected = <?php echo json_encode($selected); ?>;
      for(var i=0;i<selected.length;i++)
            if(selected[i].section == "ALL SECTIONS")
              $("a[id*='"+selected[i].course_name+"']").remove();
            else
              $("a[id*='"+selected[i].section+"']").remove();
    }
    function openPage(name)
    {
        var url = "http://www.registrar.ufl.edu/cdesc?crs=" + name;
        var win = window.open(url, '_blank');
        win.focus();
    }
    $(document).ready(
        function () {

            $(".row").hide();
            $(".show").click(function () {
                var rowId = $(this).attr("id");
                $(".row" + rowId).toggle(400);
                return false;
            });
            $(".showAll").click(function () {
                for (var rowId = 0; rowId < <?php echo sizeof($courses)?>; rowId++) {
                    $(".row" + rowId).toggle(400);
                }
                return false;
            });
            $(".add").click(function () {
                var cdata = "";
                switch($(this).attr("type"))
                {
                  case "SECTION":
                      cdata ={section: $(this).attr("id")};
                      break;
                  case "ID":
                      cdata ={ID: $(this).attr("id")};
                      break;
                  case "COURSE":
                      cdata ={course: $(this).attr("id")};
                      break;
                }
                $("a[id*='"+$(this).attr("id")+"']").remove();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>courses/generateschedule",
                    data: cdata,
                    dataType: "text",
                    cache: false,
                    success: function (data) {
                        switch(data)
                        {
                          case "Found":
                              $().toastmessage('showNoticeToast', 'You have already added this section'); 
                              break;
                          case "nsi":
                              $().toastmessage('showErrorToast', 'Please sign in to add courses'); 
                              break;  
                          default:
                              $().toastmessage('showSuccessToast',data);
                        }
                        
                    }
                });
                return false;
            });
        });
</script>
<script type='text/javascript'>window.onload=UpdatePage;</script>
</html>
