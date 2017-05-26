<?php
/**
 * @package Code Mirror
 * @author Iurii Makukh
 * @copyright Copyright (c) 2017, Iurii Makukh
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */
?>
<form method="post">
  <input type="hidden" name="token" value="<?php echo $_token; ?>">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="form-group">
        <div class="col-md-12">
          <label><?php echo $this->text('Syntax'); ?></label>
        </div>
      </div>
      <div class="form-group">
        <?php foreach ($modes as $columns) { ?>
        <div class="col-md-2">
          <?php foreach ($columns as $mode) { ?>
          <div class="checkbox">
            <label>
              <input name="settings[mode][]" value="<?php echo $this->escape($mode); ?>" type="checkbox"<?php echo in_array($mode, $settings['mode']) ? ' checked' : ''; ?>> <?php echo $this->escape($mode); ?>
            </label>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <div class="form-group col-md-4">
        <label><?php echo $this->text('Theme'); ?></label>
        <select name="settings[theme]" class="form-control">
          <?php foreach ($themes as $theme) { ?>
          <option value="<?php echo $this->escape($theme); ?>"<?php echo $settings['theme'] == $theme ? ' selected' : ''; ?>><?php echo $this->escape($theme); ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <a href="<?php echo $this->url("admin/module/list"); ?>" class="btn btn-default"><?php echo $this->text("Cancel"); ?></a>
          <button class="btn btn-default save" name="save" value="1"><?php echo $this->text("Save"); ?></button>
        </div>
      </div>
    </div>
  </div>
</form>