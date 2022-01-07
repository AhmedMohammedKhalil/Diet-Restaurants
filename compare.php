<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Restaurants Compare";
    include($inc.'header.php');
    include($inc.'landing.php');
    $data = json_decode(base64_decode($_GET['data']),JSON_OBJECT_AS_ARRAY);
    extract($data);
    if(isset($_GET['errors'])) {
        $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
        $data = json_decode(base64_decode($_GET['data']),JSON_OBJECT_AS_ARRAY);
    }
    if(isset($_GET['compare'])) {

    }
?>
    
    <section id="container">
                <div id="main-content">
                    <div class="wrap-content">
                        <article class="background-white">
                            <?php if (count($restaurants) < 2) {
                                echo "<h3>Not Found Restaurants for Comparing</h3>";
                                exit();
                            }
                            ?> 
                            <div class="art-header">
                                <hr class="line-2">
                                <h2>Restaurants Compare</h2>

                            </div>
                            <div class="art-content">
                                <div class="form">
                                    <?php if(isset($errors)) {
										echo '<ul style="width:fit-content;margin:0 auto">';
										foreach($errors as $er) {
											echo "<li style='color:red;text-align:left'>$er</li>";
										}
										echo '</ul>';
									}?>
                                    <form name="form1"  method="POST" action="<?php echo $cont.'Controller.php?do=makeCompare' ?>">
                                        <div style="display: flex;justify-content:space-around;margin-bottom:20px">
                                            <div style="width: 40%;">
                                                <select name="res1" id="res1">
                                                    <?php foreach($restaurants as $r) {
                                                       echo "<option value='{$r['id']}'>{$r['name']}</option> " ;
                                                    } ?>
                                                </select>
                                            </div>
                                            <div style="width: 40%;">
                                                <select name="res2" id="res2">
                                                    <?php foreach($restaurants as $r) {
                                                       echo "<option value='{$r['id']}'>{$r['name']}</option> " ;
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <div>
                                                <center><input class="submit" type="submit" name="compare" value="Compare"></center>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php if(isset($_GET['compare'])) { ?>
                                <hr class="line-2">
                                <div style="display: flex;justify-content:space-around">
                                    <div class="post" style="width: 40%;">
                                        <img src="assets/images/res2.jpg" alt="">
                                        <h3>Restaurant Name</h3>
                                        <p>details</p>
                                        <a class="button" href="restaurant.html">See All</a>
                                    </div>
                                    <div class="post" style="width: 40%;">
                                        <img src="assets/images/res1.jpg" alt="">
                                        <h3>Restaurant Name</h3>
                                        <p>details</p>
                                        <a class="button" href="restaurant.html">See All</a>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
<?php
    include($inc.'footer.php');
    ob_end_flush();

