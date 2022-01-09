<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Update Meal";
    include($inc.'header.php');
    include($inc.'landing.php');

    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
        $data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);

	}
    
    if(isset($_GET['meal'])) {
        $meal = json_decode(base64_decode($_GET['meal']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
    
    
    ?>

    <section id="container">    
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2>Update Meal</h2>
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
                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=updateMeal" ?>" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php if(isset($_GET['errors'])) {echo $data['id'];} else {echo $meal['id'];} ?>">
                                <div>
                                    <input type="text" name="name" id="name" placeholder="Enter Meal name" required="required"
                                        value="<?php if(isset($_GET['errors'])) {echo $data['name'];} else {echo $meal['name'];} ?>"/>
                                </div>
                                <div>
                                    <input type="number" name="calories" min="0.01" step="0.01" id="calories" placeholder="Enter Calories" required="required"
                                        value="<?php if(isset($_GET['errors'])) {echo $data['calories'] ;} else {echo $meal['calories'];}?>"/>
                                </div>
                                <div>
                                    <input type="number" name="price" min="0.1" step="0.1" id="price" placeholder="Enter price" required="required"
                                        value="<?php if(isset($_GET['errors'])) {echo $data['price'] ;} else {echo $meal['price'];}?>"/>
                                </div>                                  
                                <div>
                                    <input type="number" name="weight" min="0.01" step="0.01" id="weight" placeholder="Enter weight" required="required"
                                        value="<?php if(isset($_GET['errors'])) {echo $data['weight'] ;} else {echo $meal['weight'];}?>"/>
                                </div>
                                <div>
                                    <input type="file" name="image" id="image">
                                </div>
                                <div>
                                    <textarea name="details" id="details" class="form-control" rows="6" required="required"
                                            placeholder="Enter details"><?php if(isset($_GET['errors'])) {echo $data['details'] ;} else {echo $meal['details'];}?></textarea>                                                    
                                </div>
                                <div>
                                    <center><input class="submit" type="submit" name="update_Meal" value="Update"></center>
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

