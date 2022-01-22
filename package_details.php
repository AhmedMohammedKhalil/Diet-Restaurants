<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Package Details";
    include($inc.'header.php');
    include($inc.'landing.php');
    $data = json_decode(base64_decode($_GET['data']),JSON_OBJECT_AS_ARRAY);
    extract($data);
    $package = $package[0];
    $restaurant = $restaurant[0];
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
                    <h2><?php echo $package['name']?></h2>
                </div>
                <div class="art-content flex">
                    <div style="width: 50%;padding-right:20px">
                        <img src="<?php echo $uploads.'packages/'.$package['id'].'/'.$package['photo'] ?>">
                    </div>
                    <div class="" style="text-align:left;flex:1">
                        <div style="padding-top:10px">
                            <a href="<?php echo $cont.'Controller.php?do=showRestaurant&id='.$restaurant['id'] ?>" style="color:black">
                                <h5><?php echo $restaurant['name'] ?></h5>
                            </a>                        
                        </div>
                        <div style="padding-top:10px">
                                <h5>rating : <?php echo $package['count_rating']?></h5>
                        </div>
                        <div style="padding-top:10px">
                            <h5><?php echo $package['calories']?> Calories</h5>
                        </div>
                        <div style="padding-top:10px">
                            <h5><?php echo $package['price']?> KD</h5>
                        </div>
                        <div style="padding-top:10px">
                            <p style="margin: 0;"><?php echo nl2br($package['details'])?></p>
                        </div>
                        <?php if(!isset($_SESSION['username'])) { ?>
                        <div style="padding-top:10px">
                            <p style="margin: 0;color:red">Please Sign in as user for make rate or subscribe</p>
                        </div>
                        <?php } else if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') { ?> 
                            <div style="padding-top:10px" class="rating">
                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=ratePackage&id=".$package['id'] ?>">
                                    <input type="number" name="rate" min="0.1" max="5" step="0.1" id="rate" placeholder="Enter Rate" required="required"/>
                                    <input class="submit" type="submit" name="Make_Rate" value="Make Rate" >
                            </form>
                        </div>
                        <div style="padding-top:10px">
                            <a href="<?php echo $cont."Controller.php?do=makeSubscripe&id=".$package['id'] ?>" class="button">Subscribe</a>
                        </div>
                        <?php }?>
                        
                    </div>
                </div>
            </article>
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <?php 
                        if($meals)
                            echo '<h2>Our Meals</h2>';
                        else 
                            echo '<h2>Not Found Meals</h2>';
                    ?>
                </div>
                <div class="art-content flex">
                <?php foreach($meals as $meal)  { ?>

                    <div class="item-container">
                        <a class="example-image-link" href="<?php echo $cont.'Controller.php?do=showMeal&id='.$meal['id']?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                            <div class="item-caption">
                                <div class="item-caption-inner">
                                    <div class="item-caption-inner1">
                                        <h3><?php echo $meal['name'] ?></h3>
                                        <h3><?php echo $meal['price'] ?> KD</h3>
                                        <h3>rating : <?php echo $meal['count_rating'] ?></h3>
                                        <span>See More</span>
                                    </div>
                                </div>
                            </div>
                            <img class="example-image" src="<?php echo $uploads.'meals/'.$meal['id'].'/'.$meal['photo']?>" alt="package photo"/>
                        </a>
                    </div>
                <?php }?>
                </div>
            </article>
        </div>
    </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();