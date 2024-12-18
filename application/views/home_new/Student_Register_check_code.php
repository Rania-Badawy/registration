
  <style>
      .top-bar , .nav-bar , footer {
          display:none;
      }
      .widgets-box h4{
        font-size: 19px;
        font-weight: 600;
        float: initial !important;
        background-color: #40aae6;
        padding: 14px;
        text-align: center;
        margin: 0 0 25px 0;
      }
      .widgets-box h4 span{
          border-bottom: 0 !important;
          color: #fff !important;
      }
      .all-data-content{
        padding: 0 0 10px;
        background-color: #f5f5f5;
        box-shadow: 0px 1px 3px #cecece;
      }
      .success-data{
        text-align: right;
        font-family: unset;
        direction: rtl;
      }
      .success-data h3{
        color: green;
        font-size: 25px;
        margin:0;
        padding: 14px 10px;
        position: relative;
        margin-right: 10px;
        margin-top: 3px;
      }
      .success-data h3::after{
        content: "";
        width: 109px;
        height: 3px;
        display: block;
        background: green;
        margin-right: -5px;
      }
      .success-data ul{
          list-style: none;
      }
      .success-data ul li{
        font-size: 18px;
        margin-bottom: 14px;
        margin-top: 17px;
      }
      .success-data ul li:after{
        content: "";
        color: green;
        font-family: FontAwesome;
        font-size: 12px;
        margin-left: 7px;
        line-height: 0;
        width: 15px;
        height: 15px;
        display: inline-block;
        background: green;
        border-radius: 50%;
        float: right;
      }
       .refuse-data1{
        text-align: right;
        font-family: unset;
        border: 1px solid red;
        background: #f00;
        color: #fff;
        border-radius: 10px;
        width: 50%;
        margin: auto;
      }
      .refuse-data1 ul{
          list-style: none;
      }
      .refuse-data1 ul li{
        font-size: 20px;
        margin-bottom: 14px;
        margin-top: 17px;
        font-weight: bold;
      }
      .refuse-data1 ul li:after{
        content: "";
        color: red;
        font-family: FontAwesome;
        font-size: 12px;
        margin-left: 7px;
        line-height: 0;
        width: 15px;
        height: 15px;
        display: inline-block;
        background: #940000;
        margin-right: 13px;
        border-radius: 50%;
      }
      .block-symbol:after{
        content: "\f056" !important;
        color: red;
        font-family: FontAwesome;
        font-size: 12px;
        margin-left: 7px;
        line-height: 0;
      }
      .codeInput{
        height: 36px;
        border-color: #e6e6e6;
        box-shadow: none;
        border: 0;
        width: 500px;
        text-align: center;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
      }
      .btn.btn-success{
        min-width: 150px;
        height: 36px;
        display: inline-block;
        border: 2px solid #337ab7;
        outline: none;
        background: #337ab7;
        border-radius: 15px;
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        cursor: pointer;
      }
      .btn.btn-info{
        text-align: left;
        text-decoration: none;
        display: inline-block;
        width: 200px;
        font-size: 18px;
        font-weight: bold;
        color: #40aae6;
      }
      .requestContent{
          background: #fff;
          padding-top: 50px;
      }
  </style> 
<div class="container">
    <div class="col-lg-12 col-md-12">
        <div class="widgets-box widgets-box-in wow fadeIn" data-wow-duration="0s" data-wow-delay="0s" 
        style="margin-top: 30;min-height: 420px;">
            <div class="all-data-content col-xs-12" style="width:80%;margin:auto">
            <h4><span class="text-color">تتبع طلب التسجيل</span></h4>
                <div class="col-lg-2 form-group"></div>
                <div class="col-lg-5 form-group">
                    <label class="control-label"> </label>
                    <div class="col-lg-12 row" style="text-align: center">
                        <input class="form-control codeInput" dir="rtl" type="text" id="code" name="code" placeholder="اكتب كود الطالب هنا">
                    </div>
                </div>
                <div class="col-lg-5 form-group">
                    <label class="control-label"> </label>
                    <div class="col-lg-12 row text-right" dir="rtl" style="text-align:center">
                        <input id="check_data" class="btn btn-success" type="submit" name="code" value="متابعه"> 
                        <a class="btn btn-info btn-st btn-st" href="<?php echo site_url('home/student_register/index'); ?>">العودة لنظام التسجيل</a>
                    </div>
                </div>
            <br><br>
            <div class="requestContent">
                <!--div style="display:none" id="success" class=" col-lg-12 alert alert-success"></div-->
            <!--div style="display:none" id="danger" class="col-lg-12 alert alert-danger"></div-->
            <div style="display:none" class=" col-lg-6 success-data">
                <h3>حالة الطلب</h3>
                <ul id="success"></ul>
            </div>
            <div style="display:none" class=" col-lg-6 refuse-data1">
                <ul id="error"></ul>
            </div>
            <div style="display:none" class=" col-lg-6 refuse-data">
                <h3>حالة الطلب</h3>
                <ul id="danger"></ul>
            </div>
            <div class="col-lg-12 col-md-12" style="text-align: center;margin-top: 50px">
                <?php $query=$this->db->query("select * from setting")->row_array(); ?>
					   <img style="width: 20%; opacity: .3;" src="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo']?>"/>
            </div>
            </div>
        
            </div>
        </div>  
    </div>      
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     
<script>
   
