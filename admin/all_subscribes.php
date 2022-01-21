<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "All Subscribes";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['subscribes']) {
        $subscribes =json_decode(base64_decode($_GET['subscribes']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>All Subscribes</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                               <div class= "list" >
                                    <div class="">
                                        <h4 style="width:20%">User Name</h4>
                                        <h4 style="width:35%">Package Name</h4>
                                        <h4 style="width:30%">Restaurant Name</h4>
                                        <h4 style="width:15%">end</h4>
                                    </div>
                                    <?php foreach($subscribes as $subscribe) { ?>
                                        <div class="">
                                            <h4 style="width:20%"><a href="<?php echo $cont."Controller.php?do=showUserDetails&id={$subscribe['user_id']}" ?>">
                                                    <?php echo $subscribe['user_name'] ?></a>
                                            </h4>
                                            <h4 style="width:35%"><a href="<?php echo $cont."Controller.php?do=showPackage&id={$subscribe['package_id']}" ?>">
                                                <?php echo $subscribe['pack_name'] ?></a>
                                            </h4>
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showRestaurant&id={$subscribe['res_id']}" ?>">
                                                <?php echo $subscribe['res_name']?></a>
                                            </h4>
                                            <h4 style="width:15%"><?php echo $subscribe['end']?></h4>
                                        </div>
                                    <?php }?>                             
                                </div>
                            </aside>
                                    
                        </div>
                    </article>
                </div>
            </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();

