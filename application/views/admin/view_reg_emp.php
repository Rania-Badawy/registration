	<div class="content margin-top-none container-page">  

       <div class="col-lg-12">

 <div class="block-st">

				<div class="sec-title">

				 <h2>  <?php echo lang('Service_representatives_ratings') ?> </h2>

				</div>
				<div  class="panel panel-danger">



 

				<div class="panel-body no-padding" id="print_div" >

<table id="example" class="display table table-bordered" width="100%" cellspacing="0" >

<thead>

 <tr>

       <th >     #   </th>
       <th >  <?php echo lang('service representative') ?>  </th>
       <th>   <?php echo lang('New_Regestration') ?> </th>
       <th>  <?php echo lang('Under know requests') ?> </th>
       <th> <?php echo lang('requests expired') ?>   </th>
       <th> <?php echo lang('Total number of orders') ?> </th>
       <th>  <?php echo lang('Completion rate') ?>   </th>
       <th><?php echo lang('delay rate') ?>  </th>
      
 </tr>

</thead>

<tbody>

           <?php 
           if($record){
           foreach( $record as  $Key=>$re )
             {
                 $Num= $Key+1 ; 
                 $ID            = $re->ID;
                 $Get_new       = $this->Report_Register_model->Get_total_new($ID,2);
                 $Get_underwork =$this->Report_Register_model->Get_total_underworking($ID);
                 $Get_finshed   =$this->Report_Register_model->Get_total_finshed($ID);
                 $total_new     = $Get_new['total_new'] ;
                 $totalUw       = $Get_underwork['totalUw'];
                 $total_finshed = $Get_finshed['total_finshed'];
                 $total = $total_new +$totalUw +$total_finshed;
             ?>

		<tr>

      <td>   <?php echo $Num ; ?>  </td>
      <td>   <?php echo $re->Name  ; ?> </td>
      <td>   <?php echo $Get_new['total_new'] ;  ?> </td>
      <td>   <?php echo $Get_underwork['totalUw'] ;   ?>                 </td>
      <td>   <?php echo $Get_finshed['total_finshed'] ;?></td>
      <td>   <?php echo $total ;?>  </td>
      <td>   <?php if($total) echo  substr(($Get_finshed['total_finshed']/ $total) *100 ,0,5)."%"     ;?>  </td>
      <td>    <?php if($total) echo substr(($Get_new['total_new'] / $total )  *100 ,0,5) ."%"       ;?>     </td>
      </tr>

		

		<?php 

	}}

	?>

</tbody>

	 </table>

     </div>

     </div>

 </div>

 <div class="clearfix"></div>

 </div>

 <div class="clearfix"></div>

</div>