<div class="clearfix"></div>

  <div class="content margin-top-none container-page">  

       <div class="col-lg-12">

 <div class="block-st">

 <div class="sec-title">

      <h2>  <?php echo lang( 'Add_Exam'); ?></h2>
</div>
 <div class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('class_type'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('class_type'); ?>"  class="selectpicker form-control" tabindex="18" name="ClassTypeName[]" id="ClassTypeName" multiple required>
                <option value="0"><?php echo lang('am_choose_select'); ?></option>
                <?php
                    if($ClassType)
                    {
                       foreach($ClassType as $Key=>$gender)
                        {
                            $ID = $gender->ClassTypeId ;
                            $Name  = $gender->ClassTypeName ;
                ?>
                 <option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
                <?php }} ?>
          </select>     
     </div>
    </div>
    
   <div class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('am_studeType'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('am_studeType'); ?>"  class="selectpicker form-control" tabindex="18" name="studeType[]" id="studeType" multiple required>
                <option value="0"><?php echo lang('am_choose_select'); ?></option>
                <?php
                    if($studeType)
                    {
                       foreach($studeType as $Key=>$val)
                        {
                            $ID    = $val->StudyTypeId ;
                            $Name  = $val->StudyTypeName ;
                ?>
                 <option value="<?php echo $ID ; ?>"><?php echo $Name ; ?></option>
                <?php }} ?>
          </select>     
     </div>
    </div>
    
     <div class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('br_school_name'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('br_school_name'); ?>"  class=" form-control" tabindex="18" name="schoolID" id="schoolID" required>
                <option value="" selected><?php echo lang('am_choose_select'); ?></option>
          </select>     
     </div>
    </div>
    
     <div class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('am_level'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('am_level'); ?>"  class=" form-control" tabindex="18" name="levelID" id="levelID"  required>
               <option value="" selected><?php echo lang('am_choose_select'); ?></option>
          </select>     
     </div>
    </div>
    
     <div class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('br_row_level'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('br_row_level'); ?>"  class=" form-control" tabindex="18" name="rowID" id="rowID" required >
                <option value="" selected><?php echo lang('am_choose_select'); ?></option>
          </select>     
     </div>
    </div>
    
     <div  id="show_status" class="form-group col-lg-5">
      <label class="control-label col-lg-3"><?php echo lang('status'); ?></label>
     <div class="col-lg-9">
       <select data-placeholder="<?php echo lang('status'); ?>"  class="selectpicker form-control" tabindex="18" name="status" id="status"  multiple required>
             <option value="" selected><?php echo lang('am_choose_select'); ?></option>
          </select>     
     </div>
    </div>
    
<input type="hidden" name="FeeStatus" id="FeeStatus" value="">  
<input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">


 <div class="col-lg-2">                     
   <input type="button" class="btn btn-success" onclick="return show_exam();" value="<?php echo lang('br_show') ?>" >

</div>

<script>

    function show_exam()
    {
        var row_level               = $("#row_level").val();
        var Subject                 = $("#Subject").val();
        if(row_level.length > 0 && Subject.length > 0)
        {
           window.open("<?= site_url('emp/exam_new/index') ?>/"+row_level+"/"+"4", '_blank');
        }
    }
</script>
// <script>
//     $('select[name^="studeType"]').on('change', function() {
//         document.getElementById("show_status").style.display = "none";
//         var studeType = $('#studeType').val();
//         var DbName = $('#DbName').val();
//         if (studeType) {
//             $.ajax({
//                 url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName + '/GetSchoolsByStudyType',
//                 type: "GET",
//                 data: {
//                     studyTypeId: studeType
//                 },
//                 dataType: "json",
//                 success: function(data) {
//                     var element = $('#schoolID');
//                     element.empty();
//                     element.append(
//                         '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
//                     $.each(data, function(key, value) {
//                         element.append('<option value="' + value.SchoolId + '">' + value.SchoolName + '</option>');
                           
//                     });
//                 }
//             });

//         } else {
//             var element = $('#schoolID');
//             element.empty();
//             element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
//         }
        
//     });

// </script>

<script type="text/javascript">
    $('select[name^="schoolID"]').on('change', function() {
        var studeType = $('#studeType').val();
        var schoolID = $('#schoolID').val();
        var ClassTypeName = $('#ClassTypeName').val();
        var DbName = $('#DbName').val();
        if (schoolID && studeType != "") {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetLevelsBySchool',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#levelID');
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.LevelId + '">' + value
                            .LevelName + '</option>');

                    });
                }
            });
        } else {
            var element = $('#levelID');
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>

<script type="text/javascript">
    $('select[name^="levelID"]').on('change', function() {
        var levelID = $(this).val();
        var schoolID = $('#schoolID').val();
        var studeType = $('#studeType').val();
        var ClassTypeName = $('#ClassTypeName').val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetRowsByLevel',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#rowID');
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {

                        element.append('<option value="' + value.RowId + '">' + value.RowName +
                            '</option>');
                        $('#FeeStatus').val(value.IsSpecialEdu);
                        if (value.IsSpecialEdu == 1) {
                            document.getElementById("show_status").style.display = "block";
                        } else {
                            document.getElementById("show_status").style.display = "none";
                        }
                    });

                }
            });
        } else {
            var element = $('#rowID');
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>
<script type="text/javascript">
    $('select[name^="rowID"]').on('change', function() {
        var rowId = $(this).val();
        var schoolID = $('#schoolID').val();
        var studeType = $('#studeType').val();
        var ClassTypeName = $('#ClassTypeName').val();
        var levelID = $('#levelID').val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID && rowId) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetFeeStatus',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    rowId: rowId,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#status');
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.StatusId + '">' + value
                            .StatusName + '</option>');
                    });
                }
            });
        } else {
            var element = $('#status');
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>    


</div>

<div class="clearfix"></div>    

</div>

<div class="clearfix"></div>

</div>


