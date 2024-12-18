<?php 
		$get_api_setting = $this->setting_model->get_api_setting();

		$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
		?>
<style>
.panel-group .panel+.panel {
    margin-top: 0 !important;
}
</style>
<div class="col-md-12 p-0" id="addStudentValue<?=$addStudentValue?>">
    <?php if (isset($addStudentValue)) { ?>
    <hr>

    <?php }
    else {
        $addStudentValue = 0;
    } ?>
    <?php $setting = $this->db->query("SELECT * FROM `form_setting` where form_type=1")->result(); ?>

    <?php $psychological = $this->db->query("SELECT * FROM `form_setting` where  type = 'ph' AND form_type = 1 AND display=1")->result();
                if(!empty($psychological)){
    ?>
    <div class="col-xs-12 title_register">
        <h5 style="margin: 10px 0 30px;"><i class="fa fa-user" aria-hidden="true"></i><?=lang('am_student_psyy')?> <span
                id="std<?=$addStudentValue?>" class="danger"></span></h5>
    </div>
    <?php } ?>
    <div class="row">
        <div class="">
            <div class="panel-group" id="" role="tablist" aria-multiselectable="true">
                <!--<div class="panel panel-default panel_regist_all">-->
                <!--    <div class="panel-heading panel-regist" role="tab" id="heading1<?=$addStudentValue?>">-->
                <!--        <h4 class="panel-title">-->
                <!--            <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>" href="#collapse1<?=$addStudentValue?>" aria-expanded="true" aria-controls="collapse1<?=$addStudentValue?>">-->
                <!--                <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>-->
                <!--                <?=lang('am_student_religion')?>-->
                <!--            </a>-->
                <!--        </h4>-->
                <!--    </div>-->
                <!--    <div id="collapse1<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1<?=$addStudentValue?>">-->
                <!--        <div class="panel-body p-0">-->
                <!--            <input type="text" class="form-control collaps-input" name="religion[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"  >-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="row">
                    <?php if($setting[72]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading2<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse2<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse2<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_brothers')?>
                                    <?php if($setting[72]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse2<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading2<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" name="brothers_num[<?=$addStudentValue?>]"
                                     class="form-control collaps-input arabicNumbers"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[72]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[73]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading3<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse3<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse3<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_order')?>
                                    <?php if($setting[73]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse3<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading3<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" name="student_order[<?=$addStudentValue?>]"
                                     class="form-control collaps-input arabicNumbers"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[73]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[74]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading4<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse4<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse4<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_live_with')?><?php if($setting[74]->required == 1){echo '<span class="danger">*</span>';}?>:
                                </a>
                            </h4>
                        </div>
                        <div id="collapse4<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading4<?=$addStudentValue?>">
                            <div class="panel-body p-0" style="padding: 10px 15px;">
                                <input type="radio" name="live_with[<?=$addStudentValue?>]" value="1"
                                    style="width:auto;" <?php if($setting[74]->required == 1){echo required;}?>>
                                <?=lang('am_student_live_parents')?>
                                <input type="radio" name="live_with[<?=$addStudentValue?>]" value="2"
                                    style="width:auto;"> <?=lang('am_student_live_father')?>
                                <input type="radio" name="live_with[<?=$addStudentValue?>]" value="3"
                                    style="width:auto;"> <?=lang('am_student_live_mother')?>
                                <input type="radio" name="live_with[<?=$addStudentValue?>]" value="4"
                                    style="width:auto;"> <?=lang('am_student_live_other')?>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[75]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading5<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse5<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse5<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_social')?><?php if($setting[75]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse5<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading5<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <select id="social_parents" name="social_parents[<?=$addStudentValue?>]"
                                    class="form-control collaps-input valid" aria-invalid="false"
                                    <?php if($setting[75]->required == 1){echo required;}?>>
                                    <option value=""><?=lang('am_select')?></option>
                                    <option value="1"><?=lang('am_married');?></option>
                                    <option value="2"><?=lang('am_devorce');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[76]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading6<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse6<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse6<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_grand_parents')?><?php if($setting[76]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse6<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading6<?=$addStudentValue?>">
                            <div class="panel-body p-0" style="padding: 10px 15px;">
                                <input type="radio" id="check_val1" name="check_val" value="1" style="width:auto;" <?php if($setting[76]->required == 1){echo required ;}?>>
                                <?=lang('Yes')?>
                                <input type="radio" id="check_valn1" name="check_val" value="2" style="width:auto;">
                                <?=lang('NO')?>
                                <!--<?php //if(isset($_POST['yes'])) { ?>-->
                                <div id="show">
                                    <input type="checkbox" name="grand_parents[<?=$addStudentValue?>][]" value="1"
                                        style="width:auto;" <?php if($setting[76]->required == 1){echo required;}?>>
                                    <?=lang("Grandparents from the father's side")?>
                                    <input type="checkbox" name="grand_parents[<?=$addStudentValue?>][]" value="2"
                                        style="width:auto;"> <?=lang("Grandparents from the mother's side")?>
                                    <!--<?php //} ?>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[77]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading7<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse7<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse7<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_skills')?><?php if($setting[77]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse7<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading7<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_skills[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[77]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[78]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading8<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse8<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse8<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_games')?><?php if($setting[78]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val2" name="check_game" value="1" style="width:auto;" <?php if($setting[78]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn2" name="check_game" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="x">
                            <div id="collapse8<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading8<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_games[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[78]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[79]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading9<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse9<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse9<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_sport')?><?php if($setting[79]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse9<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading9<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_sport[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[79]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[80]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading10<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse10<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse10<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_place')?><?php if($setting[80]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse10<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading10<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_place[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[80]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[81]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading11<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse11<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse11<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_relation')?><?php if($setting[81]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse11<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading11<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_relation[<?=$addStudentValue?>]"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[81]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[82]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading12<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1<?=$addStudentValue?>"
                                    href="#collapse12<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse12<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_descripe')?><?php if($setting[82]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse12<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading12<?=$addStudentValue?>" style="margin-bottom: -3px">
                            <div class="panel-body p-0">
                                <select style="margin-top: 10px;" class="form-control collaps-input"
                                    name="student_descripe[<?=$addStudentValue?>]"
                                    <?php if($setting[82]->required == 1){echo required;}?>>
                                    <option value=""><?=lang('am_select')?></option>
                                    <option value="1"><?=lang('am_student_descripe1')?></option>
                                    <option value="2"><?=lang('am_student_descripe2')?></option>
                                    <option value="3"><?=lang('am_student_descripe3')?></option>
                                    <option value="4"><?=lang('am_student_descripe4')?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[83]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading13<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse13<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse13<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_behavior')?><?php if($setting[83]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val3" name="check_behavior" value="1" style="width:auto;" <?php if($setting[83]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn3" name="check_behavior" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show3">
                            <div id="collapse13<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading13<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_behavior[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[83]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if($setting[84]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading14<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse14<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse14<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_get_rid')?><?php if($setting[84]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse14<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading14<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_get_rid[<?=$addStudentValue?>]"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[84]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[85]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading15<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse15<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse15<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_pressure')?><?php if($setting[85]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse15<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading15<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_pressure[<?=$addStudentValue?>]"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[85]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if($setting[86]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_person')?><?php if($setting[86]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_person[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[86]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[87]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_punish')?><?php if($setting[87]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_punish[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[87]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[88]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading18<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse18<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse18<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_specialist')?><?php if($setting[88]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val4" name="check_specialist" value="1" style="width:auto;" <?php if($setting[88]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn4" name="check_specialist" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show4">
                            <div id="collapse18<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading18<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_specialist[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[88]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[89]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading23<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse23<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse23<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_academy')?><?php if($setting[89]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse23<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading23<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="student_academy[<?=$addStudentValue?>]"
                                    placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[89]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if($setting[99]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_color')?><?php if($setting[99]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_color[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[99]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[100]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_game')?><?php if($setting[100]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_game[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[100]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[101]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_type_toy')?><?php if($setting[101]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_type_toy[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[101]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[102]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_animal')?><?php if($setting[102]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_animal[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[102]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[103]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_nickname')?><?php if($setting[103]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_nickname[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[103]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[104]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_favorite_food')?><?php if($setting[104]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_favorite_food[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[104]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[105]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_things_scare_child')?><?php if($setting[105]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="things_scare_child[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[105]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[106]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_additional_information')?><?php if($setting[106]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="additional_information[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[106]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[107]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_enter_bathroom')?><?php if($setting[107]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="enter_bathroom[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[107]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[108]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_method_enter_bathroom')?><?php if($setting[108]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="method_enter_bathroom[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[108]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                
                <div class="row">
                    <?php if($setting[109]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_time_electronic_devices')?><?php if($setting[109]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="time_electronic_devices[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[109]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[110]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_hobbies')?><?php if($setting[110]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_hobbies[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[110]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[111]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_activities_programs')?><?php if($setting[111]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="activities_programs[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[111]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[112]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_child_routine')?><?php if($setting[112]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="child_routine[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[112]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="row">
                    <?php if($setting[113]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading16<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse16<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse16<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_memorize_Quran')?><?php if($setting[113]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse16<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading16<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                                <input type="text" class="form-control collaps-input"
                                    name="memorize_Quran[<?=$addStudentValue?>]" placeholder="<?=lang('am_answer_qr')?>"
                                    <?php if($setting[113]->required == 1){echo required;}?>>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[114]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading17<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse17<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse17<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('er_parenting_strategies')?><?php if($setting[114]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse17<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="heading17<?=$addStudentValue?>">
                            <div class="panel-body p-0">
                            <select id="parenting_strategies" name="parenting_strategies[<?=$addStudentValue?>]"
                                    class="form-control collaps-input valid" aria-invalid="false"
                                    <?php if($setting[114]->required == 1){echo required;}?>>
                                    <option value=""><?=lang('am_select')?></option>
                                    <option value="<?=lang('er_Childhood_study');?>"><?=lang('er_Childhood_study');?></option>
                                    <option value="<?=lang('er_training_courses');?>"><?=lang('er_training_courses');?></option>
                                    <option value="<?=lang('er_previous_experience');?>"><?=lang('er_previous_experience');?></option>
                                    <option value="<?=lang('er_Read_books');?>"><?=lang('er_Read_books');?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <div>
            <div class="panel-group" id="" role="tablist" aria-multiselectable="true">



                <?php $medical = $this->db->query("SELECT * FROM `form_setting` where  type = 'MD' AND form_type = 1 AND display=1")->result();
                if(!empty($medical)){
                ?>
                <div class="col-xs-12 title_register">
                    <h5 style="margin: 10px 0 30px;"><i class="fa fa-user"
                            aria-hidden="true"></i><?=lang('am_student_psyyy')?> <span id="std<?=$addStudentValue?>"
                            class="danger"></span></h5>
                </div>
                <?php } ?>
                <div class="row">
                    <?php if($setting[90]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading19<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse19<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse19<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_diseases')?><?php if($setting[90]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val5" name="check_diseases" value="1" style="width:auto;" <?php if($setting[90]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn5" name="check_diseases" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show5">
                            <div id="collapse19<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading19<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_diseases[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[90]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[91]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading20<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse20<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse20<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_treatment')?><?php if($setting[91]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val6" name="check_treatment" value="1" style="width:auto;" <?php if($setting[91]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn6" name="check_treatment" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show6">
                            <div id="collapse20<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading20<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_treatment[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[91]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if($setting[92]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading21<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse21<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse21<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_history')?><?php if($setting[92]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val7" name="check_history" value="1" style="width:auto;" <?php if($setting[92]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn7" name="check_history" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show7">
                            <div id="collapse21<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading21<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_history[<?=$addStudentValue?$addStudentValue:0?>][]"
                                        placeholder="<?=lang('am_student_father_side')?>"
                                        style="border-bottom: 2px solid #efefef !important;"
                                        <?php if($setting[43]->required == 1){echo required;}?>>
                                    <input type="text" class="form-control collaps-input"
                                        name="student_history[<?=$addStudentValue?$addStudentValue:0?>][]"
                                        placeholder="<?=lang('am_student_mother_side')?>"
                                        <?php if($setting[92]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[93]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading22<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse22<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse22<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_allergy')?><?php if($setting[93]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val8" name="check_allergy" value="1" style="width:auto;" <?php if($setting[93]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn8" name="check_allergy" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show8">
                            <div id="collapse22<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading22<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_allergy[<?=$addStudentValue?$addStudentValue:0?>][]"
                                        placeholder="<?=lang('am_student_food')?>"
                                        style="border-bottom: 2px solid #efefef !important;"
                                        <?php if($setting[43]->required == 1){echo required;}?>>
                                    <input type="text" class="form-control collaps-input"
                                        name="student_allergy[<?=$addStudentValue?$addStudentValue:0?>][]"
                                        placeholder="<?=lang('am_student_medicin')?>"
                                        <?php if($setting[93]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <?php if($setting[94]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading24<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse24<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse24<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?=lang('am_student_health')?><?php if($setting[94]->required == 1){echo '<span class="danger">*</span>';}?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val_yes9" name="check_health" value="1" style="width:auto;" <?php if($setting[94]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_val_no9" name="check_health" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show9">
                            <div id="collapse24<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading24<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_health[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[94]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } if($setting[95]->display == 1){?>
                    <div class="col-md-6 panel panel-default panel_regist_all">
                        <div class="panel-heading panel-regist" role="tab" id="heading24<?=$addStudentValue?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion2<?=$addStudentValue?>"
                                    href="#collapse24<?=$addStudentValue?>" aria-expanded="true"
                                    aria-controls="collapse24<?=$addStudentValue?>">
                                    <i class="fa fa-chevron-down pull-left" aria-hidden="true"></i>
                                    <?php 	if ($this->ApiDbname == "SchoolAccTilalAlzahran") { ?>
                                    <?=lang('Does_suffer_notmentioned')?><?php if($setting[95]->required == 1){echo '<span class="danger">*</span>';}?>
                               <?php }else{  ?>
                               <?=lang('Does_student_suffer_notmentioned')?><?php if($setting[95]->required == 1){echo '<span class="danger">*</span>';}?>
                               <?php } ?>
                                </a>
                            </h4>
                        </div>
                        <input type="radio" id="check_val10" name="check_health_not" value="1" style="width:auto;" <?php if($setting[95]->required == 1){echo required ;}?>>
                        <?=lang('Yes')?>
                        <input type="radio" id="check_valn10" name="check_health_not" value="2" style="width:auto;">
                        <?=lang('NO')?>
                        <div id="show10">
                            <div id="collapse24<?=$addStudentValue?>" class="panel-collapse collapse in" role="tabpanel"
                                aria-labelledby="heading24<?=$addStudentValue?>">
                                <div class="panel-body p-0">
                                    <input type="text" class="form-control collaps-input"
                                        name="student_health_not[<?=$addStudentValue?>]"
                                        placeholder="<?=lang('am_answer_qr')?>"
                                        <?php if($setting[95]->required == 1){echo required;}?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    document.getElementById("show").style.display = "none";
    document.getElementById("x").style.display = "none";
    document.getElementById("show3").style.display = "none";
    document.getElementById("show4").style.display = "none";
    document.getElementById("show5").style.display = "none";
    document.getElementById("show6").style.display = "none";
    document.getElementById("show7").style.display = "none";
    document.getElementById("show8").style.display = "none";
    document.getElementById("show9").style.display = "none";
    document.getElementById("show10").style.display = "none";
});

$('input[name^="check_val"]').on('change', function() {
    if (document.getElementById('check_val1').checked) {

        document.getElementById("show").style.display = "block";
    }
    if (document.getElementById('check_valn1').checked) {
        $('#show').hide();
    }
});
$('input[name^="check_game"]').on('change', function() {
    if (document.getElementById('check_val2').checked) {
        document.getElementById("x").style.display = "block";
    }
    if (document.getElementById('check_valn2').checked) {
        $('#x').hide();
    }
});
$('input[name^="check_behavior"]').on('change', function() {
    if (document.getElementById('check_val3').checked) {
        document.getElementById("show3").style.display = "block";
    }
    if (document.getElementById('check_valn3').checked) {
        $('#show3').hide();
    }
});
$('input[name^="check_specialist"]').on('change', function() {
    if (document.getElementById('check_val4').checked) {
        document.getElementById("show4").style.display = "block";
    }
    if (document.getElementById('check_valn4').checked) {
        $('#show4').hide();
    }
});
$('input[name^="check_diseases"]').on('change', function() {
    if (document.getElementById('check_val5').checked) {
        document.getElementById("show5").style.display = "block";
    }
    if (document.getElementById('check_valn5').checked) {
        $('#show5').hide();
    }
});

$('input[name^="check_treatment"]').on('change', function() {
    if (document.getElementById('check_val6').checked) {
        document.getElementById("show6").style.display = "block";
    }
    if (document.getElementById('check_valn6').checked) {
        $('#show6').hide();
    }
});
$('input[name^="check_history"]').on('change', function() {
    if (document.getElementById('check_val7').checked) {
        document.getElementById("show7").style.display = "block";
    }
    if (document.getElementById('check_valn7').checked) {
        $('#show7').hide();
    }
});
$('input[name^="check_allergy"]').on('change', function() {
    if (document.getElementById('check_val8').checked) {
        document.getElementById("show8").style.display = "block";
    }
    if (document.getElementById('check_valn8').checked) {
        $('#show8').hide();
    }
});
$('input[name^="check_health"]').on('change', function() {
    if (document.getElementById('check_val_yes9').checked) {
        document.getElementById("show9").style.display = "block";
    }
    if (document.getElementById('check_val_no9').checked) {
        // document.getElementById("show9").style.display = "none";
        $('#show9').hide();
    }
});
$('input[name^="check_health_not"]').on('change', function() {
    if (document.getElementById('check_val10').checked) {
        document.getElementById("show10").style.display = "block";
    }
    if (document.getElementById('check_valn10').checked) {
        // document.getElementById("show9").style.display = "none";
        $('#show10').hide();
    }
});
$(document).on('keyup', '.arabicNumbers', function(e) {
    var val = toEnglishNumber($(this).val())
    $(this).val(val)
});
</script>