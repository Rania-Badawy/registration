
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?= lang('Semester') ?></h2>
            </div>

            <div class="clearfix"></div>

            <form action="<?php echo site_url('/admin/Report_Register/updateSemestreConfig') ?>" method="post">

                <!-- Other form elements -->

              

                <!-- Dropdown -->
                <div id="Dropdowncom" class="form-group col-lg-6">
                    <label class="control-label col-lg-2"><?php echo lang('type') ?></label>
                    <div class="col-lg-10 ">
                        <select name="reg_type" id="reg_type" class="form-control selectpicker bs-select-hidden">
                        <option  id="nullSelect" disabled selected value=""><?php echo lang('ra_Choose_semester'); ?></option>
                        <option <? if($firstRow->semester == '1,2,3') {echo 'selected';}?> value="1,2,3"><?php echo lang('am_fullyear'); ?></option>
                        <option <? if($firstRow->semester == '2,3') {echo 'selected';}?> value="2,3"><?php echo lang('ra_First_second_semester'); ?></option>
                        <option <? if($firstRow->semester == 3) {echo 'selected';}?> value="3"><?php echo lang('Semester')." ".lang('er_third'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                 
                  <!-- Checkbox for Guardian's selection -->
                  <input <? if($firstRow->semester == NULL) {echo 'checked';}?> name="guardian_select" type="checkbox" id="guardian_select" onchange="toggleDropdown(this)">
                <label for="guardian_select"><?php echo lang('guardian_select'); ?></label>
                </div>
                <!-- Submit Button -->
                <div class="col-lg-2 text-right">
                    <input type="submit" class="btn btn-success" onclick="return check_type()" value="<?php echo lang('br_save') ?>" />
                </div>
            </form>



            <div class="clearfix"></div>



        </div>
    </div>
</div>

<script>

function toggleDropdown(checkboxElem) {
    var dropdown = document.getElementById("reg_type");
    var Dropdowncom = document.getElementById("Dropdowncom");

    if (checkboxElem.checked) {
        dropdown.value = '';
        Dropdowncom.style.display = 'none';
        } else {
            Dropdowncom.style.display = 'block';

    }
}
        var guardian_select = document.getElementById("guardian_select");

$(function() {
    toggleDropdown(guardian_select);
});
</script>