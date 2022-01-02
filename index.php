<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Home";
    include($inc.'header.php');
    include($inc.'landing.php');
    include_once('controllers/HomeController.php');
    $data = HomeController::index();
    extract($data);
  
    //get all details about home
?>
    <section id="container">
                <div id="main-content">
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
                                                <h3><?php echo $meal['price'] ?> KD</h3>
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
                                        echo '<h3 style="margin: 10px 0;">'.$package['calories'].' Calories</h3>';
                                        echo '<h3 style="margin: 15px 0;">'.$package['price'].' KD</h3>';
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

