<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Packages";
    include($inc.'header.php');
    include($inc.'landing.php');
    $packages = json_decode(base64_decode($_GET['packages']),JSON_OBJECT_AS_ARRAY);
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
                                if($packages)
                                    echo '<h2>Monthly Packages Meals</h2>';
                                else 
                                    echo '<h2>Not Found Pakages</h2>';
                            ?>
                        </div>
                        <div class="art-content flex">
                            <?php if($packages) { ?>
                                <aside class="left" style="width: 30%;">
                                    <div class="">
                                        <div class="form filter" style="margin-top: 30px;">
                                                <div >
                                                    <h4 style="text-decoration: underline;">Filter for Packages</h4>
                                                </div>
                                                <?php if(isset($_GET['errors'])) {
                                                    $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
                                                    echo '<ul style="width:50%;margin:0 auto">';
                                                    foreach($errors as $er) {
                                                        echo "<li style='color:red;text-align:left'>$er</li>";
                                                    }
                                                    echo '</ul>';
                                                }?>
                                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=filterPackages" ?>">
                                                    <div class="searching">
                                                        <input type="search" name="search" id="search" placeholder="Make Search for Packages"
                                                            value="<?php if(isset($search)) { echo $search; }?>"/>
                                                    </div>
                                                <div>
                                                    <div >
                                                        <h5 style="text-align: left;">choose Range for Price</h5>
                                                    </div>
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="price[]" id="price1" value="1"
                                                                    <?php if(isset($price) && in_array('1',$price)) {echo 'checked';} ?>/>
                                                                <span>0 to 500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="price[]" id="price2" value="2"
                                                                    <?php if(isset($price) && in_array('2',$price)) {echo 'checked';} ?>/>

                                                                <span>500 to 1500</span>	
                                                            </label>	
                                                        </div>
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="price[]" id="price3" value="3"
                                                                    <?php if(isset($price) && in_array('3',$price)) {echo 'checked';} ?>/>

                                                                <span>1500 to 2500</span>	
                                                            </label>	
                                                        </div>
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="price[]" id="price4" value="4"
                                                                    <?php if(isset($price) && in_array('4',$price)) {echo 'checked';} ?>/>

                                                                <span>2500 to 3500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="price[]" id="price5" value="5"
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
                                                                <input type="checkbox" name="calories[]" id="calories1" value="1"
                                                                    <?php if(isset($calories) && in_array('1',$calories)) {echo 'checked';} ?>/>
                                                                <span>0 to 500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="calories[]" id="calories2" value="2"
                                                                    <?php if(isset($calories) && in_array('2',$calories)) {echo 'checked';} ?>/>

                                                                <span>500 to 1500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="calories[]" id="calories3" value="3"
                                                                    <?php if(isset($calories) && in_array('3',$calories)) {echo 'checked';} ?>/>

                                                                <span>1500 to 2500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="calories[]" id="calories4" value="4"
                                                                    <?php if(isset($calories) && in_array('4',$calories)) {echo 'checked';} ?>/>

                                                                <span>2500 to 3500</span>	
                                                            </label>	
                                                        </div>
                                                    
                                                        <div  style="text-align: left;">
                                                            <label class="flex">
                                                                <input type="checkbox" name="calories[]" id="calories5" value="5"
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
                                <aside style="width: 60%;">
                                    <?php foreach($packages as $package)  {
                                            echo '<div class="post" style="height:fit-content">';
                                                echo '<img src="'.$uploads.'packages/'.$package['id'].'/'.$package['photo'].'" alt="">';
                                                echo '<h3>'.$package['name'].'</h3>';
                                                echo '<h3>rating :'.$package['count_rating'].'</h3>';
                                                echo '<h3 style="margin: 10px 0;">'.$package['calories'].' Calories</h3>';
                                                echo '<h3 style="margin: 15px 0;">'.$package['price'].' KD</h3>';
                                                echo '<a class="button" href="'.$cont.'Controller.php?do=showPackage&id='.$package['id'].'">See All</a>';
                                            echo'</div>';
                                        }
                                    ?>
                                </aside>
                            <?php }?>       
                        </div>
                    </article>
                </div>
            </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();

