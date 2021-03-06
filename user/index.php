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
                    <?php if(isset($_SESSION['msg'])) { ?>
                        <p style="color:black;background:#8bfa8b;padding:20px;margin:0">
                            <?php 
                                echo $_SESSION['msg'] ;
                                unset($_SESSION['msg']);
                            ?>
                        </p>
                    <?php } ?>
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>User Profile</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                                <div class= "profile">
                                    <div>
                                        <?php if($_SESSION['user']['photo']  == null) {?>
                                            <img src="<?php echo $uploads.'users/default.png'?>" alt="user photo" >
                                        <?php }else{ ?>
                                            <img src="<?php echo $uploads.'users/'.$_SESSION['user']['id'].'/'.$_SESSION['user']['photo'] ?>" alt="user photo">
                                        <?php }?>
                                    </div>
                                    <div class="">
                                        <h4><?php echo $_SESSION['username'] ?></h4>
                                    </div>
                                
                                    <div class="">
                                        <h4><?php echo $_SESSION['user']['email']?></h4>
                                    </div>
                                
                                    <div class="">
                                        <p><?php echo nl2br($_SESSION['user']['address'])?></p>
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

