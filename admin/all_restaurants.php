<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "All Restaurants";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['restaurants']) {
        $restaurants =json_decode(base64_decode($_GET['restaurants']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>All Restaurants</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                               <div class= "list" >
                                    <div class="">
                                        <h4 style="width:40%">Restaurant Name</h4>
                                        <h4 style="width:30%">Owner Name</h4>
                                        <h4 style="width:20%">Phone</h4>
                                        <h4 style="width:10%">Rating</h4>
                                    </div>
                                    <?php foreach($restaurants as $res) { ?>
                                        <div class="">
                                            <h4 style="width:40%"><a href="<?php echo $cont.'Controller.php?do=showRestaurant&id='.$res['id'] ?>">
                                                    <?php echo $res['name'] ?></a>
                                            </h4>
                                            <h4 style="width:30%"><?php echo $res['owner_name']?></h4>
                                            <h4 style="width:20%"><?php echo $res['phone']?></h4>
                                            <h4 style="width:10%"><?php echo $res['count_rating']?></h4>

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

