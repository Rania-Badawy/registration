<div class="drawer">
              <div class="drawer__header">
                <div class="drawer__toolbar flexbox align-between">
                  <div>
                    <a class="item item-image-btn far fa-image">
                      <?php echo lang("image"); ?>
                      <input type="file" name="draw-image" />
                    </a>
                    <a href="#" class="item item-blank-btn far fa-rectangle-landscape"> <?php echo lang("emptiness"); ?></a>
                    <!--<a href="#" class="item item-graph-btn fas fa-analytics"><?php echo lang("Graph"); ?></a>-->
                  </div>
                  <div class="flexbox">
                    <a href="#" id="pen" class="item fas fa-pencil"> </a>
                    <a href="#" id="clear" class="item fas fa-trash"> </a>
                    <div class="item">
                      <input id="color" type="color" class="item" />
                    </div>
                    <a href="#" id="eraser" class="item fas fa-eraser"> </a>
                    <a href="#" id="redo" class="item fas fa-redo"> </a>
                    <a href="#" id="undo" class="item fas fa-undo"> </a>
                  </div>
                </div>
              </div>
              <div class="drawer__body" id="drawer">
                <div id="tui-image-editor"></div>
                <!--<div class="cursor"></div> -->
                <div class="drawer__placeholder">
                  <?php echo lang("draw_hint"); ?>
                </div>
                <a href="#" class="btn primary outline" id="try_blank"> <?php echo lang("try_yourself"); ?> </a>
              </div>
            </div>