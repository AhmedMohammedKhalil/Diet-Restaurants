<section class="heading">
    <div class="logo">
        <hr class="line-1">
        <a href="#">Diet Restaurants</a>
        <span>Best Website For Choose Best Meal, Enjoy.</span>
        <hr class="line-1">
        <?php 
            if(isset($searching) && $searching == 'yes') {
                include($inc.'search.php');
            } 
        ?>
    </div>
</section>