<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "All Meals";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['meals']) {
        $meals =json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>All Meals</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>

                            <aside style="width: 60%;flex-direction:column;justify-content:start">
                                <div class= "list">
                                    <div class="">
                                        <h4 style="width:30%">Meal Name</h4>
                                        <h4 style="width:30%">Restaurnat Name</h4>
                                        <h4 style="width:20%">Rating</h4>
                                        <h4 style="width:20%">Price</h4>
                                    </div>
                                    <?php foreach($meals as $meal) { ?>
                                        <div class="">
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showMeal&id={$meal['id']}" ?>">
                                                <?php echo $meal['name'] ?></a>
                                            </h4>
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showRestaurant&id={$meal['restaurant_id']}" ?>">
                                                <?php echo $meal['res_name'] ?></a>
                                            </h4>
                                            <h4 style="width:20%"><?php echo $meal['count_rating']?></h4>
                                            <h4 style="width:20%"><?php echo $meal['price']?> KD</h4>
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

