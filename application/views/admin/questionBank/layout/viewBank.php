
<?if($this->session->userdata('type') == 'U'){?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?}?>
<style>
    .qIcon {
        font-size: 1.5rem;
        margin-left: 5px;
    } 

    .question-card {
        position: relative;
    }

    .qselect {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .chooseAnswer {
        font-size: 22px;
        font-weight: bold;
        text-transform: initial;
        text-align: center;
        margin-bottom: 15px;
    }

    .chooseAnswer::after {
        background-color: #000;
        width: 180px;
        height: 3px;
        display: block;
        content: '';
        margin: auto
    }

    .chooseAns {
        padding: 5px;
        font-size: 18px;
        border-radius: 3px;
        font-weight: bold;
    }

    .chooseQ,
    .completeQ {
        padding: 10px !important;
        min-height: unset !important;
        background-color: transparent;
        border: 0
    }

    .chooseQ h2,
    .completeQ h2 {
        color: #000 !important;
        margin: 0
    }

    .chooseQ p,
    .completeQ p {
        margin: 0 !important
    }

    .page-head h1 {
        margin-bottom: 15px !important;
    }

    .question-card__question p {
        display: inline;
    }

    .questions .question-card {
        min-height: unset !important;
    }

    .question-bank #question-bank.modal-box .modal-quiz-body {
        padding: 0 !important
    }

    .questions .question-card__question h3 {
        margin-right: 1em !important;
    }

    .red-bg {
        background-color: red;
        color: white;
        text-align: center;
    }

    .green-bg-cust {
        background-color: green;
        color: white;
        text-align: center;
    }


    .student-quiz__question-header {
        width: 100%;
    }
    .fa-trash-alt:before, .fa-trash-can:before {
    content: "\f2ed";
    color: red;
}


.swal2-container {
    z-index: 99999999;
}
.modal-box.active {
    position: absolute;
    z-index: 99999998;
}
    
</style>
<div class="quiz question-bank row no-guuter row-reverse">

    <div class="modal-box" id="question-bank">
        <div class="modal-content">

            <div class="row modal-quiz-body">

                <section class="quiz-questions col-12">
                    <div class="quiz-header">

                    </div>
                    <!-- all quiz question -->
                    <div class="questions" id="modal-content">

                    </div>
                    <!-- //all quiz question -->
                    </main>
            </div>
            <div class="modal-quiz-footer">
                <!-- <button class="btn red-bg">ؤم</bu> -->
            </div>
        </div>
    </div>
</div>


<script>
function  deletequestion(questionId,BankId) {
  
    Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "هل ترغب حقًا في حذف هذا السؤال؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'إلغاء',
            confirmButtonText: 'نعم، احذفه!'
        }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                        url: 'https://chat.lms.esol.com.sa/apikey/bank/destroyQuestion',
                        type: "POST",
                        cache: false,
                        data: {
                            apikey: "chat.<?= $_SERVER['SERVER_NAME'] ?>",
                            bankId: BankId,
                            questionId:questionId,
                        },
                        success: function (response) {
                            if (response.status) {
                                $('#question-' + questionId).remove();
                                Swal.fire('تم!', response.message, 'success');
                            } else {
                                Swal.fire('خطأ!', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('خطأ!', 'حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.', 'error');
                        }
                    });
                }
           
        });
}
</script>