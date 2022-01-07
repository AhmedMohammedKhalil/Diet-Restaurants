<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Change Password";
    include($inc.'header.php');
    include($inc.'landing.php');
    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
	}?>

    <section id="container">    
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2>Change Password</h2>
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
                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=UserchangePass" ?>">
                                <div>
                                    <input type="password" name="password" id="password" placeholder="Enter Password" required="required" />
                                </div>
                                <div>
                                    <input type="password" name="confirm_passowrd" id="co_password" placeholder="Enter password again" required="required" />
                                </div>
                                <div>
                                    <center><input class="submit" type="submit" name="change_pass" value="Change Password"></center>
                                </div>
                            </form>
                        </div>
                    </aside>
                </div>
            </article>
        </div>
    </section>

<?php
    include($inc.'footer.php');
    ob_end_flush();

