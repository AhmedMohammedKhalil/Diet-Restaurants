<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Restaurant Details";
    include($inc.'header.php');
    include($inc.'landing.php');
    $data = json_decode(base64_decode($_GET['data']),JSON_OBJECT_AS_ARRAY);
    extract($data);
    $restaurant = $restaurant[0];

    //extract($data);
?>
    <section id="container">
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2><?php echo $restaurant['name']?></h2>
                </div>
                <div class="art-content flex">
                    <div style="width: 50%;padding-right:20px">
                        <?php
                            if($restaurant['photo'] != null)
                                    echo '<img src="'.$uploads.'restaurants/'.$restaurant['id'].'/'.$restaurant['photo'].'" alt="">';
                                else
                                    echo '<img src="'.$uploads.'restaurants/res1.jpg" alt="">'; 
                        ?> 
                    </div>
                    <div class="" style="text-align:left;flex:1">
                        <div style="padding-top:10px">
                            <h5><?php echo $restaurant['owner_name']?></h5>
                        </div>
                        <div style="padding-top:10px">
                            <h5><?php echo $restaurant['phone']?></h5>
                        </div>
                        <div style="padding-top:10px">
                            <p style="margin: 0;"><?php echo $restaurant['address']?></p>
                        </div>
                        <div style="padding-top:10px">
                            <p style="margin: 0;"><?php echo $restaurant['description']?></p>
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
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <?php 
                        if($packages)
                            echo '<h2>Monthly Packages Meals</h2>';
                        else 
                            echo '<h2>Not Found Pakages</h2>';
                    ?>
                </div>

                <div class="art-content flex">
                    <?php foreach($packages as $package)  {
                            echo '<div class="post">';
                                echo '<img src="'.$uploads.'packages/'.$package['id'].'/'.$package['photo'].'" alt="">';
                                echo '<h3>'.$package['name'].'</h3>';
                                echo '<h3 style="margin: 10px 0;">'.$package['calories'].'</h3>';
                                echo '<h3 style="margin: 15px 0;">'.$package['price'].'</h3>';
                                echo '<a class="button" href="'.$cont.'Controller.php?do=showPackage&id='.$package['id'].'">See All</a>';
                            echo'</div>';
                        }
                    ?>
                </div>
            </article>
        </div>
    </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();