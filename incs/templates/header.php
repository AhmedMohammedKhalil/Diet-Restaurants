<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?php echo $pageTitle ?></title>
		<!-- style -->
		<link rel="stylesheet" href="<?php echo $css ?>normalize.css" />
		<link rel="stylesheet" href="<?php echo $css ?>zerogrid.css" />
		<link rel="stylesheet" href="<?php echo $css ?>style.css" />
		<!-- fonts -->
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<!-- menu style -->
		<link rel="stylesheet" href="<?php echo $css ?>menu.css" />
		<!-- forms style -->
		<link rel="stylesheet" href="<?php echo $css ?>forms.css" />
	</head>
	<body>
	<div class="wrap-body">
		<header class="zerogrid">
			<div id='cssmenu' class="align-center">
				<div class="logo-header col-1-6 offset-1-6">
					<div class="wrap-col">
						<h1 style="font-family: 'Dancing Script';font-size:30px">
							<a href="<?php echo $app.'index.php'?>" style="color: #6b360e">Diet Restaurants</a>
						</h1>
					</div>
				</div>
				<ul class="col-2-6 offset-1-6" style="  margin-top: 5px;">
					<li class=" has-sub"><a href="#"><span>Menu</span></a>
						<ul class="menu">
							<li><a href='<?php echo $app.'index.php'?>'><span>Home</span></a></li>
							<li><a href='#'><span>Restaurants</span></a></li>
							<li><a href='#'><span>Meals</span></a></li>
							<li><a href='#'><span>Monthly Package Meals</span></a></li>
							<li class='last'><a href='#'><span>Restaurants Compare</span></a></li>
						</ul>
					</li>
					<li class="has-sub"><a href='#'><span>Login/Register</span></a>
						<ul>
							<li class='has-sub'><a href='#'><span>User</span></a>
								<ul>
									<li><a href='<?php echo $app.'login.php'?>'><span>Login</span></a></li>
									<li class='last'><a href='<?php echo $app.'register.php'?>'><span>Register</span></a></li>
								</ul>
							</li>
							<li class='has-sub'><a href='#'><span>Restaurant</span></a>
								<ul>
									<li><a href='<?php echo $res_path.'login.php'?>'><span>Login</span></a></li>
									<li class='last'><a href='<?php echo $res_path.'register.php'?>'><span>Register</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</header>
		