<div class="col-md-3">
    <div class="form-group">
        <label class="control-label">
            <?php echo $column_name; ?>
        </label>
        <?php
        if ($meta["type"] === "number"):
            ?>
            <input type="number" class="form-control" name="<?php echo $column_name; ?>" />
        <?php elseif ($meta["type"] == "select"):
            $options = getData($column);
            ?>
            <select class="select2 form-control" data-column="<?php echo $column ?>" id="<?php echo $column_id; ?>" name="<?php echo $column_id; ?>[]" multiple="multiple">
                <?php
                    require("_options.php");
                ?>
            </select>
        <?php endif; ?>

    </div>
</div>