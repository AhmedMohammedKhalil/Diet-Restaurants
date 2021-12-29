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
                            </a>                        </div>
                        <div style="padding-top:10px">
                            <h5><?php echo $package['calories']?></h5>
                        </div>
                        <div style="padding-top:10px">
                            <h5><?php echo $package['price']?></h5>
                        </div>
                        <div style="padding-top:10px">
                            <p style="margin: 0;"><?php echo $package['details']?></p>
                        </div>
                        <div style="padding-top:10px">
                            <a href="#" class="button">Subscribe</a>
                        </div>
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
                                        <h3><?php echo $meal['price'] ?></h3>
                                        <span>See More</span>
                                    </div>
                                </div>
                            </div>
                            <img class="example-image" src="<?php echo $uploads.'meals/'.$meal['id'].'/'.$meal['photo']?>" alt=""/>
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