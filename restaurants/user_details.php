<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "User Details";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['user']) {
        $user =json_decode(base64_decode($_GET['user']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>User Details</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>

                            <aside style="width: 60%;">
                                <div class= "profile">
                                    <div>
                                        <?php if($user['photo']  == null) {?>
                                            <img src="<?php echo $uploads.'users/default.png'?>" alt="" >
                                        <?php }else{ ?>
                                            <img src="<?php echo $uploads.'users/'.$user['id'].'/'.$user['photo'] ?>" alt="">
                                        <?php }?>
                                    </div>
                                    <div class="">
                                        <h4><?php echo $user['name'] ?></h4>
                                    </div>
                                
                                    <div class="">
                                        <h4><?php echo $user['email']?></h4>
                                    </div>
                                
                                    <div class="">
                                        <p><?php echo nl2br($user['address'])?></p>
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

