<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Add Package";
    include($inc.'header.php');
    include($inc.'landing.php');
    if(isset($_GET['errors'])) {
		$errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
        $data = json_decode($_GET['data'],JSON_OBJECT_AS_ARRAY);
        $meals =json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);

        //$meals =json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);

	}
    if(isset($_GET['meals'])) {
        $meals =json_decode(base64_decode($_GET['meals']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
    
?>

    <section id="container">    
        <div id="main-content">
            <article class="background-gray">
                <div class="art-header">
                    <hr class="line-2">
                    <h2>Add Package</h2>
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
                            <form name="form1"  method="POST" action="<?php echo $cont."Controller.php?do=storePackage" ?>" enctype="multipart/form-data">
                                <div>
                                    <input type="text" name="name" id="name" placeholder="Enter Meal name" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['name']?>"/>
                                </div>
                                <div>
                                    <input type="number" name="calories" min="0.01" step="0.01" id="calories" placeholder="Enter Calories" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['calories']?>"/>
                                </div>
                                <div>
                                    <input type="number" name="price" min="0.1" step="0.1" id="price" placeholder="Enter price" required="required"
                                        value="<?php if(isset($_GET['errors'])) echo $data['price']?>"/>
                                </div>                                
                                <div>
                                    <input type="file" name="image" id="image" required>
                                </div>
                                <div>
                                    <select name="meals[]" id="meals" multiple required style="height: 200px;width:60%">
                                        <?php 
                                            if(isset($_GET['errors'])) {
                                                foreach($meals as $meal) {
                                                    $flag = true;
                                                    foreach($data['meals'] as $ms) {
                                                        if($meal['id'] == $ms) {
                                                            echo "<option value = '{$meal['id']}' selected>{$meal['name']}</option>" ;
                                                            $flag = false;
                                                            break;
                                                        }
                                                    }
                                                    if($flag) 
                                                        echo "<option value = '{$meal['id']}' >{$meal['name']}</option>" ;
                                                }
                                            } else {
                                                foreach($meals as $meal) {
                                                    echo "<option value = '{$meal['id']}' >{$meal['name']}</option>" ;
                                                }
                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                <div>
                                    <textarea name="details" id="details" class="form-control" rows="6" required="required"
                                            placeholder="Enter details"><?php if(isset($_GET['errors'])) echo $data['details']?></textarea>                                                    
                                </div>
                                <div>
                                    <center><input class="submit" type="submit" name="Add_Package" value="Add"></center>
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
