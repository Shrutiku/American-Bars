<style>
.padding-0{ padding:0 !important;}
@media (max-width:767px){
.marlr25.respo-margin{ margin-left:0 !important;}
}
</style>
<div class="padtb">
<!--	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Select Day: </label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                       			<select class="select_box" id="day" name="day" onchange="getBarSpecialHours(this.value)">
	                       				<option <?php echo $cur=="Monday" ? 'selected':'';?> value="Monday">Monday</option>
	                       				<option <?php echo $cur=="Tuesday" ? 'selected':'';?> value="Tuesday">Tuesday</option>
	                       				<option <?php echo $cur=="Wednesday" ? 'selected':'';?> value="Wednesday">Wednesday</option>
	                       				<option <?php echo $cur=="Thursday" ? 'selected':'';?> value="Thursday">Thursday</option>
	                       				<option <?php echo $cur=="Friday" ? 'selected':'';?> value="Friday">Friday</option>
	                       				<option <?php echo $cur=="Saturday" ? 'selected':'';?> value="Saturday">Saturday</option>
	                       				<option <?php echo $cur=="Sunday" ? 'selected':'';?> value="Sunday">Sunday</option>
	                       				<option  <?php echo $cur=="viewall" ? 'selected':'';?> value="viewall">View All</option>
	                       			</select>
														
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		</div>	
-->

<?php if($getbarhour){
	
	 foreach($getbarhour as $row1)
	   { ?>
<?php	if ($row1->day_from == "Everyday") {    ?>
            <li><h3><?php echo "<span class='yellow_text'></span>" . $row1->day_from; ?> <span class='yellow_text'> · </span> <?php echo $row1->hour_from ." - ". $row1->hour_to; ?></h3><br>
<?php   }  else {   ?>
            <li><h3><?php echo "<span class='yellow_text'></span>" . $row1->day_from . " - " . $row1->day_to; ?> <span class='yellow_text'> · </span> <?php echo $row1->hour_from ." - ". $row1->hour_to; ?></h3><br> 	
<?php   } ?>
             
<?php		$getbarhourrand = $this->bar_model->getBarHappyHoursByRAND($row1->rand);
	   	
		//echo $row->rand;
		
		if($getbarhourrand){
	
	 foreach($getbarhourrand as $row)
	   {
		?>
	   	
	   	<?php 
	   	
	   	switch ($row->cat){
			case "beer":
				if($row->sp_beer_id!=0 && $row->sp_beer_id!='')
				{
					if(strlen($row->beer_name)>30)
					{
						$bn = substr($row->beer_name, 0 , 30)."...";
					}
					else
					{
						$bn = $row->beer_name;
					}	
					if($row->sp_beer_price!=''){
//                				echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Beer Name :</span><a href='".site_url("beer/detail/".$row->beer_slug)."'>" .$bn. "</a></div><div class=' col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>Price : </span> $ $row->sp_beer_price </div><div class='clearfix'></div></div><br>";
                                                echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1f37a;  </span><a href='".site_url("beer/detail/".$row->beer_slug)."'>" .$bn. "</a></div><div class=' col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>$ $row->sp_beer_price </span> </div><div class='clearfix'></div></div><br>";
				
                                        }else {
                                            echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1f37a;  </span><a href='".site_url("beer/detail/".$row->beer_slug)."'>" .$bn. "</a></div><div class='clearfix'></div></div><br>";
                                        }
                                }
				break;
				
			case "cocktail":
				if($row->sp_cocktail_id!=0 && $row->sp_cocktail_id!='')
				{
					if(strlen($row->cocktail_name)>30)
					{
						$cn = substr($row->cocktail_name, 0 , 30)."...";
					}
					else
					{
						$cn = $row->cocktail_name;
					}
                                        if($row->sp_cocktail_price!=''){
//                                                    echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Cocktail Name :</span><a href='".site_url("cocktail/detail/".$row->cocktail_slug)."'>" .$cn. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>Price : </span> $ $row->sp_cocktail_price </div><div class='clearfix'></div></div><br>";
                                                    echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1f378;  </span><a href='".site_url("cocktail/detail/".$row->cocktail_slug)."'>" .$cn. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>$ $row->sp_cocktail_price </span> </div><div class='clearfix'></div></div><br>";
                                        }else {
                                            echo "<div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1f378;  </span><a href='".site_url("cocktail/detail/".$row->cocktail_slug)."'>" .$cn. "</a></div><div class='clearfix'></div></div><br>";
                                        }
                                                    
                                        }	
				break;	
			case "liquor":
				if($row->sp_liquor_id!=0 && $row->sp_liquor_id!='')
				{
					if(strlen($row->liquor_title)>30)
					{
						$ln = substr($row->liquor_title, 0 , 30)."...";
					}
					else
					{
						$ln = $row->liquor_title;
					}	
                                        if($row->sp_liquor_price!=''){
//        						echo "<div><div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Liquor Name :</span><a href='".site_url("liquor/detail/".$row->liquor_slug)."'>" .$ln. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>Price : </span> $ $row->sp_liquor_price </div><div class='clearfix'></div></div><br>";
                                                echo "<div><div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1F943;  </span><a href='".site_url("liquor/detail/".$row->liquor_slug)."'>" .$ln. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>$ $row->sp_liquor_price </span> </div><div class='clearfix'></div></div><br>";
                                        }else {
                                            echo "<div><div style='width:100%;'><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>&#x1F943; </span><a href='".site_url("liquor/detail/".$row->liquor_slug)."'>" .$ln. "</a></div><div class='clearfix'></div></div><br>";
                                        }
                                }	
					
				break;	
			case "food":
			if($row->food_name!='')
			{
                            if($row->food_price!=''){
//					echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Food Name :</span><a>" .$row->food_name. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>Price : </span> $ $row->food_price </div><div class='clearfix'></div></div><br>";
					echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Food: </span><a>" .$row->food_name. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin'>$ $row->food_price </span> </div><div class='clearfix'></div></div><br>";
                            } else {
                                echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Food: </span><a>" .$row->food_name. "</a></div><div class='clearfix'></div></div><br>";
                            }
                                        
                        }	
				break;
			case "other":
			if($row->other_name!='')
                        {
                            if($row->other_price!=''){
  //							echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Other Name :</span><a>" .$row->other_name. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin respo-margin'>Price : </span> $ $row->other_price </div><div class='clearfix'></div></div><br>";
                                          echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Other: </span><a>" .$row->other_name. "</a></div><div class='col-md-4 col-sm-4 padding-0'><span class='yellow_text marlr25 respo-margin respo-margin'>$ $row->other_price </span> </div><div class='clearfix'></div></div><br>";
                            } else {
                                echo "<div><div class='result_search_text col-md-8 col-sm-8 padding-0' style='font-size:15px;'><span class='yellow_text'>Other: </span><a>" .$row->other_name. "</a></div><div class='clearfix'></div></div><br>";
                            }
                                        
                        }
				break;	
		}
	   	?>
	   	
	   	
	  <?php } } } ?> </li><?php 
	
} else {?>
	
<li>No Happy Hours & Specials Found. </li>
<?php } ?>