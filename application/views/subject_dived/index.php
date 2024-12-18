
<?php extract($this->data);
$units = $subject['units'];
// print_r($subject['name_ar']);die;
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Layout without menu - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="<? base_url() ?>/vuexy/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<? base_url() ?>/vuexy/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/vendors/css/extensions/toastr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/themes/bordered-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/plugins/extensions/ext-component-toastr.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/app-assets/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="<? base_url() ?>/vuexy/assets/css/style-rtl.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu dark-layout 1-column navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="1-column" data-layout="dark-layout">


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">

                        <div class="col-12 col-md-10">

                            <h2 class="content-header-title float-left mb-0">توزيع الخطة للمواد</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">مادة</a>
                                    </li>

                                    <li class="breadcrumb-item"><a href="#"><?= $subject['name_ar']; ?>< /a>

                                    </li>
                                    <li class="breadcrumb-item active">الوحدات والدروس
                                    </li>
                                </ol>
                            </div>

                            
                        </div>
                        <div class="col-12 col-md-2">
<div class="avatar rounded">
    <div class="avatar-content">
    <i data-feather='home'></i>

    </div>
    
</div>                            
                                               </div>

                    </div>

                </div>

            </div><!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                    <div class="col-xl-20 col-md-8 col-12">
                        <div class="card card-congratulation-medal">
                            <div class="card-body">
                                <h5>الوحدات والدروس</h5>
                                <p class="card-text font-small-3">من هنا يمكن إضافة الوحدات وتسميها يدويا او تلقائياً</p>

                                <? foreach ($units as $unit) { ?>
                                    <table class="table table-hover-animation">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <H3><?= $unit['name_ar']; ?></H3>
                                                </th>
                                                <th>Status</th>
                                                <th><button id="showFormButton" onclick="getUnitId(this)" data-UnitId="<?= $unit['id']; ?>" class="btn btn-success btn-sm waves-effect waves-float waves-light showFormButton">إضاقة درس</button></th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <? foreach ($unit['lesson'] as $lesson) { ?>
                                                <tr>

                                                    <td>-<H4><?= $lesson['name_ar'] ?></H4>
                                                    </td>

                                                    <td><span class="badge badge-pill badge-light-danger mr-1"><?= $lesson['statusText']; ?> </span></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a onclick="getLessonData(<?= $lesson['id']; ?>)" class="dropdown-item" href="javascript:void(0);">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>تعديل اسم الدرس</span>
                                                                </a>
                                                                <a class="dropdown-item" href="javascript:void(0);">
                                                                    <i data-feather="trash" class="mr-50"></i>
                                                                    <span>حزف الدرس </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <? } ?>


                                        </tbody>
                                    </table>

                                <? } ?>

                                <button class="btn btn-success  waves-effect waves-float waves-light" data-toggle="modal" data-target="#inlineForm">أضاقة وحدة جديدة </button>

                            </div>
                        </div>
                    </div>
                    <!--/ Medal Card -->

                    <!-- Statistics Card -->
                    <div class="col-xl-20 col-md-4 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">

                                <!-- <h2>إضافة درس إلى وحدة رقم- 1</h2> -->

                            </div>
                            <div class="card-body statistics-body">
                                <img id="imageElement" src="<? base_url() ?>/vuexy/app-assets/images/illustration/pricing-Illustration.svg" alt="">
                                <form id="lessonForm" class="form">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">الاسم باللغة العربية</label>

                                                <input type="text" id="lessonArabicName" class="form-control" name="fname-column" />
                                            </div>
                                        </div>
                                            <input type="text" id="lessonId" class="form-control" name="lessonId" readonly />

                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="last-name-column">الاسم باللغة الانجليزية</label>
                                                <input type="text" id="lessonEnglishName" class="form-control" name="lname-column" />
                                            </div>
                                        </div>
                                        <div class=" col-md-6  col-12 custom-control custom-control-info custom-checkbox">
                                            <div class="form-group">

                                                <input type="checkbox" class="custom-control-input" id="colorCheck6" checked />
                                                <label class="custom-control-label" for="colorCheck6">تم شرح الدرس مسبقاً</label>
                                            </div>
                                        </div>

                                        <div class=" col-md-6 col-12 custom-control custom-control-info custom-checkbox">
                                            <div class="form-group">

                                                <input type="checkbox" class="custom-control-input" id="colorCheck7" checked />
                                                <label class="custom-control-label" for="colorCheck7">تم وضع اختبار للدرس مسبقاً</label>
                                            </div>
                                        </div>

                                        <div class=" col-md-6 col-12 custom-control custom-control-info custom-checkbox">
                                            <div class="col-12">
                                                <button onclick="saveLesson()" type="button" class="btn btn-primary mr-1">حفظ</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics Card -->
                </div>


                <!--/ Revenue Report Card -->
        </div>
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">بينات الوحدة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#">
                        <input value="<?= $subject['id']; ?>" id="subId" type="hidden" name="">
                        <div class="modal-body">
                            <label>الاسم بالعربية</label>
                            <div class="form-group">
                                <input id="arabicName" type="text" class="form-control" />
                            </div>

                            <label>الاسم بالإنجليزية </label>
                            <div class="form-group">
                                <input id="englishName" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="saveunit()" type="button" class="btn btn-success saveButton" data-dismiss="modal">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </section>
        <!-- Dashboard Ecommerce ends -->

        <!-- BEGIN: Vendor JS-->
        <script src="<? base_url() ?>/vuexy/app-assets/vendors/js/vendors.min.js"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="<? base_url() ?>/vuexy/app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="<? base_url() ?>/vuexy/app-assets/vendors/js/charts/apexcharts.min.js"></script>
        <!-- <script src="<? base_url() ?>/vuexy/app-assets/vendors/js/extensions/toastr.min.js"></script> -->
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="<? base_url() ?>/vuexy/app-assets/js/core/app-menu.js"></script>
        <script src="<? base_url() ?>/vuexy/app-assets/js/core/app.js"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="<? base_url() ?>/vuexy/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
        <!-- END: Page JS-->
        <script>
            let unitID = null;
            lessonForm.style.display = "none";

            function getUnitId(data) {

                const imageElement = document.getElementById("imageElement");
                const lessonForm = document.getElementById("lessonForm");
                unitID = data.getAttribute("data-UnitId");
                console.log(unitID);
                lessonForm.style.display = "block";
                imageElement.style.display = "none";
            }
        </script>

        <script>
            $(window).on('load', function() {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            })

            function saveunit() {
                var arabicName = document.getElementById("arabicName").value;
                var englishName = document.getElementById("englishName").value;
                var subjectID = document.getElementById("subId").value;

                var dataToSend = {
                    apikey: 'chat.lms.esol.com.sa',
                    name_ar: arabicName,
                    name_en: englishName,
                    SubjectId: subjectID
                };

                $.ajax({
                    type: 'POST',
                    url: 'https://chat.lms.esol.com.sa/apikey/subdivid/unit',
                    data: dataToSend,
                    dataType: 'json',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        location.reload();
                    }
                });
            };



            function saveLesson() {
                var arabicName = document.getElementById("lessonArabicName").value;
                var englishName = document.getElementById("lessonEnglishName").value;
                var lessonId = document.getElementById("lessonId").value;

                var requestData = {
                    apikey: 'chat.lms.esol.com.sa',
                    name_ar: arabicName,
                    name_en: englishName,
                    unitId: unitID,
                    lessonId: lessonId ?? null,
                };

                $.ajax({
                    type: 'POST',
                    url: 'https://chat.lms.esol.com.sa/apikey/subdivid/lesson',
                    data: requestData,
                    dataType: 'json',
                    success: function(response) {
                        location.reload();

                    },
                    error: function(xhr, status, error) {
                        location.reload();
                    }
                });
            }

            function getLessonData($id){
                var requestData = {
                    apikey: 'chat.lms.esol.com.sa',
                    lessonId: $id,
                };

                $.ajax({
                    type: 'GET',
                    url: 'https://chat.lms.esol.com.sa/apikey/subdivid/lesson',
                    data: requestData,
                    dataType: 'json',
                    success: function(response) {
                        console.log("iam here");
                    document.getElementById('lessonArabicName').value = response.name_ar;
                    document.getElementById('lessonEnglishName').value = response.name_en;
                    document.getElementById('lessonId').value = response.id;

                    document.getElementById('lessonForm').style.display = 'block';
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        console.log(status);
                        console.log(xhr);
                    }
                });
            }



            document.addEventListener("DOMContentLoaded", function() {
        const editLessonLink = document.querySelector('.dropdown-item');

        editLessonLink.addEventListener("click", function(event) {
            event.preventDefault();

            fetch('https://chat.lms.esol.com.sa/apikey/subdivid/lesson?apikey=127.0.0.1&lessonId=1')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('lessonArabicName').value = data.name_ar;
                    document.getElementById('lessonEnglishName').value = data.name_en;
                    document.getElementById('lessonId').value = data.id;

                    document.getElementById('lessonForm').style.display = 'block';
                })
                .catch(error => {
                    console.error('حدث خطأ أثناء جلب البيانات:', error);
                });
        });
    });
        </script>


</body>

</html>