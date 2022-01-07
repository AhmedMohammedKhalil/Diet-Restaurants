<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Subscribes";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['subscribes']) {
        $subscribes =json_decode(base64_decode($_GET['subscribes']),JSON_OBJECT_AS_ARRAY);
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>Subscribes</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                               <div class= "list" >
                                    <div class="">
                                        <h4 style="width:30%">Package Name</h4>
                                        <h4 style="width:30%">Restaurant Name</h4>
                                        <h4 style="width:20%">start</h4>
                                        <h4 style="width:20%">end</h4>
                                    </div>
                                    <?php foreach($subscribes as $subscribe) { ?>
                                        <div class="">
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showPackage&id={$subscribe['package_id']}" ?>">
                                                <?php echo $subscribe['pack_name'] ?></a>
                                            </h4>
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showRestaurant&id={$subscribe['res_id']}" ?>">
                                                <?php echo $subscribe['res_name']?></a>
                                            </h4>
                                            <h4 style="width:20%"><?php echo $subscribe['start']?></h4>
                                            <h4 style="width:20%"><?php echo $subscribe['end']?></h4>
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

