<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Profile";
    include($inc.'header.php');
    include($inc.'landing.php');
    //get all details about comp
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>Admin Profile</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                                <div class= "profile">
                                    <div class="">
                                        <h4><?php echo $_SESSION['username'] ?></h4>
                                    </div>
                                
                                    <div class="">
                                        <h4><?php echo $_SESSION['admin']['email']?></h4>
                                    </div>                            
                                </div>
                            </aside>
                                    
                        </div>
                    </article>
                </div>
            </section>

<?php
    include($inc.'footer.php');
    ob_end_flush();

