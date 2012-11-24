<section class="title">
	<h4><?php echo lang('import:title_import_csv'); ?></h4>
</section>

<section class="item">

  <p><?php echo lang('import:misc_example_csv'); ?></p>

	<?php echo form_open(uri_string(), 'class="crud"');?>
      
    <div class="form_inputs">
      <fieldset>
        <ul>
          
          <li class="odd">
            <label>
              <?php echo lang('import:misc_csv_file'); ?> <span>*</span>
              <small><?php echo lang('import:misc_instructions_csv_file'); ?></small>
            </label>

            <div class="input dropdown">
              <?php echo form_dropdown('file_id', $files, $this->uri->segment(5)); ?>
            </div>
            <span class="move-handle"></span>
          </li>
                        
        </ul>
      </fieldset>
    </div>

    <div class="buttons">
      <button type="submit" name="btnAction" value="import" class="button red"><?php echo lang('import:button_next'); ?></button>
      <a href="<?php echo site_url('/admin/geonames_manager'); ?>" class="button"><?php echo lang('import:button_cancel'); ?></a>
    </div>

  <?php echo form_close(); ?>
</section>