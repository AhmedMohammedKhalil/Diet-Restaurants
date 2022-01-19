<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Add Meal";
    include($inc.'header.php');
    include($inc.'landing.php');
    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
        $data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);

	}?>

    <section id="container">    
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2>Add Meal</h2>
                </div>
                <div class="art-content flex">
                    <?php include_once('sidebar.php') ?>
                    <aside style="width: 60%;">
                        <div class="form" style="width: 80%;">
                            <?php if(isset($errors)) {
                                echo '<ul style="width:50%;margin:0 auto">';
                                foreach($errors as $er) {
                                    echo "<li style='color:red;text-align:left'>$er</li>";
                                }
                                echo '</ul>';
                            }?>
                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=storeMeal" ?>" enctype="multipart/form-data">
                                <div>
                                    <label for="name">Name :</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Meal name" title="Enter Meal name" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['name']?>"/>
                                </div>
                                <div>
                                    <label for="calories">Calories :</label>
                                    <input type="number" name="calories" min="0.01" step="0.01" id="calories" placeholder="Enter Calories" title="Enter Calories" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['calories']?>"/>
                                </div>
                                <div>
                                    <label for="price">Price :</label>
                                    <input type="number" name="price" min="0.1" step="0.1" id="price" placeholder="Enter price" title="Enter price" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['price']?>"/>
                                </div>                                  
                                <div>
                                    <label for="weight">Weight :</label>
                                    <input type="number" name="weight" min="0.01" step="0.01" id="weight" placeholder="Enter weight" title="Enter weight" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['weight']?>"/>
                                </div>
                                <div>
                                    <label for="image">Image :</label>
                                    <input type="file" name="image" id="image" required>
                                </div>
                                <div>
                                    <label for="details">Details :</label>
                                    <textarea name="details" id="details" class="form-control" rows="6" required="required"
                                            placeholder="Enter details" title="Enter details"><?php if(isset($_GET['errors'])) echo $data['details']?></textarea>                                                    
                                </div>
                                <div>
                                    <center><input class="submit" type="submit" name="Add_Meal" value="Add"></center>
                                </div>
                            </form>
                        </div>
                    </aside>
                </div>
            </article>
        </div>
    </section>

<?php
    include($inc.'footer.php');
    ob_end_flush();

