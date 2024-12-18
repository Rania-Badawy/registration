const drawer = document.getElementById("drawer");
const rect = drawer.getBoundingClientRect();

let items = document.querySelectorAll(".item");

let graphBtn = document.querySelector(".item-graph-btn");
let blankBtn = document.querySelector(".item-blank-btn");
let tryBlank = document.getElementById("try_blank");
let imageBtn = document.querySelector(".item-image-btn");

let penBtn = document.getElementById("pen");
let clearBtn = document.getElementById("clear");
let colorBtn = document.getElementById("color");
let eraserBtn = document.getElementById("eraser");
let undoBtn = document.getElementById("undo");
let redoBtn = document.getElementById("redo");

// shapes
let shapesBtns = document.querySelectorAll(".shape");
let strokeRange = document.getElementById("stroke-range");
let shapeFill = document.getElementById("shape_fill");
let shapeStroke = document.getElementById("shape_stroke");

let activeObj = {};
// let lineWidth = document.getElementById('line_width');
let lineWidth = 5;

const imageEditor = new tui.ImageEditor(
  document.querySelector("#tui-image-editor"),
  {
    cssMaxWidth: rect.width,
    cssMaxHeight: rect.height,
    height: rect.height,
    width: rect.width,
    selectionStyle: {
      cornerSize: 20,
      rotatingPointOffset: 70,
    },
  }
);
resizeing();
function resizeing() {
  imageEditor._graphics._canvas.width = rect.width;
  imageEditor._graphics._canvas.height = rect.height;
  let cs = ["contextContainer", "contextTop", "contextCache"];
  cs.forEach((c) => {
    imageEditor._graphics._canvas[c].canvas.width = rect.width;
    imageEditor._graphics._canvas[c].canvas.height = rect.height;
  });
}
penBtn.addEventListener("click", draw);
shapesBtns.forEach((btn) => btn.addEventListener("click", addShape));
// strokeRange.addEventListener("change", strokeRangeChange);
shapeFill?.addEventListener("input", shapeFillColor);
shapeStroke?.addEventListener("input", shapeStrokeColor);
colorBtn.addEventListener("change", changeColor);
clearBtn.addEventListener("click", clearAll);
eraserBtn.addEventListener("click", erase);
undoBtn.addEventListener("click", undo);
redoBtn.addEventListener("click", redo);

function removeActiveItem(target) {
  items.forEach((i) => {
    i.classList.remove("active");
  });
  target.classList.add("active");
}

function draw(e) {
  e.preventDefault();
  imageEditor.setBrush({
    width: lineWidth,
    color: colorBtn.value,
  });
  imageEditor.startDrawingMode("FREE_DRAWING", {
    width: lineWidth,
    color: colorBtn.value,
  });
  removeActiveItem(e.target);
}
// const shapeProps= {
//   fill: ,
//   stroke: ,
//   strokeWidth: ,
//   width: ,
//   height: ,
//   rx: ,
//   ry: ,
//   isRegular: ,
// }
function addShape(e) {
  e.preventDefault();
  // removeActiveItem(e.target);
  imageEditor.stopDrawingMode();
  const type = e.target.getAttribute("data-id");
  const dimensions =
    type == "circle"
      ? { rx: 40, ry: 40 }
      : {
          width: 70,
          height: 70,
        };
  if (type == "line") {
    imageEditor.startDrawingMode("LINE_DRAWING", {
      width: 5,
      color: shapeStroke.value,
      arrowType: {},
    });
  } else {
    imageEditor
      .addShape(type, {
        fill: shapeFill.value,
        stroke: shapeStroke.value,
        strokeWidth: 5,
        isRegular: false,
        ...dimensions,
      })
      .then((objectProps) => {
        console.log(objectProps.id);
        // if (!activeObj[objectProps.id]) activeObj[objectProps.id] = objectProps;
      });
  }
}
detectingChanges();

