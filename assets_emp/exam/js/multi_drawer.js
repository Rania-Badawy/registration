const lineWidth = 5;  
const imageEditors = {};
const drawers = document.querySelectorAll('.drawer');
const shapesBtns = document.querySelectorAll(".shape");
let activeObj = {};
let items = document.querySelectorAll(".item");

drawers.forEach(drawer => {
    const qId = drawer.getAttribute('id').split('_')[1];
    const drawerElement = document.querySelector(`#drawer_${qId}`);
    const rect = drawerElement.getBoundingClientRect();

    imageEditors[qId] = new tui.ImageEditor(
        document.querySelector(`#tui-image-editor_${qId}`),
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

    const imageEditor = imageEditors[qId];
    

    document.getElementById(`shape_fill_${qId}`).addEventListener('change', (e) => shapeFillColor(e, imageEditor));
    document.getElementById(`shape_stroke_${qId}`).addEventListener('change', (e) => shapeStrokeColor(e, imageEditor));
    document.getElementById(`eraser_${qId}`).addEventListener('click', (e) => erase(e, imageEditor));
    document.getElementById(`pen_${qId}`).addEventListener('click', () => draw(imageEditor, qId));
    document.getElementById(`clear_${qId}`).addEventListener('click', () => clearAll(imageEditor));
    document.getElementById(`undo_${qId}`).addEventListener('click', () => undo(imageEditor));
    document.getElementById(`redo_${qId}`).addEventListener('click', () => redo(imageEditor));
    document.getElementById(`color_${qId}`).addEventListener('change', (e) => changeColor(e, imageEditor));

    resizeImageEditor(imageEditor, rect);
    
    detectingChanges(imageEditor);
});

shapesBtns.forEach((btn) => {
    const qId = btn.closest('.drawer').getAttribute('id').split('_')[1];
    btn.addEventListener("click", (e) => addShape(e, qId));
});

function draw(editor, qId) {
    editor.setBrush({
        width: lineWidth,
        color: document.getElementById(`color_${qId}`).value,
    });
    editor.startDrawingMode("FREE_DRAWING", {
        width: lineWidth,
        color: document.getElementById(`color_${qId}`).value,
    });
}

function resizeImageEditor(editor, rect) {
    editor._graphics._canvas.width = rect.width;
    editor._graphics._canvas.height = rect.height;
    ["contextContainer", "contextTop", "contextCache"].forEach((c) => {
        editor._graphics._canvas[c].canvas.width = rect.width;
        editor._graphics._canvas[c].canvas.height = rect.height;
    });
}

function clearAll(editor) { editor.clearObjects(); }
function undo(editor) { editor.undo(); editor.stopDrawingMode(); }
function redo(editor) { editor.redo(); editor.stopDrawingMode(); }
function changeColor(e, editor) {
    editor.setBrush({
        width: lineWidth,
        color: e.target.value,
    });
}

function addShape(e, qId) {
    e.preventDefault();

    const imageEditor = imageEditors[qId];

    if (!imageEditor) {
        console.error(`No imageEditor found for question ID ${qId}`);
        return;
    }

    // Assuming shapeFill and shapeStroke are input elements, select them
    const shapeFill = document.getElementById(`shape_fill_${qId}`);
    const shapeStroke = document.getElementById(`shape_stroke_${qId}`);
    
    imageEditor.stopDrawingMode();  // Stop drawing mode before adding shape

    const type = e.target.getAttribute("data-id");  // Get shape type (circle, rect, etc.)
    let shapeOptions;

    // Define shape dimensions and options based on type
    if (type === "circle") {
        shapeOptions = {
            fill: shapeFill.value,  
            stroke: shapeStroke.value,  
            strokeWidth: 5,
            rx: 40,  // Circle radius
            ry: 40   // Circle radius
        };
    } else if (type === "rect") {
        shapeOptions = {
            fill: shapeFill.value,
            stroke: shapeStroke.value,
            strokeWidth: 5,
            width: 70,  
            height: 70
        };
    } else if (type === "triangle") {
        shapeOptions = {
            fill: shapeFill.value,
            stroke: shapeStroke.value,
            strokeWidth: 5,
            width: 70,
            height: 70
        };
    } else if (type === "line") {
        // For lines, set line drawing mode
        imageEditor.startDrawingMode("LINE_DRAWING", {
            width: 5,
            color: shapeStroke.value,
            arrowType: {}  // Optionally add arrow properties
        });
        return;  // Exit function as we're in line mode
    }

    // Adding the shape to the image editor
    imageEditor.addShape(type, shapeOptions)
        .then((objectProps) => {
            // console.log("Shape added with ID:", objectProps.id);
        })
        .catch((err) => {
            // console.error("Error adding shape:", err);
        });
}

function detectingChanges(imageEditor) {
  imageEditor.on("objectActivated", function (props) {
    Object.keys(props).forEach((obj) => {
      activeObj[obj] = props[obj];
    });
    console.log(activeObj);
  });
}

function strokeRangeChange(e, imageEditor) {
  let stroke = e.target.value;
  setObjProps(activeObj.id, { strokeWidth: stroke }, imageEditor);
}

function setObjProps(id, props, imageEditor) {
  imageEditor.setObjectProperties(id, props);
}

function shapeFillColor(e, imageEditor) {
  // Check if e and e.target are valid
  if (e && e.target) {
    const fillColor = e.target.value; // Make sure e.target is the correct element
    console.log(fillColor);
    setObjProps(activeObj.id, { fill: fillColor }, imageEditor);
  } else {
    console.error('Event or target is not defined:', e);
  }
}

function shapeStrokeColor(e, imageEditor) {
  if (e && e.target) {
    setObjProps(activeObj.id, { stroke: e.target.value }, imageEditor);
  } else {
    console.error('No valid event object or target');
  }
}

function erase(e, imageEditor) {
  e.preventDefault(); // Prevent default action of the event (if any)

  // Start free drawing mode for erasing
  imageEditor.startDrawingMode("FREE_DRAWING");

  // Set the brush to act as an eraser
  imageEditor.setBrush({
    width: 5,
    color: "#FFFFFF", // Use # to specify the color
  });

  // Optionally, you can remove active item or perform other actions
  removeActiveItem(e.target);
}
function removeActiveItem(target) {
  items.forEach((i) => {
    i.classList.remove("active");
  });
  target.classList.add("active");
}

function saveImage_am(qId) {
    const imageEditor = imageEditors[qId]; // Retrieve the specific editor instance
    if (!imageEditor) {
        console.error(`No image editor found for question ID: ${qId}`);
        return null; // Return null or handle the error as needed
    }
    
    var imageName = "image.png";
    var dataURL = imageEditor.toDataURL(); // Save file as base64
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