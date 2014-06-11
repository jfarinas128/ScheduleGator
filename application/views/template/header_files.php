    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jordan">
    
    <?php 
    if(!isset($title)) 
        echo "\t".'<title>ScheduleGator Home Page</title>';
    else
        echo "\t<title>$title</title>";
    
    ?>
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/gif" href="<?php echo base_url();?>gator.gif"/>  
