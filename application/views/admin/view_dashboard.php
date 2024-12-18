<style>
    .canvasjs-chart-credit{
        display:none;
    }
</style>
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="clearfix"></div>
            <div class="sec-title">
                <h2><?php echo lang( 'dash_reg'); ?> </h2>
            </div>
            <?php
                
                  
                    $dataPoints = array();
                    foreach($school as $Key=>$item){
                            $SchoolId      = $item->SchoolId;
                            $SchoolName    = $item->SchoolName;
                            $schoolCount   = $this->Report_Register_model->get_school_total($SchoolId,$type);
                            $dataPoints[]  = array("y" =>$schoolCount,"a" =>$schoolCount, "label" => $SchoolName, "z" => $total_new['total_new'], "n"=>$schoolCount);
                        }
                        foreach ($dataPoints as $key => $row) {
                        $return_fare[$key]  = $row['y'];
                        }
                        array_multisort($dataPoints, $return_fare,SORT_DESC);
                    ?>
                    
                    <p style="font-size: 1.5em;"><?= lang('Total number of orders')."  : " .$total_new['total_new']; ?></p>
                    
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<script>
window.onload = function() {

  var dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;
  var minValue = Math.min(...dataPoints.map(point => point.y)); // Calculate the minimum value
  var maxValue = Math.max(...dataPoints.map(point => point.y)); // Calculate the maximum value
  var range = maxValue - minValue; // Calculate the range of values
  var interval = Math.ceil(range / dataPoints.length); // Calculate the interval dynamically

  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title: {
      text: "<?= lang('am_admission');?>"
    },
    axisY2: {
      title: "<?= lang('am_num_student');?>",
      minimum: 0, // Start the y-axis from 0
      interval: interval // Set the interval dynamically
    },
    data: [{
      type: "column",
      axisYType: "secondary",
      yValueFormatString: "#,##0.##",
      toolTipContent: "<b>{label}</b>: {a} من {z}",
      indexLabel: "{a}",
      indexLabelPlacement: "outside",
      indexLabelFontWeight: "bolder",
      indexLabel: "{n}",
      indexLabelPlacement: "inside",
      indexLabelFontWeight: "bolder",
      indexLabelFontColor: "white",
      dataPoints: dataPoints
    }]
  });
  chart.render();

}
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
