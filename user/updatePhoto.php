<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Update photo";
    include($inc.'header.php');
    include($inc.'landing.php');
    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
	}
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>Update Photo</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                                <div class="form" style="width: 80%;">
                                    <?php if(isset($errors)) {
										echo '<ul style="width:50%;margin:0 auto">';
										foreach($errors as $er) {
											echo "<li style='color:red;text-align:left'>$er</li>";
										}
										echo '</ul>';
									}?>
									<form name="form1" method="POST" action="<?php echo $cont."Controller.php?do=userUpdatePhoto" ?>" enctype="multipart/form-data">
										<div>
											<input type="file" name="photo" id="photo" required="required" accept="image/jpg,image/jpeg,image/png"/>
										</div>
                                        <br>
                                        <br>
										<div>
											<center><input class="submit" type="submit" name="updatephoto" value="Save Changes"></center>
										</div>

									</form>
								</
                            </aside>
                                    
                        </div>
                    </article>
                </div>
            </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();

