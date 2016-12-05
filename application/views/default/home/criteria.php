<style>

.thumbnail-item { 
	/* position relative so that we can use position absolute for the tooltip */
	position: relative; 
	float: left;  
	margin: 0px 5px; 
}


.thumbnail-item a { 
	display: block; 
}

.thumbnail-item img.thumbnail {
	border:3px solid #ccc;	
}
		
.tooltip1 { 
	/* by default, hide it */
	display: none; 
	/* allow us to move the tooltip */
	position: absolute; 
	/* align the image properly */
	padding: 8px 0 0 8px; 
}

	.tooltip1 span.overlay { 
		/* the png image, need ie6 hack though */
		background: url(images/overlay.png) no-repeat; 
		/* put this overlay on the top of the tooltip image */
		position: absolute; 
		top: 0px; 
		left: 0px; 
		display: block; 
		width: 350px; 
		height: 200px;
	}
	</style>
<script type="text/javascript">

	// Load this script once the document is ready
	$(document).ready(function () {
		
		// Get all the thumbnail
		$('div.thumbnail-item').mouseenter(function(e) {

			// Calculate the position of the image tooltip
			x = e.pageX - $(this).offset().left;
			y = e.pageY - $(this).offset().top;

			// Set the z-index of the current item, 
			// make sure it's greater than the rest of thumbnail items
			// Set the position and display the image tooltip
			$(this).css('z-index','15')
			.children("div.tooltip1")
			.css({'display':'block'});
			
		}).mousemove(function(e) {
			
			// Calculate the position of the image tooltip			
			x = e.pageX - $(this).offset().left;
			y = e.pageY - $(this).offset().top;
			
			// This line causes the tooltip will follow the mouse pointer
			$(this).children("div.tooltip1").css({'top': y + 10,'left': x + 20});
			
		}).mouseleave(function() {
			
			// Reset the z-index and hide the image tooltip 
			$(this).css('z-index','1')
			.children("div.tooltip1")
			.animate({"opacity": "hide"}, "fast");
		});

	});


	</script>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<div class="beer_details">
     		<div class="result_search">
	     		<div class="result_search_text">Are you in real American Dive Bar? Take the test and find out! It is easy and fun!</div>
     		</div>
     		<div class="pad20">
     		<div class="pull-left mar_top20 mar_r15">
     			<h1 class="yellow_title">Dive Bar Mugs :</h1>
     			<div>
     				<ul class="mug-list">
     					<li><img id="10" src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png" alt="" class="img-responsive" /></li>
     					<li><img id="15" src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png" alt="" class="img-responsive" /></li>
     					<li><img id="20" src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png" alt="" class="img-responsive" /></li>
     					<li><img id="25" src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png" alt="" class="img-responsive" /></li>
     					<li><img id="30" src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png" alt="" class="img-responsive" /></li>
     					<div class="clearfix"></div>
     				</ul>
     			</div>
     		</div>
     			<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('home/barcriteria',$attributes);?> 
					<input type="hidden" name="fchk" id="fchk" value="0" />
     		<div class="ciretria-block mar_top20">
	     		<div>
	     		<?php if($get_dive_bar){
	     		   $i=01;  foreach($get_dive_bar as $row){
	     		      		
	     		?>	
	     			<h1 class="yellow_title"><?php echo  $row->divebar_findout_title; ?></h1>
	     			<ul class="criteria-list">
	     			 <?php $get_all_crt = $this->home_model->getdivebar_crt($row->divebar_findout_id); 
	     			 if($get_all_crt){
	     			   foreach($get_all_crt as $r){
	     			   
	     			   	?>	
	     			   
	     				<li>	<div class="thumbnail-item"><label for="checkbox-<?php echo $i; ?>" class="radio-checkbox label_check"><input type="checkbox" value="<?php echo $i; ?>" id="checkbox-<?php echo $i; ?>" onclick="onclck(this)" name="sample[]"><?php echo $r->divebar_findout_description?></label>
	     				<?php if($r->image!='') {  
												if(file_exists(base_path().'upload/divebar_thumb/'.$r->image)) {
												
                              					$vendor_image = base_url().'upload/divebar_thumb/'.$r->image;
											
													}
													}
					 else {
						 $vendor_image = "";
					 }	
													?>
	     				<div class="tooltip1">
				<img src="<?php echo $vendor_image; ?>" alt="" />
			<span class="overlay"></span>
		</div> </div> </li><div class="clear"></div>
	     				<?php  $i++; } } ?>
	     			</ul>
	     		<?php } } ?>	
	     		</div>
	     		
	     		<div class="mar_top20">
	     			<button class="btn btn-lg btn-primary" id="Submit" name="Submit" type="submit">Suggest A Divebar</button>
	     		</div> 
     		</div>
     		<div class="clearfix"></div>
     		</form>
     		</div>
     	</div>	
     			
     		</div>
   		</div>
   	</div>
   	
<SCRIPT>
    function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
    $(document).ready(function(){
    	
    	// $("input[type=checkbox]").each(function(){
    		// $(this).attr('name','sample[]');
    	// })
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 
    });
</SCRIPT>

<script type="text/javascript">
var mug_result=0;
var img; 
function onclck(id){
	//alert($('#checkbox-01').is(':checked'));
 if(id.checked) { mug_result=mug_result+1;
 
    for(i=10; i<=44; i+=1) {
 	//alert(i);
      if(i==mug_result) {
      	//alert($("#checkbox-01").val());
      	// for(j=1; j<=10; j+=1) {
       if($('#checkbox-1').is(':checked')==true && $('#checkbox-2').is(':checked')==true && $('#checkbox-3').is(':checked')==true && $('#checkbox-4').is(':checked')==true &&  $('#checkbox-5').is(':checked')==true && $('#checkbox-6').is(':checked')==true && $('#checkbox-7').is(':checked')==true && $('#checkbox-8').is(':checked')==true && $('#checkbox-9').is(':checked')==true && $('#checkbox-10').is(':checked')==true)
       {
          $("#fchk").val(1);
          document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
          
       	  if(i==10 )
       	  {
       	  	 document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  }
       	  else if(i>=15 && i<=19)
       	  {
       	  	document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(15).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  }
       	 else if(i>=20 && i<=24)
       	  {
       	  	document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(15).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(20).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  }
       	 else if(i>=25 && i<=29)
       	  {
       	  	document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(15).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(20).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(25).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  }
       	else if(i==30)
       	  {
       	  		document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(15).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(20).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(25).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  	 document.getElementById(30).src="<?php echo base_url().getThemeName(); ?>/images/full-mug.png";
       	  }
       }
       else
       {
       	 document.getElementById(i).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       }
      }
    }
  } else {mug_result=mug_result-1;
    for(i=10; i<=44; i+=5) {
      if(mug_result<i) {
       document.getElementById(i).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
      }
       if($('#checkbox-1').is(':checked')==false || $('#checkbox-2').is(':checked')==false || $('#checkbox-3').is(':checked')==false || $('#checkbox-4').is(':checked')==false ||  $('#checkbox-5').is(':checked')==false || $('#checkbox-6').is(':checked')==false || $('#checkbox-7').is(':checked')==false || $('#checkbox-8').is(':checked')==false || $('#checkbox-9').is(':checked')==false || $('#checkbox-10').is(':checked')==false)
       {
       	$("#fchk").val(0);
       	document.getElementById(10).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       	document.getElementById(15).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       	document.getElementById(20).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       	document.getElementById(25).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       	document.getElementById(30).src="<?php echo base_url().getThemeName(); ?>/images/empty-mug.png";
       }
    }
  }
}
</script>