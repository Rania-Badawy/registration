<div class="exam-toolbar">
    <div class="exam-name"><?php echo $test_data['Name']; ?> </div>
    <div class="vr"></div>
    <div id="toolbar">
      <input type="color" class="ql-color" />
      <div class="vr"></div>
      <button class="ql-bold">
        <i class="fas fa-bold"></i>
      </button>
      <button class="ql-italic">
        <i class="fas fa-italic"></i>
      </button>
      <button class="ql-underline">
        <i class="fas fa-underline"></i>
      </button>
      <button class="ql-strike">
        <i class="fas fa-strikethrough"></i>
      </button>
      <button class="ql-script" value="sub">
        <i class="fas fa-subscript"></i>
      </button>
      <button class="ql-script" value="super">
        <i class="fas fa-superscript"></i>
      </button>
      <button class="ql-link" type="button">
        <i class="fas fa-link"></i>
      </button>
    </div>
    <div class="vr"></div>
    <button class="equitions-modal-button" id="equationEditor"><?php echo lang("Equation_Editor"); ?></button>
  </div>