<?php
foreach ($options as $option): 
    ?>
    <option class="select_option" value="<?php echo $option;?>">
        <?php echo $option; ?>
    </option>
<?php endforeach; ?>