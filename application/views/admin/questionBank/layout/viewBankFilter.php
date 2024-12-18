<div class="block-st">
    <div class="sec-title">
        <h2>
            <?php echo lang('question_bank'); ?>
        </h2>
        <span class="pull-left">
            <a class="btn btn-success pull-left" href="<?= site_url('admin/question_bank/question_form') ?>">
                <?= lang('add_question_bank'); ?>
            </a>
        </span>
    </div>
    <div class="clearfix"></div>


    <?php
    if ($this->session->flashdata('SuccessAdd')) {
        echo '<div class="alert alert-success">' . $this->session->flashdata('SuccessAdd') . '</div>';
    }
    if ($this->session->flashdata('ErrorAdd')) {
        echo '<div class="alert alert-error">' . $this->session->flashdata('ErrorAdd') . '</div>';
    }
    ?>
    <form action="<?php echo site_url('admin/question_bank/index') ?>" method="post">
        <input type="hidden" name="apikey" id="apikey" value="<?php echo $apikey; ?>" />
        <input type="hidden" name="curr_school" id="curr_school" value="<?php echo $curr_school; ?>" />
        <div class="row" dir="auto">
            <div class="form-group col-lg-5">

                <label class="control-label col-lg-3">
                    <?php echo lang('br_year'); ?><span class="danger" style="color: red;">*</span>
                </label>

                <div class="col-lg-9">

                    <select data-placeholder="<?php echo lang('br_year'); ?>" class="selectpicker form-control"
                        data-live-search="true" tabindex="18" name="year_id" id="year_id" required>

                        <option value="">
                            <?php echo lang('am_select'); ?>
                        </option>
                        <?php

                        foreach ($get_year as $Key => $ye) {

                            $yearID = $ye->ID;

                            $yearName = $ye->year_name;


                            ?>

                            <option value="<?php echo $yearID; ?>" <?php if ($yearID == $year_id) {
                                   echo 'selected';
                               } ?>> <?php echo $yearName; ?>
                            </option>

                            <?php

                        }

                        ?>

                    </select>

                </div>

            </div>

            <div class="form-group col-lg-5">

                <label class="control-label col-lg-3">
                    <?php echo lang('Semester'); ?>
                </label>

                <div class="col-lg-9">

                    <select data-placeholder="<?php echo lang('Semester'); ?>"
                        class="selectpicker form-control selectGroup bs-select-hidden" data-live-search="true"
                        tabindex="18" name="Semesterid" id="Semesterid">

                        <option value="0" style="display:none">
                            <?php echo lang('am_select'); ?>
                        </option>
                        <?php

                        foreach ($Semester as $Key => $sem) {

                            $ID = $sem->ID;

                            $Name = $sem->Name;

                            ?>

                            <option value="<?php echo $ID; ?>" <?php if ($Semesterid == $ID) {
                                   echo 'selected';
                               } ?>> <?php echo $Name; ?>
                            </option>

                            <?php

                        }

                        ?>

                    </select>

                </div>


            </div>

            <div class="form-group col-lg-5">

                <label class="control-label col-lg-3">
                    <?php echo lang('am_row'); ?>
                </label>

                <div class="col-lg-9">

                    <select data-placeholder="<?php echo lang('am_row'); ?>"
                        class="selectpicker form-control bs-select-hidden" data-live-search="true" tabindex="18"
                        name="gradeID" id="gradeID">

                        <option value="0">
                            <?php echo lang('am_select'); ?>
                        </option>
                        <?php

                        foreach ($grades['data'] as $Key => $lev) {

                            $id = $lev['id'];

                            if ($Lang == "arabic") {

                                $levelName = $lev['level']['name_ar'];
                                $gradeName = $lev['name_ar'];
                            } else {

                                $levelName = $lev['level']['name_en'];
                                $gradeName = $lev['name_en'];
                            }
                            if (in_array($id, $rowLevelPer))
                            {
                            ?>

                            <option value="<?php echo $id ;?>" <?php if ($id == $gradeID) {
                                      echo 'selected';
                                  } ?>> <?php echo $levelName . "-" . $gradeName; ?>
                            </option>

                            <?php

                        }}
                        ?>

                    </select>

                </div>


            </div>

            <div class="form-group col-lg-5">

                <label class="control-label col-lg-3">
                    <?php echo lang('am_subject'); ?>
                </label>

                <div class="col-lg-9">
                    <!-- <? foreach ($bankDataArray as $a) { ?>

                    <h1><? echo $bankDataArray['name_ar'] ?> <h1>

                        <? } ?> -->

                    <select data-placeholder="<?php echo lang('am_subject'); ?>"
                        class="selectpicker form-control bs-select-hidden" data-live-search="true" tabindex="18"
                        name="subjectID" id="subjectID">

                        <option value="0">
                            <?php echo lang('am_choose_all'); ?>
                        </option>
                        <?php

                        foreach ($getSubject['data'] as $Key => $lev) {

                            $SubjectID = $lev['SubjectID'];

                            if ($Lang == "arabic") {

                                $subjectName = $lev['Name'];
                            } else {

                                $subjectName = $lev['Name_en'];
                            }
                            ?>

                            <option value="<?php echo $SubjectID; ?>" <?php if ($SubjectID == $subjectID) {
                                   echo 'selected';
                               } ?>> <?php echo $subjectName; ?>
                            </option>

                            <?php

                        }

                        ?>
                    </select>

                </div>


            </div>

            <div class="col-md-1">
                <input type="submit" class="btn-success" value="<?php echo lang('am_view'); ?>"
                    onClick="return check_Request_add();" style="padding: 10px 15px !important" />

            </div>
        </div>
</div>

<script>
    $('select[name^="gradeID"]').on('change', function () {
        var apikey = $('#apikey').val();
        var SchoolID = $('#curr_school').val();
        var gradeID = $('#gradeID').val();
        var levelGrade = gradeID.split('|');
        var level = levelGrade[0];
        var grade = levelGrade[1];
        // var grade = $('#gradeID').val();myStr.split(" ");

        if (apikey) {
            $.ajax({

                url: '<?php echo site_url(); ?>' + '/admin/question_bank/getSubjects/' + SchoolID + "/" + level + "/" + grade,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var element = $('#subjectID');
                    element.empty();
                    element.append(
                        '<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data['data'], function (key, value) {
                        element.append('<option value="' + value.SubjectID + '">' + value.Name + '</option>');
                    });
                    $('.selectpicker').selectpicker('refresh');
                }
            });

        }
    });
</script>