$(document).ready(function() {
    
$("#check_data").click(function(e) {

    $(".success-data").css('display', 'none');
    $(".refuse-data").css('display', 'none');
     $(".refuse-data1").css('display', 'none');
    $("#success").html('');
    $("#danger").html('');
        var code   = $("#code").val(); 
        $.ajax({
        type    : "POST",
        url     : "<?php echo site_url('home/student_register/check') ?>",
        data    :{code :code} ,
        cache   : false,
        success : function(data){
            if(data.success == 1 ){
              console.log();
                /*if(data.data[0].IsRefused == 1){
                    $("#danger").css('display', 'block');
                    $("#danger").html('<b> '+"<?php echo lang('am_Check_IsRefused');?>"+' </b>');
                }*/
                for (var i = 0; i < data.data.length; i++) {
                    if (data.data[i].NameSpaceID != null) {
                        for (var x = 0; x < data.levels.length; x++) {
                            levelName = data.levels[x].Name;
                            if (data.lang != 'arabic') {
                                levelName = data.levels[x].Name_En;
                            }
                            if (data.data[i].NameSpaceID == data.levels[x].NameSpaceID && data.data[i].IsActive == 1) {
                                $(".success-data").css('display', 'block');
                                $("#success").append('<li><b>'+data.data[i].name+"</b>"+": "+"<?php echo lang('am_Check_success_from');?>"+levelName+'</li>');
                                if ( data.data[i].IsActive == 1 && data.levels[x].NameSpaceID == 85 && data.data[i].receipt == '') {
                                  $("#success").append('<br><div id="receipt'+data.data[i].id+'"><label>قم برفع ايصال تسديد الرسوم للطالب  '+data.data[i].name+'</label><input name="receipt" type="file" onchange="upload_file($(this), '+data.data[i].id+')" accept="image/*" class="form-control"></div>');
                                }
                                if ( data.data[i].IsActive == 1 && data.levels[x].NameSpaceID == 85 && data.data[i].receipt != '') {
                                //   $("#success").append('<br><div id="receipt'+data.data[i].id+'"><img src="<?=base_url("upload/")?>'+data.data[i].receipt+'"></div>');
                                }
                            }
                            if (data.data[i].NameSpaceID == data.levels[x].NameSpaceID && data.data[i].IsActive == 0) {
                                $(".refuse-data").css('display', 'block');
                                $("#danger").append('<li class="block-symbol"><b>'+data.data[i].name+"</b>"+": "+"<?php echo lang('am_Check_Not_checked_from');?>"+levelName+' </li>');
                            }
                            if (data.data[i].NameSpaceID == data.levels[x].NameSpaceID && data.data[i].IsActive == 2) {
                                $(".refuse-data").css('display', 'block');
                                $("#danger").append('<li><b>'+data.data[i].name+"</b>"+": "+"<?php echo lang('am_Check_refused_from');?>"+levelName+' </li>');
                            }
                        }
                    }
                    else {
                        $(".refuse-data").css('display', 'block');
                        $("#danger").append('<li class="block-symbol"> '+data.data[i].name+":"+"<?php echo lang('am_Check_Not_Checked_yet');?>"+' </li>');
                    }
                }
            }else{
                $(".refuse-data1").css('display', 'block');
                    $("#error").html('<li> '+"<?php echo lang('am_Check_error');?>"+' </li>');
            }
            
        }
        }); 

}); /////BTN CLICK

});
</script>

<script type="text/javascript">
  function upload_file(fileInput, id) {
        var fd = new FormData();
        var files = fileInput[0].files[0]; 
        fd.append('userfile', files);
        fd.append('id', id);
        $.ajax({
            url: '<?=site_url('home/student_register/upload_receipt')?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == 1) {
                    $('#receipt'+id).html('');
                    $('#receipt'+id).append('<img src="<?=base_url("upload/")?>'+response.img+'">')
                } else {
                    alert(response.msg);
                }
            }
        });
    }
</script>
