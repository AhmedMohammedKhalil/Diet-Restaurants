<?php
  ob_start();
  session_start();
	$pageTitle = 'Restaurants Register';
	include 'init.php';
	if(isset($_SESSION['username'])) {
		header("location: {$app}");
	}
	include $inc."header.php";
	if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
		$data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);
	}
?>
    <section id="container">
					<div id="main-content">
						<article class="background-transparent" >
							<div class="art-header">
								<hr class="line-2">
								<h2>Restaurants Sign Up</h2>
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
									<form name="form1"  method="Post" action="<?php echo $cont."Controller.php?do=resRegister" ?>">
										<div>
											<label for="name">Name :</label>
											<input type="text" name="name" id="name" placeholder="Enter Restaurant name" title="Enter Restaurant name" required="required" value="<?php if(isset($errors)){echo $data['name'];}?>"/>
										</div>
										<div>
											<label for="owner_name">Owner Name :</label>
											<input type="text" name="owner_name" id="owner_name" placeholder="Enter Owner name" title="Enter Owner name" required="required" 
											value="<?php if(isset($errors)){echo $data['owner_name'];}?>" />
										</div>
										<div>
											<label for="email">Email :</label>
											<input type="email" name="email" id="email" placeholder="Enter email" title="Enter email" required="required" 
											value="<?php if(isset($errors)){echo $data['email'];}?>"/>
										</div>
										<div>
											<label for="phone">Phone :</label>
											<input type="text" name="phone" id="phone" placeholder="Enter phone" title="Enter phone" required="required"
											value="<?php if(isset($errors)){echo $data['phone'];}?>" />
										</div>
										<div>
											<label for="address">Address :</label>
											<textarea name="address" id="address" class="form-control" rows="6" required="required"
													placeholder="Enter Address" title="Enter Address"><?php if(isset($errors)){echo $data['address'];}?></textarea>                                                    
										</div>
										<div>
											<label for="description">Description :</label>
											<textarea name="description" id="description" class="form-control" rows="7" required="required"
													placeholder="Enter Description about Restaurant" title="Enter Description about Restaurant"><?php if(isset($errors)){echo $data['description'];}?></textarea>                                                    
										</div>
										<div>
											<label for="password">Password :</label>
											<input type="password" name="password" id="password" placeholder="Enter Password" title="Enter Password" required="required" />
										</div>
										<div>
											<label for="co_password">Confirm password :</label>
											<input type="password" name="confirm_password" id="co_password" placeholder="Enter password again" title="Enter password again" required="required" />
										</div>
										<div>
											<label for="captcha">Enter Words in Picture</label>
											<div style="display: flex;margin-bottom:20px;justify-content:space-between">
												<input type="text" name="captcha" id="captcha" required title="Enter Captcha" placeholder="Enter captcha"  style="flex:1 ;margin:0 10px 0 0">
												<img src="<?php echo $inc.'captcha.php'?>" alt="captcha image" style="height: 45px;width: 168px;">
											</div>
										</div>
										<div>
											<span>If you have account <a href="<?php echo $cont."Controller.php?do=showResLogin" ?>">Sign In</a></span>
										</div>
										<div>
											<center><input class="submit" type="submit" name="register" value="Sign Up"></center>
										</div>

									</form>
								</div>
							</div>
						</article>
					</div>
			</section>
<?php
	include $inc . 'footer.php'; 
  ob_end_flush();

?>