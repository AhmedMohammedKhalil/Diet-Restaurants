<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Meals";
    include($inc.'header.php');
    include($inc.'landing.php');
    $meals = json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);
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
                                        <form name="form1"  method="" action="">
                                                <div class="searching">
                                                    <input type="search" name="search" id="search" placeholder="Make Search for Meals"  />
                                                </div>
                                            <div>
                                                <div >
                                                    <h5 style="text-align: left;">choose Range for Price</h5>
                                                </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price1" value="1"/>
                                                            <span>0 to 500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price2" value="2"/>
                                                            <span>500 to 1500</span>	
                                                        </label>	
                                                    </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price3" value="3"/>
                                                            <span>1500 to 2500</span>	
                                                        </label>	
                                                    </div>
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price4" value="4"/>
                                                            <span>2500 to 3500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price5" value="5"/>
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
                                                            <input type="checkbox" name="price[]" id="price1" value="1"/>
                                                            <span>0 to 500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price2" value="2"/>
                                                            <span>500 to 1500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price3" value="3"/>
                                                            <span>1500 to 2500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price4" value="4"/>
                                                            <span>2500 to 3500</span>	
                                                        </label>	
                                                    </div>
                                                
                                                    <div  style="text-align: left;">
                                                        <label class="flex">
                                                            <input type="checkbox" name="price[]" id="price5" value="5"/>
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
                                                        <h3><?php echo $meal['price'] ?></h3>
                                                        <span>See More</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <img class="example-image" src="<?php echo $uploads.'meals/'.$meal['id'].'/'.$meal['photo']?>" alt=""/>
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

