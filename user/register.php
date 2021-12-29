<?php
	ob_start();
	session_start();
	$pageTitle = 'User Register';
	include 'init.php';
	include $inc."header.php";
	if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
		$data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);
	}
?>
<section id="container">
					<div id="main-content">
						<article class="background-transparent">
							<div class="art-header">
								<hr class="line-2">
								<h2>User Sign Up</h2>
							</div>
							<div class="art-content">
									<?php if(isset($errors)) {
										echo '<ul style="width:50%;margin:0 auto">';
										foreach($errors as $er) {
											echo "<li style='color:red;text-align:left'>$er</li>";
										}
										echo '</ul>';
									}?>
									<div class="form">
										<form name="form1" method="Post" action="<?php echo $cont."Controller.php?do=userRegister" ?>">
											<div>
												<input type="text" name="name" id="name" placeholder="Enter name" required="required" 
												value="<?php if(isset($errors)){echo $data['name'];}?>"/>
											</div>
											<div>
												<input type="email" name="email" id="email" placeholder="Enter email" required="required" 
												value="<?php if(isset($errors)){echo $data['email'];}?>"/>
											</div>
											<div>
												<input type="password" name="password" id="password" placeholder="Enter Password" required="required" />
											</div>
											<div>
												<input type="password" name="confirm_password" id="password" placeholder="Enter password again" required="required" />
											</div>
											<div>
												<textarea name="address" id="address" class="form-control" rows="6" required="required"
													placeholder="Enter Address"><?php if(isset($errors)){echo $data['address'];}?></textarea>                                                    
											</div>
											<div>
												<span>If you have account <a href="<?php echo $cont."Controller.php?do=showUserLogin" ?>">Sign In</a></span>
											</div>
											<div>
												<center><input class="submit" type="submit" name="register" value="Sign Up"></center>
											</div>

										</form>
									</div>
							</div>
						</article>
					</div>
			</section></div>
<?php
	include $inc . 'footer.php'; 
  ob_end_flush();

?>