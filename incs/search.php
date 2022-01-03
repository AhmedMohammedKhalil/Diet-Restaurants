<section id="container">
    <div id="main-content">
        <div class="art-content">
                <div class="form search">
                    <?php if(isset($_GET['errors'])) {
                        $errors = json_decode($_GET['errors'],JSON_OBJECT_AS_ARRAY);
                        echo '<ul style="width:50%;margin:0 auto">';
                        foreach($errors as $er) {
                            echo "<li style='color:red;text-align:left'>$er</li>";
                        }
                        echo '</ul>';
                    }?>
                    <form name="form1"   method="POST" action="<?php echo $cont."Controller.php?do=searchRes" ?>">
                        <div class="flex">
                            <div style="width: 100%;">
                                <input type="search" name="searchRes" id="search" placeholder="Search about restaurants" required="required" style="width: 100%; margin:0"
                                    value="<?php if(isset($search)) echo $search ?>"/>
                            </div>
                            <div style="width:40%">
                                <center><input class="submit" type="submit" name="search" value="Search" style="width:100%"></center>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</section>
<hr class="line-1">