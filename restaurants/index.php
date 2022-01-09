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
                            <h2>Restaurant Profile</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                                <div class="art-content flex" style="flex-direction: column;">
                                    <div style="padding-right:20px">
                                        <?php if($_SESSION['restaurant']['photo']  == null) {?>
                                            <img src="<?php echo $uploads.'restaurants/res1.jpg'?>" alt="" >
                                        <?php }else{ ?>
                                            <img src="<?php echo $uploads.'restaurants/'.$_SESSION['restaurant']['id'].'/'.$_SESSION['restaurant']['photo'] ?>" alt="">
                                        <?php }?>
                                    </div>
                                    <div class="" style="text-align:left">
                                        <div style="padding-top:10px">
                                            <h5><?php echo $_SESSION['restaurant']['name']?></h5>
                                        </div>
                                        <div style="padding-top:10px">
                                            <h5><?php echo $_SESSION['restaurant']['owner_name']?></h5>
                                        </div>
                                        <div style="padding-top:10px">
                                            <h5><?php echo $_SESSION['restaurant']['count_rating']?></h5>
                                        </div>
                                        <div style="padding-top:10px">
                                            <h5><?php echo $_SESSION['restaurant']['phone']?></h5>
                                        </div>
                                        <div style="padding-top:10px">
                                            <p style="margin: 0;"><?php echo nl2br($_SESSION['restaurant']['address'])?></p>
                                        </div>
                                        <div style="padding-top:10px">
                                            <p style="margin: 0;"><?php echo nl2br($_SESSION['restaurant']['description'])?></p>
                                        </div>
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

