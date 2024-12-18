// let base_count  = document.getElementById("for_count");
// if(base_count){
//     let baseEditors  = [base1];
//     let oppEditors   = [opp1];
//     var matchCounter = base_count + 1;
// }else{
    // let baseEditors  = [base1];
    // let oppEditors   = [opp1];
    let matchCounter = baseEditors.length + 1 ;
//}



function insertChoiceImage(e) {
  let id = e.getAttribute("data-id");
  getBase64(e.files[0]).then((data) => {
    if (document.getElementById(`choice${id}`)) {
      choicesEditors[id - 1].insertEmbed(10, "image", data);
    } else {
      let type = e.getAttribute("data-type");
      eval(`${type}Editors[${id - 1}]`).insertEmbed(10, "image", data);
    }
  });
}
/*function insertChoiceImage(e) {
  let id = e.getAttribute("data-id");
  getBase64(e.files[0]).then((data) => {
    if (document.getElementById(`choice${id}`)) {
      let index = choicesEditors.findIndex(
        (e) => e.container.id == `choice${id}`
      );
      choicesEditors[index]?.insertEmbed(10, "image", data);
    
    } else {
      eval(id).insertEmbed(10, "image", data);
    }
  });
}*/
function insertImage(e) {
  getBase64(e.files[0]).then((data) => {
    quill.insertEmbed(10, "image", data);
  });
}
function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
}

function removeMatchChoice(buttonElement) {
  event.preventDefault();

  let id = buttonElement.getAttribute("data-id");
  let type = buttonElement.getAttribute("data-type");
  let matchContainer = document.getElementById(id).parentElement.parentElement;


  if (matchContainer.getElementsByClassName('match-item').length > 1) {
    document.getElementById(id).parentElement.remove();
  } else {
    if (matchContainer.getElementsByClassName('match-item').length > 1) {
      document.getElementById(id).parentElement.remove();
     
    } else {
      let message = type == 'base' ? "لا يمكن حذف السؤال الأخيرة." : "لا يمكن حذف الإجابة الأخيرة.";
      
      Swal.fire({
        title: 'تنبيه!',
        text: message,
        icon: 'warning',
        confirmButtonText: 'حسنًا'
      });
    }
}
}

let matchBase = document.getElementById("match-base");
let matchOpp = document.getElementById("match-opp");
function insertMatchRow() {
  inserMatchBase();
  inserMatchOpp();
  matchCounter++;
}

