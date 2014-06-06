<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author"content="Jordan Farinas">

<title>ScheduleGator Sign-In</title>
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css"rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/signin.css"rel="stylesheet">

</head>

<body style = "background-color: #5E9BE4;">

		<div class="row">

			<form class="form-signin" role="form" method="POST"
				action="<?php echo base_url();?>landing/">
				<h2 class="form-signin-heading" align = "center">Sign-In</h2>
				<input type="email" name="email" class="form-control"
					placeholder="Email address" required autofocus> <input
					type="password" name="password" class="form-control"
					placeholder="Password" required> <label class="checkbox"> <input
					type="checkbox" name="remember" value="remember-me">Remember me
				</label>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			</form>
		</div>
		<div class="row">

			<form class="form-signin" role="form" method="POST"
				action="<?php echo base_url();?>landing/register">
				<h2 class="form-signin-heading" align = "center">Register Here:</h2>
				<input type="text" name="first" class="form-control"
					placeholder="First Name" required> <input type="text" name="last"
					class="form-control" placeholder="Last Name" required> <input
					type="email" name="email" class="form-control"
					placeholder="Email address" required> <input type="password"
					name="password" class="form-control" placeholder="Password"
					required>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
			</form>
		</div>

</body>
</html>
