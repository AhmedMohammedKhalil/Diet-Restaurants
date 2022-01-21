<?php
    ob_start();
    session_start();
    $valid = true;
    include('init.php');
    $pageTitle = "All Users";
    include($inc.'header.php');
    include($inc.'landing.php');
    if($_GET['users']) {
        $users =json_decode(base64_decode($_GET['users']),JSON_OBJECT_AS_ARRAY);
    } else {
        header('location: ../');
    }
?>
<section id="container">
                <div id="main-content">
                    <article class="background-gray">
                        <div class="art-header">
                            <hr class="line-2">
                            <h2>All Users</h2>
                        </div>
                        <div class="art-content flex">
                            <?php include_once('sidebar.php') ?>
                            <aside style="width: 60%;">
                               <div class= "list" >
                                    <div class="">
                                        <h4 style="width:30%">User Name</h4>
                                        <h4 style="width:30%">Email</h4>
                                        <h4 style="width:40%">address</h4>
                                    </div>
                                    <?php foreach($users as $user) { ?>
                                        <div class="">
                                            <h4 style="width:30%"><a href="<?php echo $cont.'Controller.php?do=showUserDetails&id='.$user['id'] ?>">
                                                    <?php echo $user['name'] ?></a>
                                            </h4>
                                            <h4 style="width:30%"><?php echo $user['email']?></h4>
                                            <h4 style="width:40%"><?php echo $user['address']?></h4>

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