function detectingChanges() {
  imageEditor.on("objectActivated", function (props) {
    Object.keys(props).forEach((obj) => {
      activeObj[obj] = props[obj];
    });
    console.log(activeObj);
  });
}
function strokeRangeChange(e) {
  let stroke = e.target.value;
  setObjProps(activeObj.id, {
    strokeWidth: stroke,
  });
  // activeObj.forEach(item=> console.log(item))
}
function setObjProps(id, props) {
  imageEditor.setObjectProperties(id, props);
}
function shapeFillColor(e) {
  console.log(e.target.value);
  setObjProps(activeObj.id, {
    fill: e.target.value,
  });
}
function shapeStrokeColor(e) {
  setObjProps(activeObj.id, {
    stroke: e.target.value,
  });
}
function clearAll(e) {
  e.preventDefault();
  removeActiveItem(e.target);
  imageEditor.clearObjects();
}
function erase(e) {
  e.preventDefault();
  imageEditor.startDrawingMode("FREE_DRAWING");
  imageEditor.setBrush({
    width: 5,
    color: "FFFFFF",
  });
  removeActiveItem(e.target);
}
function undo(e) {
  e.preventDefault();
  imageEditor.undo();
  removeActiveItem(e.target);
  imageEditor.stopDrawingMode();
}
function redo(e) {
  e.preventDefault();
  imageEditor.redo();
  removeActiveItem(e.target);
  imageEditor.stopDrawingMode();
}
function changeColor(e) {
  e.preventDefault();
  imageEditor.setBrush({
    width: lineWidth,
    color: e.target.value,
  });
  removeActiveItem(e.target);
}

blankBtn?.addEventListener("click", loadBlank);
tryBlank?.addEventListener("click", loadBlank);
graphBtn?.addEventListener("click", loadGraph);
imageBtn?.querySelector("input").addEventListener("change", loadImage);

function loadGraph(e) {
  e.preventDefault();
  if (!drawer.classList.contains("active")) {
    drawer.classList.add("active");
  }

  imageEditor
    .loadImageFromURL("../../img/graph.png", "graph")
    .then((result) => {});
  imageEditor.startDrawingMode("LINE_DRAWING", {
    width: lineWidth,
    color: colorBtn.value,
    arrowType: {},
  });
}

function loadImage(e) {
  e.preventDefault();
  if (!drawer.classList.contains("active")) {
    drawer.classList.add("active");
  }
  let file = e.target.files[0];
  imageEditor.loadImageFromFile(file, "image").then((result) => {});
}
function loadBlank(e) {
  e.preventDefault();
  if (!drawer.classList.contains("active")) {
    drawer.classList.add("active");
  }
  imageEditor
    .loadImageFromURL("../../img/blank.png", "blank")
    .then((result) => {
      resizeing();
    });
  imageEditor.startDrawingMode("FREE_DRAWING", {
    width: lineWidth,
    color: colorBtn.value,
  });
  clearAll(e);
}
function Base64ToImage(base64img, callback) {
  var img = new Image();
  img.onload = function () {
    callback(img);
  };
  img.src = base64img;
}
function saveImage_am() {
 /* var imageName = imageEditor.getImageName();
  var dataURL = imageEditor.toDataURL(); // you save file as base
  console.log("this is image as base64:>", dataURL);
  fetch(dataURL)
    .then((res) => res.blob())
    .then((blob) => {
      const file = new File([blob], imageName, {
        type: "image/png",
      });
      console.log("this is file:> ", file);
    });*/
     var imageName = "image.png";
  var dataURL = imageEditor.toDataURL(); // you save file as base
    var block = dataURL.split(";");
    var contentType = block[0].split(":")[1];
    var realData = block[1].split(",")[1];
        contentType = contentType || '';
        var sliceSize =  512;

        var byteCharacters = atob(realData);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

      var blob = new Blob(byteArrays, {type: contentType});
       const file = new File([blob], imageName, {
        type: "image/png",
      });
      console.log("this is file:> ", file);
      return file;
}
