<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php echo $pageTitle?></title>
    <link rel="stylesheet" href="<?php echo $css?>style.css" />
    <link rel="stylesheet" href="<?php echo $css?>forms.css" />
    <link rel="stylesheet" href="<?php echo $css?>menu.css" />

    </head>
	<body>
	    <section>
            <header class="header">
                <nav class="nav">
                    <div class="logo-header">
                        <h1 style="font-size:30px">
                            <a href="/diet-restaurants/" style="color: #6b360e">Diet Restaurants</a>
                        </h1>
                    </div>
                    <section class="menu">
                        <ul class="left">
                            <li><a href='/diet-restaurants/'><span>Home</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showRestaurants" ?>'><span>Restaurants</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showMeals" ?>'><span>Meals</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showPackages" ?>'><span>Packages</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showCompare" ?>'><span>Restaurants Compare</span></a></li>
                        </ul>
                        <ul class="right">
                          <?php if(!isset($_SESSION['username'])) { ?>
                            <li><a href='<?php echo $cont."Controller.php?do=showUserLogin" ?>'><span>User</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showResLogin" ?>'><span>Restaurant</span></a></li>
                            <li><a href='<?php echo $cont."Controller.php?do=showAdminLogin" ?>'><span>Admin</span></a></li>
                            <?php } else { 
                              if(isset($_SESSION['type']) && $_SESSION['type'] == "restaurant") {
                            ?>
                              <li>
                                  <a href="<?php echo $cont."Controller.php?do=showResProfile" ?>"><?php echo $_SESSION['username']?></a>
                              </li>
                              <li>
                                <a href="<?php  echo $cont."Controller.php?do=ResLogout" ?>">Logout</a>
                              </li>
                            <?php  } elseif(isset($_SESSION['type']) && $_SESSION['type'] == "user") { ?>
                              <li>
                                  <a href="<?php echo $cont."Controller.php?do=showUserProfile" ?>"><?php echo $_SESSION['username']?></a>
                              </li>
                              <li>
                                <a href="<?php  echo $cont."Controller.php?do=userLogout" ?>">Logout</a>
                              </li>
                            <?php } elseif(isset($_SESSION['type']) && $_SESSION['type'] == "admin") { ?>
                              <li>
                                  <a href="<?php echo $cont."Controller.php?do=showAdminProfile" ?>"><?php echo $_SESSION['username']?></a>
                              </li>
                              <li>
                                <a href="<?php  echo $cont."Controller.php?do=adminLogout" ?>">Logout</a>
                              </li>
                            <?php }} ?>

                        </ul>
                    </section>
                    
                </nav>
            </header>