<style>
    .questions .question-card {
        width: 1000px;
    }
</style>
<main class="col-8 text-center">
    <!-- all quiz question -->
    <div class="questions">
        <!-- Loop through questions -->
        <!-- Replace this section with your data -->
        <!-- Begin Loop -->
        <div class="question-card choose-question" style="margin-right: 42px; width: 930px;">
            <!-- card header -->
            <div class="question-card__header flexbox align-between">
                <div class="question-card__icon exam-box__type">
                    <!-- Replace this with your class determination logic -->
                    <i class="blue fas fa-signature"></i>
                    <h3>Question: 1<br><span class="danger-color">Question Type</span></h3>
                </div>
                <div class="question-card__action">
                    <!-- Replace this with your buttons and actions -->
                    <a href="#" class="btn outline success">Edit</a>
                    <a href="#" class="btn outline fas fa-trash primary" onclick="return confirm('Are you sure to delete?')"></a>
                </div>
            </div>
            <!-- //card header -->
            <!-- card body -->
            <div class="question-card__body">
                <div class="question-card__question">
                    <!-- Replace this with your question content -->
                    <h3>Question Content Here</h3>
                </div>
                <hr/>
                <!-- Answer section -->
                <!-- Replace this with your answer options based on question type -->
                <!-- You can repeat this section as needed -->
                <div class="exam-box__multi-choices">
                    <!-- Answer option 1 -->
                    <div class="choice">
                        <input type="checkbox" checked value="1" onclick="return false" readonly>
                        <br>
                        <!-- Replace this with your answer content -->
                        <img height="150px" src="image1.jpg" style="height: 200px !important;">
                    </div>
                    <!-- Answer option 2 -->
                    <div class="choice">
                        <input type="checkbox" value="0" onclick="return false" readonly>
                        <br>
                        <!-- Replace this with your answer content -->
                        <div style="text-align: center; margin-top: 72px; font-size: large; word-break: break-all;">
                            <span>Answer Text Here</span>
                        </div>
                    </div>
                    <!-- Add more answer options as needed -->
                </div>
                <!-- End of answer section -->
                <!-- Attachment section -->
                <div style="text-align: end;">
                    <!-- Replace this with your attachment content -->
                    <img height="150px" src="attachment.jpg" style="height: 200px !important;">
                </div>
            </div>
            <!-- //card body -->
        </div>
        <!-- End Loop -->
    </div>
</main>
