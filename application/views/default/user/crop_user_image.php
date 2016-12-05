<style>
/*.container{
	height: 250px;
}*/
</style>
<!-- <script src="<?php echo base_url().getThemeName();?>/js/jquery.min.js" type="text/javascript" charset="utf-8"></script> -->


<!--<script type="text/javascript">
 //var y=$('#target').height();
				 // parent.$.colorbox.resize({height:y+100});
  $(function($){

    var jcrop_api;
	 $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords,
	 
    },function(){
      // Use the API to get the real image size
      var bounds = this.getBounds();
      boundx = bounds[0];
      boundy = bounds[1];
      // Store the API in the jcrop_api variable
      jcrop_api = this;

      // Move the preview into the jcrop container for css positioning
      $preview.appendTo(jcrop_api.ui.holder);
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });
	
	
	$('#click').click(function(){
		
		 $.ajax({
                            url:"<?php echo site_url('user/crop_img'); ?>",
							type:'post',
                            dataType: 'json',
							data:$('.coords').find("input,textarea").serialize(),
							success: function(data){
							//alert(data.image_url);
								if(data.status=='Success'){
									
									$('#succ').html(data.error);
									$('#succ').show();
								parent.$('#file_up').val('');
								parent.$('.im').attr('src','<?php echo base_url().'upload/user_orig' ?>/'+data.image_url);
								
								
								parent.$.fn.colorbox.close();
								//alert(data.email);
								}else{
									$('#err').html(data.error);
									$('#err').show();
								}
							},
							
                    });
		
		});
	

  });

  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
	
	if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;
	
        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      }
	
	
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };



</script>-->

<!--<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>-->
<script type="text/javascript">

  $(function(){

    // $('#target').Jcrop({
      // aspectRatio: 1,
      // onSelect: updateCoords
    // });
    
    
 jQuery('#target').Jcrop({
            onSelect:    updateCoords,
            setSelect:   [50, 0, 300,300],
            allowResize: true,
             allowSelect: false,
            aspectRatio: 1,
        });
	
	
	$('#click').click(function(){
		
		 $.ajax({
                            url:"<?php echo site_url('user/crop_img'); ?>",
							type:'post',
                            dataType: 'json',
							data:$('.coords').find("input,textarea").serialize(),
							success: function(data){
							//alert(data.image_url);
								if(data.status=='Success'){
									window.location.href = "<?php echo site_url('user/profile_picture');?>";
								//	$('#succ').html(data.error);
									//$('#succ').show();
								parent.$('#file_up').val('');
								
								parent.$('#profile_upload').attr('src','<?php echo base_url().'upload/user' ?>/'+data.image_url);
								
						    	//parent.$("#popup_imgcrop").modal("hide");
						    	jQuery("#popup_imgcrop").modal("hide");
								//alert(data.email);
								}else{
									//$('#err').html(data.error);
									//$('#err').show();
								}
							},
							
                    });
		
		});
	
	

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>





    	 <!-- This is the image we're attaching Jcrop to -->
 		<!-- <div class="img_cover" style="width:650px; height:390px; overflow:scroll"> -->
 			
	  <?php if($profile_image!='' && is_file('upload/user_orig/'.$profile_image)){ ?>	 
                                    <img src="<?php echo base_url().'upload/user_orig/'.$profile_image; ?>" id="target" alt="[Jcrop Example]" /> 
                                    <?php }else {?> 
                                    <img src="<?php echo base_url();?>/upload/no-image-m.jpg" width="140px" height="140px"/>		
                        <?php   } ?><!-- </div> -->
    <?php /*?><div id="preview-pane">
        <div class="preview-container">
         
          <?php if($one_business->icon!='' && is_file('upload/business_orig/icon/'.$one_business->icon)){ ?>
                                    <img alt="" src="<?php echo base_url().'upload/business_orig/icon/'.$one_business->icon; ?>" class="jcrop-preview" alt="Preview" > 
                                    <?php }else { ?>
                                    <img alt="" src="<?php echo base_url().'upload/business/no_image.png'; ?>"> 
                                    <?php } ?>
                                    
        </div>
      </div><?php */?>
      <!-- This is the form that our event handler fills -->
   

  <form id="coords"  class="coords">	
    <div class="inline-labels">
    <!--<label>X1 --><input type="hidden" size="4" id="x" name="x1" />
   <!-- <label>Y1 --><input type="hidden" size="4" id="y" name="y1" /><!--</label>-->
    <!--<label>X2 --><input type="hidden" size="4" id="x2" name="x2" /><!--</label>-->
   <!-- <label>Y2 --><input type="hidden" size="4" id="y2" name="y2" /><!--</label>-->
   <!-- <label>W --><input type="hidden" size="4" id="w" name="w" /><!--</label>-->
   <!-- class="btn btn-large btn-inverse" <label>H --><input type="hidden" size="4" id="h" name="h" /><!--</label>-->
   <input type="hidden" name="old" id="old" value="<?php echo $old; ?>">
    <input type="button" value="Crop Image" class="btn btn-default crop_btn" id="click"  style="width:130px;" />
    </div>
  </form>