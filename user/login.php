<?php
	ob_start();
	session_start();
	$pageTitle = 'User login';
	include 'init.php';
	$headerTitle = 'User Login';
	include $inc.'header.php';
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
						<h2>User Sign In</h2>
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
							<form name="form1"  method="Post" action="<?php echo $cont."Controller.php?do=userLogin" ?>">
								<div>
									<input type="email" name="email" id="email" placeholder="Enter email" required="required" 
									value="<?php if(isset($errors)){echo $data['email'];}?>"/>
								</div>
								<div>	
									<input type="password" name="password" id="pass" placeholder="Enter Password" required="required" />
								</div>
								<div>
									<span>If you don't have account <a href="<?php echo $cont."Controller.php?do=showUserRegister" ?>">Sign Up</a></span>
								</div>			
								<div>
									<center><input class="submit" type="submit" name="login" value="Sign In"></center>
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