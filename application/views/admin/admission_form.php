<style>
    @font-face {
        font-family: 'The-Sans-Plain';
        src: url('./The-Sans-Plain.otf') format('opentype');
        font-weight: normal;
        font-style: normal;
    }
    body {
        font-family: 'The-Sans-Plain', sans-serif;
    }
    .admission-form{
        position:relative;
        width: 80%;
        margin: auto;
        height: 98vh;
        }
    .admission-form .images{display: flex;justify-content: space-between;margin-bottom: 40px;}
    .admission-form .title{text-align: center;font-weight: bold;color: #c21414;margin-right: 35px;}
    .admission-form table{border-collapse: collapse;text-align: center;width: 100%;}
    .admission-form table th{color: #c21414;}
    .admission-form td,
    .admission-form th{padding: 5px;text-align: center;}
    .admission-form p{margin: 12px 0;font-size: 26px;}
    .signature{text-align: center;position: absolute;left: 22%;font-weight: bold;}
    .signature .date {font-weight: normal;display: inline-block;
    position: absolute;
    width: 260px;
    left: -135px;}
    .form-footer{position: absolute;bottom: 0;width: 100%;}
    .form-footer p{text-align: center;}
    .form-footer span{font-size: 20px;}
    .printBtn{
        padding: 5px;
        width: 100px;
    }
    .footer-page{display: none;}
    .backlogo img{
        position: absolute;
        right: -0;
        width: 1000px;
        transform: rotate(-45deg);
        opacity: 0.2;
        bottom: 0;
        z-index: -1;
    }
    @media print {
        @page{
            size: portrait;
        }
        .admission-form{width: 94%;margin: auto;}
        .admission-form p{font-size: 30px;}
        .printBtn,.content_new.white,.footer-page{display: none;}
        input{border: none;font-size: 20px;padding: 5px;}
        .backlogo img{right: -350px;bottom: -140px;}
        .admission-form .title,
        .admission-form table th{
            color: #c21414 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<?php
$query = $this->db->query("select * from setting")->row_array();
?>
<div class="admission-form">
    <div style="text-align: left"><input type="button" class="btn btn-primary printBtn" onclick="window.print()" value="طباعة"/></div>
    <div class="images">
        <div><img class="eduLogo" src="<?php echo base_url(); ?>intro/images/school_logo/MOELogo.png" width="170" /></div>
        <div><img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" width="130" ></div>
        <div><img src="<?php echo base_url(); ?>intro/images/school_logo/Saudi_Vision_2030_logo.svg.png" width="140" ></div>
        
    </div>
    <h2 class="title"><?php echo lang('er_accept_student') ;?> </h2>
    <br>
    <table border="1">
        <thead>
            <tr>
                <th>م</th>
                <th><?php echo lang('student_name');?> </th>
                <th>الصف / Grade</th>
                <th>العام الدراسي / Academic Year</th>
                <th>المدرسة المنقول منها / Transferred from</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">1</td>
                <td><input type="text">  </td>
                <td><input type="text"></td>
                <td>2023/2024 م</td>
                <td><input type="text" id="schoolInput"></td>
            </tr>
            <tr>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td>2023/2024 م</td>
                <td><input type="text"></td>
            </tr>
        </tbody>
    </table><br><br>
    <p>المكرم مدير  مدرسة    <span id="schoolName"></span> المحترم</p>
    <p>السلام عليكم و رحمة الله و بركاته  ....    و بعد ،،،</p>
    <p>نظراً لرغبة ولي أمر الطالب الموضحة بياناته أعلاه في إلحاق الطالب بمدارس تبوك العالمية للعام الدراسي 2023/2024 م.</p>
    <p>عليه نفيدكم بأنه لا مانع لدينا من قبول الطالب ، و عليه نأمل من سعادتكم إرسال ملف الطالب بكامل محتوياته، و نقله عبر نظام نور الالكتروني.</p>
    <p>شاكرين لكم حسن تعاونكم ، و لكم جزيل الشكر و التقدير ،،،</p>
    <br><br><br><br><br>
    <div class="backlogo">
    <img src="<?php echo base_url(); ?>intro/tabukImages/tabuklogo.png" width="150px" />
    </div>
    
    <p class="signature">
        يعتمد<br><br>
        <span style="margin-right: -66px">قائد/ة المدرسة :</span> <br><br>
        <span class="date">التاريخ : <?php echo date('Y/m/d') ;?> م</span><br>
    </p>
    
    <div class="form-footer">
        <p>
            <span style="color: var(--main-color2) !important">00966144212374 - www.tabukis.com - info@tabukis.com - P.O.Box: 71471-3448</span><br>
            <span style="color: var(--main-color) !important">شركة تبوك العالمية (ذات مسؤولية محدودة) - رقم السجل التجاري: 3550023271 - المملكة العربية السعودية - تبوك - المروج</span>
        </p>
    </div>
</div>
<script>
    var typingTimer;
    var doneTypingInterval = 500;
    document.getElementById("schoolInput").onkeyup = function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function() {
        document.getElementById("schoolName").textContent = document.getElementById('schoolInput').value;
    }, doneTypingInterval);
    };
</script>
