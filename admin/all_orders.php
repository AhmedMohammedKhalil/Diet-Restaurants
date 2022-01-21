<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "All Orders";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['orders']) {
        $orders =json_decode(base64_decode($_GET['orders']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>All Orders</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>

                            <aside style="width: 60%;">
                                <div class= "list">
                                    <div class="">
                                        <h4 style="width:20%">User Name</h4>
                                        <h4 style="width:35%">Meal Name</h4>
                                        <h4 style="width:35%">Restaurant Name</h4>
                                        <h4 style="width:10%">Price</h4>
                                    </div>
                                    <?php foreach($orders as $order) { ?>
                                        <div class="">
                                            <h4 style="width:20%"><a href="<?php echo $cont."Controller.php?do=showUserDetails&id={$order['user_id']}" ?>">
                                                <?php echo $order['user_name'] ?></a>
                                            </h4>
                                            <h4 style="width:35%"><a href="<?php echo $cont."Controller.php?do=showMeal&id={$order['id']}" ?>">
                                                <?php echo $order['name'] ?></a>
                                            </h4>
                                            <h4 style="width:35%"><a href="<?php echo $cont."Controller.php?do=showRestaurant&id={$order['restaurant_id']}" ?>">
                                                <?php echo $order['res_name']?></a>
                                            </h4>
                                            <h4 style="width:10%"><?php echo $order['price']?> KD</h4>
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

