
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?= lang('Preparing_year_register') ?></h2>
            </div>

            <div class="clearfix"></div>

            <form action="<?php echo site_url('/admin/Report_Register/updateYearConfig') ?>" method="post">
                
                <div id="Dropdowncom" class="form-group col-lg-6">
                    <label class="control-label col-lg-2"><?php echo lang('br_year') ?></label>
                    <div class="col-lg-10 ">
                        <select name="reg_year[]" id="reg_year" class="form-control selectpicker bs-select-hidden" multiple>
                        <option  id="nullSelect" disabled  value=""></option>
                        <?php

									foreach ($openedYear as $year) {

										$ID             = $year->YearId;

										$YearName       = $year->YearName;

								?>

											<option value="<?php echo $YearName; ?>" <?php if (in_array($YearName ,$reg_year)) {
																					echo "selected";
																				} ?>>
												<?php echo $YearName; ?></option>

								<?php } ?>
                
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-2 text-right">
                    <input type="submit" class="btn btn-success"  value="<?php echo lang('br_save') ?>" />
                </div>
            </form>

            <div class="clearfix"></div>

        </div>
    </div>
</div>

