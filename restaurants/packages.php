<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "Packages";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['packages']) {
        $packages =json_decode(base64_decode($_GET['packages']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }

?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>Packages</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>

                            <aside style="width: 60%;flex-direction:column;justify-content:start">
                                <div><a class="button" href="<?php echo $cont."Controller.php?do=createPackage" ?>">Add Package</a></div>

                                <div class= "list">
                                    <div class="">
                                        <h4 style="width:30%">Package Name</h4>
                                        <h4 style="width:20%">Calories</h4>
                                        <h4 style="width:20%">Price</h4>
                                        <h4 class="control">Control</h4>
                                    </div>
                                    <?php foreach($packages as $package) { ?>
                                        <div class="">
                                            <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=showPackage&id={$package['id']}" ?>">
                                                <?php echo $package['name'] ?></a>
                                            </h4>
                                            <h4 style="width:20%"><?php echo $package['calories']?> Calory</h4>
                                            <h4 style="width:20%"><?php echo $package['price']?> KD</h4>
                                            <div class= "control">
                                                <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=editPackage&id={$package['id']}" ?>">Edit</a></h4>
                                                <h4 style="width:30%"><a href="<?php echo $cont."Controller.php?do=delPackage&id={$package['id']}" ?>">Delete</a></h4>
                                            </div> 
                                        </div>
                                    <?php }?>
                          
                                </div>
                            </aside>
                                    
                        </div>
                    </article>
                </div>
            </section>

<?php
    include($inc.'footer.php');
    ob_end_flush();

