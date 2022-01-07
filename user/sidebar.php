<aside class="left" style="width: 20%;border-right:3px solid black">
    <div class="menu" style="flex-direction: column;">
        <h2 style="padding-bottom: 20px;font-size:30px;border-bottom:3px solid black">Menu</h2>
        <ul style="padding-top: 10px;">
            <li><a href='<?php echo $cont."Controller.php?do=showUserProfile" ?>'><span>Profile</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showUserupdatePhoto" ?>'><span>Update Photo</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showUserSubscribes" ?>'><span>Subscribes</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showUserOrders" ?>'><span>Orders</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showUserSettings" ?>'><span>Settings</span></a></li>
            <li><a href='<?php echo $cont."Controller.php?do=showUserChangePassword" ?>'><span>Change Password</span></a></li>
            <li><a href='<?php  echo $cont."Controller.php?do=userLogout" ?>'><span>Logout</span></a></li>
        </ul>
    </div>
</aside>