<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Settings";
    include($inc.'header.php');
    include($inc.'landing.php');
    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
		$data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);
	}

    //exit();
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>Settings</h2>
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
									<form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=editAdmin" ?>">
										<div>												
                                            <label for="name">Name :</label>
											<input type="text" name="name" id="name" placeholder="Enter name" title="Enter name" required="required"
                                                value="<?php if(isset($errors)) {echo $data['name']; } else { echo $_SESSION['username'];}?>"/>
										</div>
										<div>								
                                            <label for="email">Email :</label>
											<input type="email" name="email" id="email" placeholder="Enter email" title="Enter email" required="required"
                                                value="<?php if(isset($errors)) {echo $data['email']; } else { echo $_SESSION['admin']['email'];}?>"/>
										</div>
										<div>
											<center><input class="submit" type="submit" name="adminEdit" value="Save Changes"></center>
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

