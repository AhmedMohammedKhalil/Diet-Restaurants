<?php
    ob_start();
    session_start();
    $searching = "yes";
    if(isset($_GET['search'])) {
        $search = $_GET['search'];
    }
    include('init.php');
    $pageTitle = "restaurants";
    include($inc.'header.php');
    include($inc.'landing.php');
    $restaurants = json_decode(base64_decode($_GET['restaurants']),JSON_OBJECT_AS_ARRAY);


?>
    <section id="container">
        <div id="main-content">
            <article class="background-gray ">
                <div class="art-header">
                    <hr class="line-2">
                    <?php 
                        if($restaurants)
                            echo '<h2>Our Restaurants</h2>';
                        else 
                            echo '<h2>Not Found Restaurants</h2>';
                    ?>
                </div>
                <div class="art-content flex restaurants">
                    <?php foreach($restaurants as $res)  {
                            echo '<div class="wrap-col post">';
                                if($res['photo'] != null)
                                    echo '<img src="'.$uploads.'restaurants/'.$res['id'].'/'.$res['photo'].'" alt="">';
                                else
                                    echo '<img src="'.$uploads.'restaurants/res1.jpg" alt="">';
                                echo '<h3>'.$res['name'].'</h3>';
                                echo '<h3>rating :'.$res['count_rating'].'</h3>';
                                echo '<h3 style="margin: 10px 0;">'.$res['owner_name'].'</h3>';
                                echo '<p style="margin: 15px 0;">'.nl2br($res['address']).'</p>';
                                echo '<a class="button" href="'.$cont.'Controller.php?do=showRestaurant&id='.$res['id'].'">See All</a>';
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

