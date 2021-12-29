<?php
    ob_start();
    session_start();
    include('init.php');
    $pageTitle = "Restaurants Compare";
    include($inc.'header.php');
    include($inc.'landing.php');
    //get all details about comp
?>
    
<?php
    include($inc.'footer.php');
    ob_end_flush();

