
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery-sortable.js"></script>
<style>

	body.dragging, body.dragging * {
  cursor: move !important;
}


tbody.example tr td.placeholder {
  position: relative;
  /** More li styles **/
}
tr.example td.placeholder:before {
  position: absolute;
  /** Define arrowhead **/
}
</style>
<script>
	
$(document).ready(function(){


$('.sorted_table').sortable({
  containerSelector: 'table',
  itemPath: '> tbody',
  itemSelector: 'tr',
  placeholder: '<tr class="placeholder"/>',

  onDrop: function (item, container, _super) {
           // var obj = jQuery('.sorted_table tr').map(function(){
           //     return 'trvalue[]=' + jQuery (this).attr("data-id");
           // }).get();
         
          
          var ids = jQuery('.sorted_table tr').map(function() {
            return $(this).attr("data-id");
        }).get();
         console.log(ids);
          
          
           $.ajax({
                url: "<?php echo site_url('bar/reorder');?>",
                type: "post",
                data: {id:ids},
                cache: false,
                dataType: "json",
                success: function () {}
            });
             $("body").removeClass("dragging");
               $("tr").removeClass("dragged");
          //do the ajax call
        }
})
 
// Sortable column heads


	});
</script>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip gallery"></i> Special Hours</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
		     				
     					
     					
					
				<div id="list_show"  >	
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="product_type" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/bar_special_hours'); ?>" onsubmit="return validate()">
						<form name="add_event" id="product_type" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/bar_special_hours'); ?>" >
					
					<?php // print_r($imageGallery);die;
												if($getbar_hour!=''){
													?>
													<div class="" id="inner">
													<?php $i=0; foreach($getbar_hour as $im){ ?>
														<div id="pi_<?php echo $im->bar_hour_id ?>">	
															<input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="<?php echo $im->bar_hour_id; ?>" />
															<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Days : <span class="aestrick"> * </span></label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                       			<select required name="days[]" id="days<?php echo $im->bar_hour_id; ?>" class="select_box">
	                       				<option value="">-- Select Day-- </option>
	                       				<option value="Monday" <?php echo $im->days=="Monday" ? 'selected':'';?>>Monday</option>
	                       				<option value="Tuesday" <?php echo $im->days=="Tuesday" ? 'selected':'';?>>Tuesday</option>
	                       				<option value="Wednesday" <?php echo $im->days=="Wednesday" ? 'selected':'';?>>Wednesday</option>
	                       				<option value="Thursday" <?php echo $im->days=="Thursday" ? 'selected':'';?>>Thursday</option>
	                       				<option value="Friday" <?php echo $im->days=="Friday" ? 'selected':'';?>>Friday</option>
	                       				<option value="Saturday" <?php echo $im->days=="Saturday" ? 'selected':'';?>>Saturday</option>
	                       				<option value="Sunday" <?php echo $im->days=="Sunday" ? 'selected':'';?>>Sunday</option>
	                       			</select>
														
	                       		</div>
	                       		
	                       		<!-- <div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div> -->
	                       			<div class="span3">
												<?php if($i==0){ ?>
												<a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveAjax('<?php echo $im->bar_hour_id ?>')"><i class="glyphicon glyphicon-minus"></i></a>
												<?php } ?>
												
											</div>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       		</div>
	                       		
	                       		
	                       		
	                       		<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Select Hours  : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-4" style="width: 23.5%" >
	                       			<input required type="text" value="<?php echo $im->hour_from; ?>"  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from">
	                       		</div>
	                       		<div class="col-sm-3 text-right"  style="width: 23.5%">	
	                       			<input required type="text" value="<?php echo $im->hour_to; ?>"  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to">
	                       			
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input required type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value=""> -->
	        				 	</div>
	                       		
	                       		
	                       		
	        				 	
	        				 	
	                       		
	                       		
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Speciality  : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                       			<input required type="text" value="<?php echo $im->speciality; ?>"  class="form-control form-pad" name="speciality[]" id="speciality">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>  
														</div>
									<?php $i++; } ?>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />																
													</div>	
													<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" value="Submit" name="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>														
													<?php } else {?>	
													 	
					
						<input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="" />
     				
		     			<div class="text-center pad_t15b20">
	                       	
	                       	
	                     <div id="hide_edit">
	                     	<div id="inner">  	
	                     		<input type="hidden" name="cntpro" id="cntpro" value="0" />
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Days : <span class="aestrick"> * </span></label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                       			<select required name="days[]" id="days" class="select_box">
	                       				<option value="">-- Select Day-- </option>
	                       				<option value="Monday">Monday</option>
	                       				<option value="Tuesday">Tuesday</option>
	                       				<option value="Wednesday">Wednesday</option>
	                       				<option value="Thursday">Thursday</option>
	                       				<option value="Friday">Friday</option>
	                       				<option value="Saturday">Saturday</option>
	                       				<option value="Sunday">Sunday</option>
	                       			</select>
														
	                       		</div>
	                       		
	                       		<!-- <div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div> -->
	                       			<a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       		</div>
	                       		
	                       		
	                       		
	                       		<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Select Hours  : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-4" style="width: 23.5%;">
	                       			<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from">
	                       		</div>
	                       		<div class="col-sm-3 text-right" style="width: 23.5%;">	
	                       			<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to">
	                       			
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input required type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value=""> -->
	        				 	</div>
	        				 	
	        				 	<input type="hidden" name="cntprobeer[]" id="cntprobeer" value="0" />
	                       <div id="contbeer">
	                       <div id="innerbeer" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Beers : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="bid0_0[]" id="bid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsbeer form-pad" id="beerid_0"  name="beerid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="beerprice" name="beerprice[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowbeer" name="add_rowbeer" class="add_rowbeer btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	
	        				 	<input type="hidden" name="cntprococktail" id="cntprococktail" value="0" />
	                       <div id="contcocktail">
	                       <div id="innercocktail" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Cocktails : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="cid[]" id="cid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagscocktail form-pad" id="cocktailid_0"  name="cocktailid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="cocktailprice" name="cocktailprice[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowcocktail" name="add_rowcocktail" class="add_rowcocktail btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	<input type="hidden" name="cntproliquor" id="cntproliquor" value="0" />
	                       <div id="contliquor">
	                       <div id="innerliquor" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Liquors : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="lid[]" id="lid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsliquor form-pad" id="liquorid_0"  name="liquorid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="liquorprice" name="liquorprice[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowliquor" name="add_rowliquor" class="add_rowliquor btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	<input type="hidden" name="cntprofood" id="cntprofood" value="0" />
	                       <div id="contfood">
	                       <div id="innerfood" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Foods : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="fid[]" id="fid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsfood form-pad" id="foodid_0"  name="foodid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="foodprice" name="foodprice[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowfood" name="add_rowfood" class="add_rowfood btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	
	        				 	<input type="hidden" name="cntproother" id="cntproother" value="0" />
	                       <div id="contother">
	                       <div id="innerother" >	
								
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Others : </label>
	        				 	</div>
	                       		
                                <input type="hidden" name="oid[]" id="oid_0" value="" />
	                       		<div class="col-sm-3" style="padding-left: 15px;">	
	                       			<input type="text" class="form-control tagsfood form-pad" id="otherid_0"  name="otherid[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">Price : $ </label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">	
	                       			<input type="text" class="form-control form-pad" id="otherprice" name="otherprice[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_rowother" name="add_rowother" class="add_rowother btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	        				 </div>	
	        				 	
	        				 	</div>
	        				 	
	        				 	
	        				 	
	        				 	
	                       	</div>
	                      </div> 	
	                       	
	                       	
	                       	
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" value="Submit" name="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     		
     		<?php } ?>
     			</form>
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
 
<script>

$(document).ready(function(){	
	
	$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		      
	$('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });	      

      	$('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });	
   
$('#add_row').click(function(){
		var cnt=parseInt($('#cntpro').val())+1;
		
		$('#cntpro').val(cnt);
		
		var html = '';
		
		//html += '<input type="hidden" name="incr" id="incr_'+cnt+'" value="'+cnt+'" />'
		html += '<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="padtb"><div class="col-sm-3 text-right"><label class="control-label">Days  : <span class="aestrick"> * </span></label></div>'  					        				 	
	    html += '<div class="input_box upload_btn">';
	    html += '<select required name="days[]" id="days'+cnt+'" class="select_box"><option value="">-- Select Day-- </option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="span3"><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div><div class="clearfix"></div></div>';
        html += '<div class="padtb8"><div class="col-sm-3 text-right">';
	    html += '<label class="control-label">Select Hours  : <span class="aestrick"> * </span></label></div>';
	    html += '<div class="col-sm-4"  style="width: 23.5%"><input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_from[]" id="hour_from'+cnt+'"></div><div class="col-sm-3 text-right"  style="width: 23.5%">';	
	    html += '<input required type="text" value=""  class="timepicker-default form-control form-pad" name="hour_to[]" id="hour_to'+cnt+'"></div><div class="clearfix"></div>';
	    html += '</div>';
	    //html += '</div>';
	    
	    
	    html += '<input type="hidden" name="cntprobeer[]" id="cntprobeer1'+cnt+'" value="0" /><div id="contbeer'+cnt+'"><div id="innerbeer'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Beers : </label></div>';
	    html += '<input type="hidden" name="bid'+cnt+'_0[]" id="bid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsbeer'+cnt+' form-pad" id="beerid_'+cnt+'"  name="beerid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="beerprice'+cnt+'" name="beerprice[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowbeer'+cnt+'" name="add_rowbeer" class="add_rowbeer btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    html += '<input type="hidden" name="cntprococktail" id="cntprococktail1'+cnt+'" value="0" /><div id="contcocktail'+cnt+'"><div id="innercocktail'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Cocktails : </label></div>';
	    html += '<input type="hidden" name="cid[]" id="cid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagscocktail'+cnt+' form-pad" id="cocktailid_'+cnt+'"  name="cocktailid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="cocktailprice'+cnt+'" name="cocktailprice[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowcocktail'+cnt+'" name="add_rowcocktail" class="add_rowcocktail btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    
	    html += '<input type="hidden" name="cntproliquor" id="cntproliquor1'+cnt+'" value="0" /><div id="contliquor'+cnt+'"><div id="innerliquor'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Liquors : </label></div>';
	    html += '<input type="hidden" name="lid[]" id="lid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsliquor'+cnt+' form-pad" id="liquorid_'+cnt+'"  name="liquorid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="liquorprice'+cnt+'" name="liquorprice[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowliquor'+cnt+'" name="add_rowliquor" class="add_rowliquor btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    
	    html += '<input type="hidden" name="cntprofood" id="cntprofood1'+cnt+'" value="0" /><div id="contfood'+cnt+'"><div id="innerfood'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Foods : </label></div>';
	    html += '<input type="hidden" name="fid[]" id="fid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsfood'+cnt+' form-pad" id="foodid_'+cnt+'"  name="foodid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="foodprice'+cnt+'" name="foodprice[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowfood'+cnt+'" name="add_rowfood" class="add_rowfood btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    html += '<input type="hidden" name="cntproother" id="cntproother1'+cnt+'" value="0" /><div id="contother'+cnt+'"><div id="innerother'+cnt+'" ><div class="padtb8"><div class="col-sm-3 text-right"><label class="control-label">Others : </label></div>';
	    html += '<input type="hidden" name="fid[]" id="fid0_'+cnt+'" value="" />'
	    html += '<div class="col-sm-3" style="padding-left: 15px;">';	
	    html += '<input type="text" class="form-control tagsother'+cnt+' form-pad" id="otherid_'+cnt+'"  name="otherid[]" value=""></div>';	
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	    html += '<label class="control-label" style="font-size: 16px;">Price : $ </label></div>';
	    html += '<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right: 24px;">';	
	    html += '<input type="text" class="form-control form-pad" id="otherprice'+cnt+'" name="otherprice[]" value="">';
	    html += '</div><a href="javascript://;" id="add_rowother'+cnt+'" name="add_rowother" class="add_rowother btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	    html += '<div class="clearfix"></div></div>';
	    html += '</div></div>';
	    
	    
	    html += '</div></div></div><div class="clear"></div>';
		$('#inner').append(html);
		
		
		$('.tagsbeer'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		
		$('.tagscocktail'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		 
		 
		 $('.tagsliquor'+cnt).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid0_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });     
		      
		$('#add_rowbeer'+cnt).click(function(){
	
		var cntbeer=parseInt($('#cntprobeer1'+cnt).val())+1;
		if($('#cntprobeer1'+cnt).val() =='NaN')
		{
		    $('#cntprobeer1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprobeer1'+cnt).val(cntbeer);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgbeer'+cnt+'_'+cntbeer+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="bid'+cnt+'_'+cntbeer+'[]" id="bid0_'+cnt+cntbeer+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsbeer'+cnt+cntbeer+'" id="beerid_'+cntbeer+'"  name="beerid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="beerprice_'+cnt+cntbeer+'" name="beerprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivebeer(\''+cnt+cntbeer+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerbeer'+cnt).append(html);
		$('.tagsbeer'+cnt+cntbeer).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#bid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgbeer_'+cnt+cntbeer).slideDown();
			
		});
		
		
		
		
		$('#add_rowcocktail'+cnt).click(function(){
	
		var cntcocktail=parseInt($('#cntprococktail1'+cnt).val())+1;
		if($('#cntprococktail1'+cnt).val() =='NaN')
		{
		    $('#cntprococktail1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprococktail1'+cnt).val(cntcocktail);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgcocktail'+cnt+'_'+cntcocktail+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="cid[]" id="cid0_'+cnt+cntcocktail+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagscocktail'+cnt+cntcocktail+'" id="cocktailid_'+cntcocktail+'"  name="cocktailid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="cocktailprice_'+cnt+cntcocktail+'" name="cocktailprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivecocktail(\''+cnt+cntcocktail+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innercocktail'+cnt).append(html);
		$('.tagscocktail'+cnt+cntcocktail).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#cid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgcocktail_'+cnt+cntcocktail).slideDown();
			
		});
		
		
		
		
		
		$('#add_rowliquor'+cnt).click(function(){
	
		var cntliquor=parseInt($('#cntproliquor1'+cnt).val())+1;
		if($('#cntproliquor1'+cnt).val() =='NaN')
		{
		    $('#cntproliquor1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproliquor1'+cnt).val(cntliquor);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgliquor'+cnt+'_'+cntliquor+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="lid[]" id="lid0_'+cnt+cntliquor+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsliquor'+cnt+cntliquor+'" id="liquorid_'+cntliquor+'"  name="liquorid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="liquorprice_'+cnt+cntliquor+'" name="liquorprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveliquor(\''+cnt+cntliquor+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerliquor'+cnt).append(html);
		$('.tagsliquor'+cnt+cntliquor).autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		      // alert(cnt+myArray[1]);
        $("#lid0_"+cnt+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgliquor_'+cnt+cntliquor).slideDown();
			
		});
		
		
		
			$('#add_rowfood'+cnt).click(function(){
	
		var cntfood=parseInt($('#cntprofood1'+cnt).val())+1;
		if($('#cntprofood1'+cnt).val() =='NaN')
		{
		    $('#cntprofood1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntprofood1'+cnt).val(cntfood);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgfood'+cnt+'_'+cntfood+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="fid[]" id="fid0_'+cnt+cntfood+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsfood'+cnt+cntfood+'" id="foodid_'+cntfood+'"  name="foodid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="foodprice_'+cnt+cntfood+'" name="foodprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivefood(\''+cnt+cntfood+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerfood'+cnt).append(html);
		$('#imgfood_'+cnt+cntfood).slideDown();
			
		});
		
		
		$('#add_rowother'+cnt).click(function(){
	
		var cntother=parseInt($('#cntproother1'+cnt).val())+1;
		if($('#cntproother1'+cnt).val() =='NaN')
		{
		    $('#cntproother1'+cnt).val('1');
		    cnt = 1;
		}
		$('#cntproother1'+cnt).val(cntother);
		//alert(cnt);
		var html = '';
		html += '<div class="padtb" id="imgother'+cnt+'_'+cntother+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="oid[]" id="oid0_'+cnt+cntother+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsother'+cnt+cntother+'" id="foodid_'+cntother+'"  name="otherid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad" id="otherprice_'+cnt+cntother+'" name="otherprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveother(\''+cnt+cntother+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerother'+cnt).append(html);
		$('#imgother_'+cnt+cntfood).slideDown();
			
		});
		
		
		$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		    
		
		  $('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		       $('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('.timepicker-default').timepicker({

            });
		$('#img_'+cnt).slideDown();
			
		});
		
		$('#add_rowbeer').click(function(){
	 
		var cnt=parseInt($('#cntprobeer').val())+1;
		if($('#cntprobeer').val() =='NaN')
		{
		    $('#cntprobeer').val('1');
		    cnt = 1;
		}
		$('#cntprobeer').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgbeer_'+cnt+'" style="display:none;"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="bid0_'+cnt+'[]" id="bid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsbeer" id="beerid_'+cnt+'"  name="beerid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="beerprice_'+cnt+'" name="beerprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivebeer(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerbeer').append(html);
		$('.tagsbeer').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('beer/auto_suggest_beer/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#bid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgbeer_'+cnt).slideDown();
			
		});
		
		
		$('#add_rowcocktail').click(function(){
	
		var cnt=parseInt($('#cntprococktail').val())+1;
		if($('#cntprococktail').val() =='NaN')
		{
		    $('#cntprococktail').val('1');
		    cnt = 1;
		}
		$('#cntprococktail').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgcocktail_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="cid[]" id="cid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagscocktail" id="cocktailid_'+cnt+'"  name="cocktailid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="cocktailprice_'+cnt+'" name="cocktailprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivecocktail(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innercocktail').append(html);
		$('.tagscocktail').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('cocktail/auto_suggest_cocktail/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#cid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgcocktail_'+cnt).slideDown();
			
		});
		
		
		
		
		
		
		
		$('#add_rowliquor').click(function(){
	
		var cnt=parseInt($('#cntproliquor').val())+1;
		if($('#cntproliquor').val() =='NaN')
		{
		    $('#cntproliquor').val('1');
		    cnt = 1;
		}
		$('#cntproliquor').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgliquor_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="lid[]" id="lid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsliquor" id="liquorid_'+cnt+'"  name="liquorid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="liquorprice_'+cnt+'" name="liquorprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveliquor(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerliquor').append(html);
		$('.tagsliquor').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('liquor/auto_suggest_liquor/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									
									label: item.label,
									id: item.id,
									
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      	//alert($(this).attr('id'));
		      var row= $(this).attr('id');
		        var myArray = row.split('_');
		       
        $("#lid_"+myArray[1]).val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		$('#imgliquor_'+cnt).slideDown();
			
		});
		
		
		
		
		$('#add_rowfood').click(function(){
	
		var cnt=parseInt($('#cntprofood').val())+1;
		if($('#cntprofood').val() =='NaN')
		{
		    $('#cntprofood').val('1');
		    cnt = 1;
		}
		$('#cntprofood').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgfood_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="fid[]" id="fid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsfood" id="foodid_'+cnt+'"  name="foodid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="foodprice_'+cnt+'" name="foodprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDivefood(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerfood').append(html);
		$('#imgfood_'+cnt).slideDown();
			
		});
		
		
		
		
		
		$('#add_rowother').click(function(){
	
		var cnt=parseInt($('#cntproother').val())+1;
		if($('#cntproother').val() =='NaN')
		{
		    $('#cntproother').val('1');
		    cnt = 1;
		}
		$('#cntproother').val(cnt);
		
		var html = '';
		html += '<div class="padtb" id="imgother_'+cnt+'"><div class="padtb8">';
	    html +=  ' <input type="hidden" name="oid[]" id="oid_'+cnt+'" value="" /><div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label"></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-3" style="padding-left: 15px;">';
	   html +=                   			'<input type="text" class="form-control form-pad tagsother" id="otherid_'+cnt+'"  name="otherid[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-3" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Price : $</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px; margin-right:24px; ">';	
	  html +=                    			'<input type="text" class="form-control form-pad " id="otherprice_'+cnt+'" name="otherprice[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveother(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
		
		$('#innerother').append(html);
		$('#imgother_'+cnt).slideDown();
			
		});
		
	});		
	function removeImageDivebeer(id)
	{
		var cnt=parseInt($('#cntprobeer').val())-1;
		$('#cntprobeer').val(cnt);
		$('#imgbeer_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivecocktail(id)
	{
		var cnt=parseInt($('#cntprococktail').val())-1;
		$('#cntprococktail').val(cnt);
		$('#imgcocktail_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDiveliquor(id)
	{
		var cnt=parseInt($('#cntproliquor').val())-1;
		$('#cntproliquor').val(cnt);
		$('#imgliquor_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDivefood(id)
	{
		var cnt=parseInt($('#cntprofood').val())-1;
		$('#cntprofood').val(cnt);
		$('#imgfood_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	function removeImageDiveother(id)
	{
		var cnt=parseInt($('#cntproother').val())-1;
		$('#cntproother').val(cnt);
		$('#imgother_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
function removeImageDive(id)
	{
		var cnt=parseInt($('#cntpro').val())-1;
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	function removeImageDiveAjax(id)
	{
	     //   alert("removeImageDiveAjax");
	      //  alert(id);
		alertify.confirm("Are you sure you want to delete this bar hours?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removebarhours') ?>/'+id,
				success:function(res){
				var cnt=parseInt($('#cnt').val())-1;
				$('#cntpro').val(cnt);
				$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your bar hour deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
</script>





<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/new-timepicker.css" />
				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/new-bootstrap-timepicker.js"></script>
<script>
function validate(){
		var htm = '';
		var eduInput = document.getElementsByName('days[]');
	
		for (i=0; i<eduInput.length; i++)
			{
			 if (eduInput[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all days field.</p>"
			 	 	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
				}
			}
			
			var eduInput1 = document.getElementsByName('hour_from[]');
	
		for (i=0; i<eduInput1.length; i++)
			{
			 if (eduInput1[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all from hours field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("Please fill all days field.</p>");
			 	// return false;
				}
			}
			
			var eduInput2 = document.getElementsByName('hour_to[]');
	
		for (i=0; i<eduInput2.length; i++)
			{
			 if (eduInput2[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all to hours field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			var eduInput3 = document.getElementsByName('price[]');
	
		for (i=0; i<eduInput3.length; i++)
			{
			 if (eduInput3[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all price field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			var eduInput4 = document.getElementsByName('speciality[]');
	
		for (i=0; i<eduInput4.length; i++)
			{
			 if (eduInput4[i].value == "")
				{
			 	 // alert('Complete all the days fields');	
			 	    htm += "<p>Please fill all speciality field.</p>";
			 	    	$("#cm-err-main1").html(htm);
			 	 	$("#cm-err-main1").show();
			 	    return false;
			 	 	//$("#cm-err-main1").html("<p>Please fill all days field.</p>");
			 	 //return false;
				}
			}
			
			
			
			
	}
	
	$('.timepicker-default').timepicker({

               // defaultTime : false

            });
		jQuery(document).ready(function() {       
				<?php if($msg=='update'){?>
  		$.growlUI('Your bar special hours updated successfully .');
    <?php } ?>		
		
		  // FormComponents.init();
		       $('.timepicker-default').timepicker({

               // defaultTime : false

            });
		});
		
		
	</script>
	

