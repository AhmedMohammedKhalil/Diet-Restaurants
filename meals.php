<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Meals";
    include($inc.'header.php');
    include($inc.'landing.php');
    $meals = json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);
    if(isset($_GET['filters'])) {
        $filters = json_decode($_GET['filters'],JSON_OBJECT_AS_ARRAY);
        extract($filters);
    }
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
                        <?php if($meals) { ?>

                            <aside class="left" style="width: 30%;">
                                <div class="">
                                    <div class="form filter" style="margin-top: 30px;">
                                            <div >
                                                <h4 style="text-decoration: underline;">Filter for Meals</h4>
                                            </div>
                                            <?php if(isset($_GET['errors'])) {
                                                $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
                                                echo '<ul style="width:50%;margin:0 auto">';
                                                foreach($errors as $er) {
                                                    echo "<li style='color:red;text-align:left'>$er</li>";
                                                }
                                                echo '</ul>';
                                            }?>
                                        <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=filterMeals" ?>">
                                                <div class="searching">
                                                    <label for="search">Search :</label>
                                                    <input type="search" name="search" id="search"  title="Make Search for Meals" placeholder="Search for Meals"
                                                        value="<?php if(isset($search)) { echo $search; }?>"/>
                                                </div>
                                            <div>
                                                <div >
                                                    <h5 style="text-align: left;">choose Range for Price</h5>
                                                </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price1"title="check price"  value="1"
                                                                <?php if(isset($price) && in_array('1',$price)) {echo 'checked';} ?>/>
                                                            <span>0 to 500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price2"title="check price"  value="2"
                                                                <?php if(isset($price) && in_array('2',$price)) {echo 'checked';} ?>/>

                                                            <span>500 to 1500</span>	
                                                        </label>	
                                                    </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price3"title="check price"  value="3"
                                                                <?php if(isset($price) && in_array('3',$price)) {echo 'checked';} ?>/>

                                                            <span>1500 to 2500</span>	
                                                        </label>	
                                                    </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price4" title="check price" value="4"
                                                                <?php if(isset($price) && in_array('4',$price)) {echo 'checked';} ?>/>

                                                            <span>2500 to 3500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price5" title="check price" value="5"
                                                                <?php if(isset($price) && in_array('5',$price)) {echo 'checked';} ?>/>

                                                            <span>3500 to up</span>	
                                                        </label>	
                                                    </div>
                                            </div>
                                            <div>
                                                <div >
                                                    <h5 style="text-align: left;">choose Range for Calory</h5>
                                                </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="calories[]" id="calories1"  title="check Calories"  value="1"
                                                                <?php if(isset($calories) && in_array('1',$calories)) {echo 'checked';} ?>/>
                                                            <span>0 to 500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="calories[]" id="calories2"  title="check Calories" value="2"
                                                                <?php if(isset($calories) && in_array('2',$calories)) {echo 'checked';} ?>/>

                                                            <span>500 to 1500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="calories[]" id="calories3" title="check Calories"  value="3"
                                                                <?php if(isset($calories) && in_array('3',$calories)) {echo 'checked';} ?>/>

                                                            <span>1500 to 2500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="calories[]" id="calories4" title="check Calories"  value="4"
                                                                <?php if(isset($calories) && in_array('4',$calories)) {echo 'checked';} ?>/>

                                                            <span>2500 to 3500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="calories[]" id="calories5" title="check Calories"  value="5"
                                                                <?php if(isset($calories) && in_array('5',$calories)) {echo 'checked';} ?>/>

                                                            <span>3500 to up</span>	
                                                        </label>	
                                                    </div>
                                               
                                            </div>
    
                                                <div >
                                                    <center><input class="submit" type="submit" name="Filter" value="Filter"></center>
                                                </div>
                                            
    
                                        </form>
                                    </div>
                                </div>
                            </aside>
                            <aside style="width:60%">
                                <?php foreach($meals as $meal)  { ?>
                                    <div class="item-container" style="height: fit-content;">
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
                                            <img class="example-image" src="<?php echo $uploads.'meals/'.$meal['id'].'/'.$meal['photo']?>" alt="meal photo"/>
                                        </a>
                                    </div>
                                <?php }?>
                            </aside>
                               <?php }?>     
                        </div>
                    </article>
                </div>
            </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();

