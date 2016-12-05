<link rel="stylesheet" href="<?php echo base_url().'admin/'.getThemeName(); ?>/css/drag_style.css" />

<script type="text/javascript" src="<?php echo base_url().'admin/'.getThemeName(); ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript">
function repositionCover() {
    $('.cover-wrapper').hide();
    $('.cover-resize-wrapper').show();
    $('.cover-resize-buttons').show();
    $('.default-buttons').hide();
    $('.screen-width').val($('.cover-resize-wrapper').width());
    $('.cover-resize-wrapper img')
    .css('cursor', 's-resize')
    .draggable({
        scroll: false,
        
        axis: "y",
        
        cursor: "s-resize",
        
        drag: function (event, ui) {
            y1 = $('.timeline-header-wrapper').height();
            y2 = $('.cover-resize-wrapper').find('img').height();
            
            if (ui.position.top >= 0) {
                ui.position.top = 0;
            }
            else
            if (ui.position.top <= (y1-y2)) {
                ui.position.top = y1-y2;
            }
        },
        
        stop: function(event, ui) {
            $('input.cover-position').val(ui.position.top);
        }
    });
}

function saveReposition() {
    
    if ($('input.cover-position').length == 1) {
        posY = $('input.cover-position').val();
        $('form.cover-position-form').submit();
    }
}

function cancelReposition() {
    $('.cover-wrapper').show();
    $('.cover-resize-wrapper').hide();
    $('.cover-resize-buttons').hide();
    $('.default-buttons').show();
    $('input.cover-position').val(0);
    $('.cover-resize-wrapper img').draggable('destroy').css('cursor','default');
}


 $(function(){
    $('.cover-resize-wrapper').height($('.cover-resize-wrapper').width()*0.3);
   
});  


</script>
<?php
				$attributes = array('id'=>'frm_addbar','name'=>'frm_addbar','class'=>'main cover-position-form');
				echo form_open_multipart('home/updatebannernew/',$attributes);
			  ?>	
			  <input type="hidden" name="prev_bar_banner" id="prev_bar_banner" value="<?php echo $bar_detail['bar_banner']; ?>" />
			  <input type="hidden" name="bar_id" id="bar_id" value="" />
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip update_banner"></i> Update Banner</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
     						
     					
     					
					
				<div id="list_show" style="display: block;" >	
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('home/upload_profile'); ?>">
     				
		     			<div class="text-center pad_t15b20">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Banner Image : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="file" accept="image/*"  class="form-control form-pad" id="file" name="file" value="">
	                           		<span for="file" class="help-inline" style="display: none;" id="img_resize">Image size must be greater than 1140px by 244px.</span>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		<div class="col-sm-3 text-right">
	        				 		<!-- <label class="control-label">Banner Image : <span class="aestrick"> * </span></label> -->
	        				 	</div>
	                       		<div class="text-center col-sm-7 mar_top15">
	                       		
	                       		<?php
		          		if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag_thumb/'.@$bar_detail['bar_banner']))
					{?>
		            	<img  src="<?php echo base_url()?>/upload/banner_drag_thumb/<?php echo $bar_detail['bar_banner']; ?>" alt="American Dive Bars"/>
		            	
		            	<div class="mar_top15"><a href="#modalimage" data-toggle='modal' class="btn btn-lg btn-primary">Preview and Reposition</a></div>
		            	<?php }  else if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag_without/'.@$bar_detail['bar_banner']))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $bar_detail['bar_banner']; ?>" alt="American Dive Bars"/>
		            		<div class="mar_top15"><a href="#modalimage" data-toggle='modal' class="btn btn-lg btn-primary">Preview and Reposition</a></div>
		            		<?php } ?>
		            			</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	
	                       	<!-- <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Submit</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	<div class="clearfix"></div>
     		</div>
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>

<div class="modal fade login_pop2" id="modalimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	     					
	     						 <div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width: 1140px;">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Banner Upload</div>
	     				
     				</div>
	        			<input class="cover-position" name="pos" value="0" type="hidden">
	     						<div class="timeline-header-wrapper">	
	        						<div class=" cover-resize-wrapper"  id="preview" <?php	if($bar_detail['bar_banner']!=""){ ?>  style="display: block"; <?php }?>>
	        							<?php
		          		if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/barlogo_orig/'.@$bar_detail['bar_banner']))
					{?>
	     							<img id="previewimg" src="<?php echo base_url()?>upload/barlogo_orig/<?php echo $bar_detail['bar_banner']; ?>" />
	     							<?php } else {?>
	     							<img id="previewimg"  src="">	
	     								<?php } ?>
	     						</div>
	     					</div>
	     					<div class="padtb10 marl_10 text-center">	
	     						 <a onclick="repositionCover();" class="btn btn-lg btn-primary" style="font-size: 16px;  font-weight: bold; cursor: pointer;" >Reposition cover</a>
	     						 <input type="submit" name="submit" id="submit"  class="btn btn-lg btn-primary" value="Save"  />
	     					</div>
	     						 
     			</div>
     		</div>
					</div>	
					</form>				
					</div>	
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    
    <script>
   
   var img_width = 0;
  var img_height = 0;
 function checkImageValidation(){
		var _URL = window.URL;
			$("#file").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					
					if(img_width>=1140 && img_height>=244)
					{
						$('#modalimage').modal('show');
					}
					else
					{
						$("#img_resize").show();
					}
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
	}
  $(document).ready(function(){	
  	<?php if($msg=='success'){?>
  		$.growlUI('Your banner update successfully .');
    <?php } ?>		
	checkImageValidation();

$("#frm_addbar1").validate({
		
		rules: {
			file: {
				  image_validation : true,
			},
			status:'required',
		},		
	});	
	
	jQuery.validator.addMethod("image_validation", function(value, element) {
		if(img_width >= 1140 && img_height >=244){
			//$('#modalimage').modal('show');
			//alert('fdsa');
			return true;
		}	
		return false;
    //var test = null; //Perform your test here        
   // return this.optional(element) || test;
}, 'Image size must be greater than 1140px by 244px.');
});	
</script>
