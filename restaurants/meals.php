<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Meals";
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
                            <h2>Meals</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>

                            <aside style="width: 60%;flex-direction:column;justify-content:start">
                                <div><a class="button" href="<?php echo $cont."Controller.php?do=createMeal" ?>">Add Meal</a></div>

                                <div class= "list">
                                    <div class="">
                                        <h4 style="width:30%">Meal Name</h4>
                                        <h4 style="width:20%">Calories</h4>
                                        <h4 style="width:20%">Price</h4>
                                        <h4 class="control">Control</h4>
                                    </div>
                                    <?php foreach($meals as $meal) { ?>
                                        <div class="">
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showMeal&id={$meal['id']}" ?>">
                                                <?php echo $meal['name'] ?></a>
                                            </h4>
                                            <h4 style="width:20%"><?php echo $meal['calories']?> Calory</h4>
                                            <h4 style="width:20%"><?php echo $meal['price']?> KD</h4>
                                            <div class= "control">
                                                <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=editMeal&id={$meal['id']}" ?>">Edit</a></h4>
                                                <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=delMeal&id={$meal['id']}" ?>">Delete</a></h4>
                                            </div> 
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

