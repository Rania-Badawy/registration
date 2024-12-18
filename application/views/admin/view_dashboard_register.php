<link rel="stylesheet" href="https://unpkg.com/charts.css/dist/charts.min.css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/new/css/circle.css">
<style>
#column-example-23 {
  height: 200px;
  max-width: 300px;
  margin: 0 auto;
}

@media only screen and (min-width: 800px){
    .main{
        margin: 10px;
        width: 50%;
    }
    .main_div{
        display:flex;
    }
    .box_h{
        display: inline-block;
        width: 49%;
    }
    .cirl{
        margin-right: 25px;
    }
}    
    .conDiv {
        background-color: #f2f2f2;
        border: 2px solid;
        padding: 4px;
        font-size: 24px;
        text-align: center;
    }
    
    .cirl{
        background-color: #f7f5f0;
        min-height: 206px !important;
    }
    .txt{
        font-size: 25px;
        float: left;
        text-align: left;
        width: 50%;
    }
    .c100 {
        float:right;
    }
    <?php if($this->session->userdata('language') != 'english'){?>
        .c100 {
        float:left;}
        
        .txt{
        float: right;
        text-align: right;
        width: 50%;
        }
        .main{
            float: right;
            direction: rtl;
        }
        body{
            direction: rtl;
        }
    }
        <?php }?>
</style>
<div class="main_div">
<div class="block-st main">
    <div style="display: flex;">
        <?php foreach($school as $Key=>$item){
        $ID            = $item->SchoolId;
        $SchoolName    = $item->SchoolName;
        $schoolCount   = $this->Report_Register_model->get_school_total($ID,$type);
       ?>
        <div class="block-st" style="width: 48%;margin: 10px;">
            <table id="column-example-23" class="charts-css column multiple show-labels data-spacing-10 show-primary-axis show-data-axes reverse-datasets">
                <tbody><tr><td style="--size:0.2;"></td><td style="--size:0.5;"></td><td style="--size:1;"></td><td style="--size:0.7;"></td><td style="--size:0.4;"></td></tr></tbody>
            </table>
            <div class="conDiv">
               
                <p><?php echo lang('total_orders') ." ". $SchoolName?></p><p><?php echo $schoolCount ?></p>
            </div>
        </div>
        <?php }?>
    </div>
    <div class="sec-title">
				 <h2>  التقسيم  حسب الحاله</h2>
	</div>
	 <div class="box_h">
        <div class="block-st cirl">
            <div class="c100 p<?php echo (int)100?> green">
                <span><a href="#" ><?php echo substr(100,0,5)?>%</a></span>
                
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            <div class="txt"> <?php echo lang('am_view_all')?> </div>
            <span class="txt"><a href="#"><?php echo $total ?></a></span>
        </div>
    </div>
    <div class="box_h">
        <div class="block-st cirl">
            <?php $percentage  = ($total_new['total_new']/$total)*100?>
            <div class="c100 p<?php echo (int)$percentage?> green">
                <span><a href="#" ><?php echo substr($percentage,0,5)?>%</a></span>
                
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            
            <div class="txt"> <?php echo lang('New_Regestration')?> </div>
            <span class="txt"><a href="#"><?php echo $total_new['total_new'] ?></a></span>
        </div>
    </div>
    <?php 
    if(is_array($reg_type)){
    
    foreach($reg_type as $Key=>$item){
        $ID          = $item->ID;
        $TypeName    = $item->TypeName;
        $statusCount = $this->Report_Register_model->get_status_total($ID);
        $percentage  = ($statusCount/$total)*100
    ?>
    <div class="box_h">
        <div class="block-st cirl">
            <div class="c100 p<?php echo (int)$percentage?> green">
                <span><a href="#" ><?php echo substr($percentage,0,5)?>%</a></span>
                
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            <div class="txt"><?php echo $TypeName; ?></div>
            <span class="txt"><a href="#"><?php echo $statusCount ?></a></span>
        </div>
    </div>
    <?php }} ?>
</div>
<!--chart-->
<div class="block-st main">
    <div style="display: flex;">
       
        <div class="block-st" style="width: 48%;margin: 10px;">
            <table id="column-example-23" class="charts-css column multiple show-labels data-spacing-10 show-primary-axis show-data-axes reverse-datasets">
                <tbody><tr><td style="--size:0.2;"></td><td style="--size:0.5;"></td><td style="--size:1;"></td><td style="--size:0.7;"></td><td style="--size:0.4;"></td></tr></tbody>
            </table>
            <div class="conDiv">
               
                <p><?php echo lang('total_orders')?></p><p><?php echo $total ?></p>
            </div>
        </div>
        <div class="block-st" style="width: 48%;margin: 10px;">
            <table id="column-example-23" class="charts-css column multiple show-labels data-spacing-10 show-primary-axis show-data-axes reverse-datasets">
                <tbody><tr><td style="--size:0.2;"></td><td style="--size:0.5;"></td><td style="--size:1;"></td><td style="--size:0.7;"></td><td style="--size:0.4;"></td></tr></tbody>
            </table>
            <div class="conDiv">
               
                <p> <?php echo lang('total_orders_late')?> </p><p><?php echo (int)$total_late ;?></p>
            </div>
        </div>
      
    </div>
    <br><br>
     <div class="sec-title">
		 <h2>  <?php echo lang('Division by grade level') ?> </h2>
	</div>
	<div class="box_h">
        <div class="block-st cirl">
            <div class="c100 p<?php echo (int)100?> orange">
                <span><a href="#" ><?php echo substr(100,0,5)?>%</a></span>
                
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            <div class="txt"> <?php echo lang('am_view_all')?> </div>
            <span class="txt"><a href="#"><?php echo $total ?></a></span>
        </div>
    </div>
     <?php 
   
    foreach($Level as $Key=>$item){
        $ID           = $item->LevelId;
        $levelName    = $item->LevelName;
        $statusCount  = $this->Report_Register_model->get_level_total($ID,$type);
        $percentage   = ($statusCount/$total)*100
    ?>
    <div class="box_h">
        
        <div class="block-st cirl">
            <div class="c100 p<?php echo (int)$percentage?> orange">
                <span><a href="#"><?php echo substr($percentage,0,5)?>%</a></span>
                  
                <div class="slice">
                 
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
            	
            <div class="txt"><?php echo $levelName; ?></div>
            <span class="txt"><a href="#"><?php echo $statusCount ?></a></span>
        </div>
    </div>
    <?php } ?>
    </div>
   

</div>

   




