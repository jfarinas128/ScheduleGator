<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url();?>landing">ScheduleGator</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo base_url();?>profile">Profile</a></li>
				<li><a href="<?php echo base_url();?>landing/viewcourses">Courses</a></li>
				<li><a href="<?php echo base_url();?>courses/generateschedule">Generate Schedule</a></li>
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown">More <b class="caret"></b>
				</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url();?>landing/database">DB Query</a>
						</li>
						<li><a href="<?php echo base_url();?>landing/logout">Logout</a></li>
					</ul>
				</li>
				<li><a href="<?php echo base_url();?>landing/about">About</a></li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
</div>
