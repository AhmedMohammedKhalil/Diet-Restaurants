<aside class="left" style="width: 20%;border-right:3px solid black">
    <div class="menu" style="flex-direction: column;">
        <h2 style="padding-bottom: 20px;font-size:30px;border-bottom:3px solid black">Menu</h2>
        <ul style="padding-top: 10px;">
            <li><a href='<?php echo $cont."Controller.php?do=showAdminProfile" ?>'><span>Profile</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminRestaurants" ?>'><span>All Restaurants</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminUsers" ?>'><span>All Users</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminPackages" ?>'><span>All Packages</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminMeals" ?>'><span>All Meals</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminSubscribes" ?>'><span>All Subscribes</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminOrders" ?>'><span>All Orders</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminSettings" ?>'><span>Settings</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showAdminChangePassword" ?>'><span>Change Password</span></a></li>
            <li><a href='<?php  echo $cont."Controller.php?do=adminLogout" ?>'><span>Logout</span></a></li>
        </ul>
    </div>
</aside>