function inserMatchBase() {
  matchBase.insertAdjacentHTML(
    "beforeend",
    `<!-- match item  -->
    <div class="match-item">
      <!-- editor -->
      <div id="base${matchCounter}" ></div>
      <input type="hidden" name="counter" id="counter" value="${matchCounter}"/>
      <!-- //editor -->
      <!-- match item action -->
      <div class="match-item__action">
        <button type="button" class="editor-image" style="display:none">
          <input
            type="file"
            onchange="uploadImage_match(this)"
            data-id="${matchCounter}"
            data-type="base"
          />
           <input name ="hidImg_base_${matchCounter}" id ="hidImg_base_${matchCounter}" type="hidden" value="" />
          <i class="fas fa-image"></i>
        </button>
        <button
          onclick="removeMatchChoice(this)"
          data-id="base${matchCounter}"
          data-type="base"
          type="button"
        >
          <i class="fas fa-trash"></i>
        </button>
        <button class="card-toolbar__btn" data-id="base${matchCounter}_toolbar" onclick="showCardToolbar(this)" type="button" ">
            <i class="fas fa-font"></i>
          </button>
          <div class="equation-toolbar" style="display: none"></div>
          <!-- choice hidden toolbar -->
          <div id="base${matchCounter}_toolbar" class="card-toolbar collapsed">
            <button type="button" class="card-toolbar__color">
              <input type="color" class="ql-color" />
            </button>
            <button type="button" class="ql-bold">
              <i class="fas fa-bold"></i>
            </button>
            <button type="button" class="ql-italic">
              <i class="fas fa-italic"></i>
            </button>
            <button type="button" class="ql-underline">
              <i class="fas fa-underline"></i>
            </button>
            <button type="button" class="ql-strike">
              <i class="fas fa-strikethrough"></i>
            </button>
            <button type="button" class="ql-script" value="sub">
              <i class="fas fa-subscript"></i>
            </button>
            <button type="button" class="ql-script" value="super">
              <i class="fas fa-superscript"></i>
            </button>
            <button type="button" class="ql-link" type="button">
              <i class="fas fa-link"></i>
            </button>
            <button type="button" type="button" class="equation-btn">
              <i class="fas fa-function"></i>
            </button>
          </div>
          <!-- //choice hidden toolbar -->
      </div>
      <!-- //match item action -->
    </div>
    <!-- //match item  -->`
  );
  eval(`var base${matchCounter}= new Quill("#base${matchCounter}" , {
    theme: 'snow',
    modules: {
      toolbar: "#base${matchCounter}_toolbar",
    },
    placeholder: '...اكتب السؤال هنا',
  })`);
  eval(
    `let colorinput = document.querySelector('#base${matchCounter}_toolbar .ql-color')
    colorinput.addEventListener("change", (e) => {
      base${matchCounter}.format("color", colorinput.value);
    })`
  );
  baseEditors.push(eval(`base${matchCounter}`));

  // equation
  let editor = document.getElementById(`base${matchCounter}`).parentElement;
  let target = editor.querySelector(".ql-editor");
  let toolbar = editor.querySelector(".equation-toolbar");
  let btn = editor.querySelector(".equation-btn");
  let dynamic = editor.querySelector(".ql-container").getAttribute("id");
  generateEquationEditor(target, toolbar, "ar", dynamic);
  btn.addEventListener("click", (e) => {
    toggleBtns(btn, "#equation-choice .equation-toolbar", editor);
  });
}
function inserMatchOpp() {
  matchOpp.insertAdjacentHTML(
    "beforeend",
    `<!-- match item  -->
    <div class="match-item">
      <!-- editor -->
      <div id="opp${matchCounter}"></div>
      <!-- //editor -->
      <!-- match item action -->
      <div class="match-item__action">
        <button type="button" class="editor-image" style="display:none">
          <input
            type="file"
            onchange="uploadImage_match(this)"
            data-id="${matchCounter}"
            data-type="opp"
          />
           <input name ="hidImg_opp_${matchCounter}" id ="hidImg_opp_${matchCounter}" type="hidden" value="" />
          <i class="fas fa-image"></i>
        </button>
        <button
          onclick="removeMatchChoice(this)"
          data-id="opp${matchCounter}"
          type="button"
          data-type="opp"
        >
          <i class="fas fa-trash"></i>
        </button>
        <button class="card-toolbar__btn" data-id="opp${matchCounter}_toolbar" onclick="showCardToolbar(this)" type="button" >
          <i class="fas fa-font"></i>
        </button>
        <div class="equation-toolbar" style="display: none"></div>
        <!-- choice hidden toolbar -->
        <div id="opp${matchCounter}_toolbar" class="card-toolbar collapsed">
        <button type="button" class="card-toolbar__color">
        <input type="color" class="ql-color" />
      </button>
      <button type="button" class="ql-bold">
        <i class="fas fa-bold"></i>
      </button>
      <button type="button" class="ql-italic">
        <i class="fas fa-italic"></i>
      </button>
      <button type="button" class="ql-underline">
        <i class="fas fa-underline"></i>
      </button>
      <button type="button" class="ql-strike">
        <i class="fas fa-strikethrough"></i>
      </button>
      <button type="button" class="ql-script" value="sub">
        <i class="fas fa-subscript"></i>
      </button>
      <button type="button" class="ql-script" value="super">
        <i class="fas fa-superscript"></i>
      </button>
      <button type="button" class="ql-link" type="button">
        <i class="fas fa-link"></i>
      </button>
      <button type="button" type="button" class="equation-btn">
        <i class="fas fa-function"></i>
      </button>
    </div>
    <!-- //choice hidden toolbar -->
</div>
<!-- //match item action -->
</div>
<!-- //match item  -->`
  );

  eval(`var opp${matchCounter}= new Quill("#opp${matchCounter}" , {
    theme: 'snow',
    modules: {
      toolbar: "#opp${matchCounter}_toolbar",
    },
    placeholder: '...اكتب السؤال هنا',
  })`);
  eval(
    `let colorinput = document.querySelector('#opp${matchCounter}_toolbar .ql-color')
    colorinput.addEventListener("change", (e) => {
      opp${matchCounter}.format("color", colorinput.value);
    })`
  );
  oppEditors.push(eval(`opp${matchCounter}`));

  // equation
  let editor = document.getElementById(`opp${matchCounter}`).parentElement;
  let target = editor.querySelector(".ql-editor");
  let toolbar = editor.querySelector(".equation-toolbar");
  let btn = editor.querySelector(".equation-btn");
  let dynamic = editor.querySelector(".ql-container").getAttribute("id");
  generateEquationEditor(target, toolbar, "ar", dynamic);
  btn.addEventListener("click", (e) => {
    toggleBtns(btn, "#equation-choice .equation-toolbar", editor);
  });
}

editors = document.querySelectorAll(".match-item");
openBtn = document.getElementById("equationEditor");
if (editors) {
  editors.forEach((editor) => {
    let target = editor.querySelector(".ql-editor");
    let toolbar = editor.querySelector(".equation-toolbar");
    let btn = editor.querySelector(".equation-btn");
    let dynamic = editor.querySelector(".ql-container").getAttribute("id");
    generateEquationEditor(target, toolbar, "ar", dynamic);
    btn.addEventListener("click", (e) => {
      toggleBtns(btn, "#equation-choice .equation-toolbar", editor);
    });
  });
}
