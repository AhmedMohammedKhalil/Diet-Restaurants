<?php
    ob_start();
    session_start();
    
    include('init.php');
    $pageTitle = "Meal Details";
    include($inc.'header.php');
    include($inc.'landing.php');

    $data = json_decode(base64_decode($_GET['data']),JSON_OBJECT_AS_ARRAY);
    extract($data);
    $meal = $meal[0];
    $restaurant = $restaurant[0];
?>
     <section id="container">
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2><?php echo $meal['name']?></h2>
                </div>
                <div class="art-content flex" style="flex-direction: column;">
                    <div style="width: 50%;margin:0 auto">
                        <div>
                            <img src="<?php echo $uploads.'meals/'.$meal['id'].'/'.$meal['photo'] ?>">
                        </div>
                        <div class="" style="text-align:left">
                            <div style="padding-top:10px">
                                <a href="<?php echo $cont.'Controller.php?do=showRestaurant&id='.$restaurant['id'] ?>" style="color:black">
                                    <h5><?php echo $restaurant['name'] ?></h5>
                                </a>
                            </div>
                            <div style="padding-top:10px">
                                <h5>rating : <?php echo $meal['count_rating']?></h5>
                            </div>
                            <div style="padding-top:10px">
                                <h5><?php echo $meal['calories']?> Calories</h5>
                            </div>
                            <div style="padding-top:10px">
                                <h5><?php echo $meal['price']?> KD</h5>
                            </div>
                            <div style="padding-top:10px">
                                <h5><?php echo $meal['weight']?> KG</h5>
                            </div>
                            <div style="padding-top:10px">
                                <p style="margin: 0;"><?php echo $meal['details']?></p>
                            </div>
                            <?php if(!isset($_SESSION['username'])) { ?>
                            <div style="padding-top:10px">
                                <p style="margin: 0;color:red">Please Sign in as user for make rate or order</p>
                            </div>
                            <?php } else { 
                                if(isset($_GET['errors'])) {
                                    $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
                                    echo '<ul style="width:50%;margin:0 auto">';
                                    foreach($errors as $er) {
                                        echo "<li style='color:red;text-align:left'>$er</li>";
                                    }
                                    echo '</ul>';
                                } ?>
                                <div style="padding-top:10px" class="rating">
                                    <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=rateMeal&id=".$meal['id'] ?>">
                                        <input type="number" name="rate" min="0.1" max="5" step="0.1" id="rate" placeholder="Enter Rate" required="required"/>
                                        <input class="submit" type="submit" name="Make_Rate" value="Make Rate" >
                                    </form>
                                </div>
                                <div style="padding-top:10px">
                                    <a href="#" class="button">Make Order</a>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();