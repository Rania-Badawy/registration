let colorinput = document.querySelector(".ql-color");
colorinput?.addEventListener("change", (e) => {
  quill.format("color", e.target.value);
});

function insertChoiceImage(e) {
  let id = e.getAttribute("data-id");
  getBase64(e.files[0]).then((data) => {
    if (document.getElementById(`choice${id}`)) {
      let index = choicesEditors.findIndex(
        (e) => e.container.id == `choice${id}`
      );
      choicesEditors[index]?.insertEmbed(10, "image", data);
	  document.getElementById('hidImg'+id).value = data;

    } else {
      eval(id).insertEmbed(10, "image", data);
    }
  });
}
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
function insertChoice(e) {
  if (choicesEditors.length < 5) {
    e.target.insertAdjacentHTML(
      "beforebegin",
      `<div class="choice">
    <input type="radio" name="answer" checked />
  <div id="choice${counter}"></div>
  <div class="choice__action">
  <button type="button" class="editor-image">
  <input type="file" onchange="insertChoiceImage(this)" data-id="${counter}" />
  <i class="fas fa-image"></i>
  </button>
  <button type="button" data-id="${counter}" onclick="removeChoice(this)">
  <i class="fas fa-trash"></i>
  </button>
  <button class="card-toolbar__btn" data-id="choice${counter}_toolbar" onclick="showCardToolbar(this)" type="button">
    <i class="fas fa-font"></i>
  </button>
  <div class="equation-toolbar" style="display: none"></div>
  <!-- choice hidden toolbar -->
  <div id="choice${counter}_toolbar" class="card-toolbar collapsed">
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
</div>`
    );

    eval(`var choice${counter}= new Quill("#choice${counter}" , {
      modules: {
        toolbar: "#choice${counter}_toolbar",
      },
    placeholder: '...اكتب الاختيار هنا',
  })`);
    eval(
      `let colorinput = document.querySelector('#choice${counter}_toolbar .ql-color')
      colorinput.addEventListener("change", (e) => {
        choice${counter}.format("color", colorinput.value);
      })`
    );
    // equation
    let editor = document.getElementById(`choice${counter}`).parentElement;
    let target = editor.querySelector(".ql-editor");
    let toolbar = editor.querySelector(".equation-toolbar");
    let btn = editor.querySelector(".equation-btn");
    let dynamic = editor.querySelector(".ql-container").getAttribute("id");
    // let tbSelector = `"#choice${counter} .equation-toolbar"`;
    generateEquationEditor(target, toolbar, "ar", dynamic);
    btn.addEventListener("click", (e) => {
      editor.setAttribute("id", "equation-choice");
      toggleBtns(btn, "#equation-choice .equation-toolbar", editor);

      // toolbar.querySelector("#editorIcon").click();
    });

    choicesEditors?.push(eval(`choice${counter}`));
    counter++;
  }
}
function removeChoice(e) {
  let id = e.getAttribute("data-id");
  if (document.getElementById(`choice${id}`)) {
    if (choicesEditors.length > 2) {
      let index = choicesEditors.findIndex(
        (e) => e.container.id == `choice${id}`
      );
      choicesEditors.splice(index, 1);
      document.getElementById(`choice${id}`).parentElement.remove();
    }
  } else {
  }
}
let insertChoiceBtn = document.getElementById("insertChoice");

insertChoiceBtn?.addEventListener("click", (e) => {
  e.preventDefault();
  e.stopPropagation();
  insertChoice(e);
});

function showCardToolbar(btn) {
  let id = btn.getAttribute("data-id");
  let btns = document.querySelectorAll(".card-toolbar__btn");
  let toolbars = document.querySelectorAll(".card-toolbar");
  let activeToolbar = document.getElementById(id);
  if (activeToolbar.classList.contains("collapsed")) {
    toolbars.forEach((toolbar, i) => {
      btns[i].classList.remove("active");
      toolbar.classList.add("collapsed");
    });
    activeToolbar.classList.remove("collapsed");
    btn.classList.add("active");
  } else {
    activeToolbar.classList.add("collapsed");
    btn.classList.remove("active");
  }
}
/**
 * equation
 */
//
//
let mainEditor = document.getElementById("editor")?.querySelector(".ql-editor");
let toolbarLocation = document.getElementById("toolbarLocation");
if (mainEditor) {
  generateEquationEditor(mainEditor, toolbarLocation, "ar");
}

let editors = document.querySelectorAll(".choice");
let openBtn = document.getElementById("equationEditor");
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
openBtn?.addEventListener("click", (e) => {
  toggleBtns(e.target, "#toolbarLocation");
});
function openEquationEditor(tb, type) {
  let toolbar = document.querySelector(tb);
  if (type == "math") {
    toolbar.querySelector("#editorIcon").click();
  } else {
    toolbar.querySelector("#chemistryIcon").click();
  }
}
function toggleBtns(element, tb, editor) {
  document.querySelectorAll(".equation-btn")?.forEach((el) => {
    el.classList.remove("active");
  });
  document.getElementById("equation_editor_option")?.remove();
  document.getElementById("equation-choice")?.setAttribute("id", "");

  editor?.setAttribute("id", "equation-choice");
  element.classList.toggle("active");
  if (element.classList.contains("active"))
    element.insertAdjacentHTML(
      "afterend",
      `
      <div id="equation_editor_option">
    <button type="button" onclick="openEquationEditor('${tb}','math')" class="btn-icon outline fas fa-square-root"></button>
    <button type="button" onclick="openEquationEditor('${tb}')" class=" btn-icon outline fas fa-atom"></button>
    </div>
  `
    );
  else {
    document.getElementById("equation_editor_option").remove();
    editor?.setAttribute("id", "");
  }
}

function generateEquationEditor(target, toolbar, language, dynamic = "") {
  let properties = {
    target,
    toolbar,
    language,
  };

  eval(
    `window.wiris_generic${dynamic} = new WirisPlugin.GenericIntegration(properties)`
  );
  eval(`window.wiris_generic${dynamic}.init()`);
  eval(`window.wiris_generic${dynamic}.listeners.fire("onTargetReady", {})`);
  eval(`WirisPlugin.currentInstance = window.wiris_generic${dynamic}`);
}
