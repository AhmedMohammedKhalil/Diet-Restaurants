<?php
	ob_start();
    session_start();
	$pageTitle = 'Restaurants login';
	include 'init.php';
    if(isset($_SESSION['username'])) {
		header("location: {$app}");
	}
	$headerTitle = 'Restaurants Login';
    include $inc.'header.php';
    if(isset($_GET['errors'])) {
        $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
        $data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);
      }
?>
<section id="container">
        <div id="main-content">
            <div class="wrap-content zerogrid ">
                <article class="background-transparent">
                    <div class="art-header">
                        <hr class="line-2">
                        <h2>Restaurants Sign In</h2>
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
                            <form name="form1"   method="Post" action="<?php echo $cont."Controller.php?do=resLogin" ?>">
                                <div>
									<label for="email">Email</label>
									<input type="email" name="email" id="email" placeholder="Enter email" title="Enter email" required="required" 
									value="<?php if(isset($errors)){echo $data['email'];}?>"/>
								</div>
								<div>
									<label for="pass">Password</label>	
									<input type="password" name="password" id="pass" placeholder="Enter Password" title="Enter Password" required="required" />
								</div>
                                <div>
									<label for="captcha">Enter Words in Picture</label>
									<div style="display: flex;margin-bottom:20px;justify-content:space-between">
										<input type="text" name="captcha" id="captcha" required title="Enter Captcha" placeholder="Enter captcha"  style="flex:1 ;margin:0 10px 0 0">
										<img src="<?php echo $inc.'captcha.php'?>" alt="captcha image" style="height: 45px;width: 168px;">
									</div>
								</div>
                                <div>
                                    <span>If you don't have account <a href="<?php echo $cont."Controller.php?do=showResRegister" ?>">Sign Up</a></span>
                                </div>
                                <div>
                                    <center><input class="submit" type="submit" name="login" value="Sign In"></center>
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        </div>
</section>
<?php
	include $inc . 'footer.php'; 
	ob_end_flush();

?>