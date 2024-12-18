<?php
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 50; URL=$url1");
?>
<style>
@media print
{
    html
    {
        zoom: 60%;
    }
    .flexbox{
     display:none; 
} 

}
.swal-overlay{
        position: absolute;
    
}
</style>

<!-- Page Head -->
 <script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">

    var tableToExcel = (function () {
        // Define your style class template.
        var style = "<style>.modal-content{display: none !important;}</style>";
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->' + style + '</head><body><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
            , format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; })
            }
             
        return function (table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
            window.location.href = uri + base64(format(template, ctx))
            
        }
    })()
</script>            
                <div class="page-head container-fluid pt30">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                       <a href="<?php echo site_url('/emp/cpanel');?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                        <span><?php echo lang('br_zoom');?>  </span>
                        <span><?php echo lang('br_zoom_classtable');?>  </span>
                    </div>
                    <!-- Title -->
                    <h1><?php echo lang('br_zoom_classtable');?> </h1>
                </div>
                <!-- // Page Head -->
                <div class="flexbox table-action-btns">
                    <div class="flexbox table-action-btns mb0i">
                    
                        <input class="btn small success rounded btn-icon fal fa-file-excel" type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Excel" />
        
                        <button type="button" id="print" class="btn small pink-bg rounded btn-icon fal fa-print" >print</button>
                
                    </div>
                </div>
                <!-- Sessions Wraper -->
                
                    <!--<div class="responsive-table" id="printTable">-->
                    <div class="blockvirtualtable" style="overflow-x:auto;background-color: white;"  >
                    <table class="table bordered striped weakly-table data-table-ex" id="testTable">
                        <!-- Table Head -->
                        <thead class="pink-bg">
                            <tr class="tx-align-center">
                                
                                <th rowspan="1" colspan="1"><?php echo lang('br_day');?></th>
            					 <?php if($type == 1){?>
			                     <th colspan="8"><?php echo lang('na_table_sum_course');?></th>
			                     <?php }else{?>
			                     <th colspan="8"><?php echo lang('br_zoom_classtable');?></th>
			                     <?php } ?>
            				
                            </tr>
                        </thead>
                       <?php foreach($getDay as$k=>$item){?>
				   <tr>
					<th><?=$item->DayName?></th>
				
			         <?php $i=0;?>
				    <?php foreach($all_data as$k=>$item1){
				    if($item->Name==$item1->DayName){
				        $i++
				    ?>
					<td>
					    <?php 
					    list(,, $strData) = preg_split("~/~",$item1->MeetingTopic );
					    echo $strData;
					    $arr = explode("/", $item1->MeetingTopic, 2);
					    ?>
					    
						<h3><?=$arr[0];?></h3> 
					    
					    <span><?php echo lang('br_from');?>:<?=date('H:i',strtotime($item1->MeetingStartTime));?></span><span>: <?php echo lang('br_to');?> :<?=date('H:i',strtotime($item1->MeetingEndTime));?></span>
					    
					    
					    <?php 
					     $starttime = date('Y-m-d H:i:s',strtotime($item1->MeetingStartTime));
					     $endTime = date('Y-m-d H:i:s',strtotime($item1->MeetingEndTime));
					     if($endTime>$date&&$date>$starttime){?>
						   <br><a href="<?php echo site_url('emp/zoom/user_attend/' . $item1->meeting_id .'/'. $item1->MeetingId .'/'. $item1->MeetingEndTime) ?>" style="width:100px" class="btn small success rounded block-lvl"><?php echo lang('br_join');?></a>
					      <?php } else if($endTime<$date){ ?>
							<br><a href="" style="width:100px" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_finished');?></a>
						<?php } else if($starttime>$date){ ?>
							<br><a href="" style="width:100px" class="btn small gray rounded block-lvl" disabled><?php echo lang('br_cant_start');?></a>
						<?php } ?>
					</td>
					<?php } 
					 }?>
					 <?php
                        for ($x = $i; $x <8; $x++) {?>
                        <td>  ... </td>
                       <?php }
                        ?>
				</tr>
			
				
				<?php } ?>	
				
			</table>
                </div>
                <!-- // Classes Table -->
            </div>
            <!-- // Page Wraper -->
        </div>