<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>

<script>
	$(document).ready(function() {
		
	var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
      $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
//     
     // $(".morelink").click(function(){
        // if($(this).hasClass("less")) {
            // $(this).removeClass("less");
            // $(this).html(moretext);
            // $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        // } else {
            // $(this).addClass("less");
            // $(this).html("<i class='strip arrow_up more'></i>View Less..");
        // }
        // $(this).parent().prev().toggle();
        // $(this).prev().toggle();
        // return false;
    // });
     }); 
</script>


		            		
		            		
		            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;} */
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />

<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row5">
     	<div class="container">
     	<div class="resource_details">
     		<div class="result_search">
	     		<div class="result_search_text">Resource Details</div>
     		</div>
     		<div class="br_bott_yellow">
     			<div>
     				<div class="media">
						    <div class="media-body">
						       <div><h4 class="media-heading"><a href="javascript:void(0);" class="listing-title yellow_title"><?php echo $resource_detail['resource_title']; ?></a></h4></div>
						       <div class="clearfix"></div>
							      <div class="mart10">
						        	<ul class="beerdirectory">
						        		<li>
						        			<div class="pull-left yellow_text min-80 marr_10">Website</div>
						        			<p class="colon-new"> : </p>
						        			<div class="pull-left white_text wid75"><a class="website-url" href="javascript:void(0);" onclick="window.open('<?php echo $resource_detail['website']; ?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');"><?php echo $resource_detail['website']; ?></a></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		
						        		<li>
						        			<div class="pull-left yellow_text min-80 marr_10 ">Category</div>
						        			<p class="colon-new"> : </p>
						        			<div class="pull-left white_text wid75"><?php echo ucfirst(str_replace("_"," ",$resource_detail['resource_category'])); ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		
						        		
						        		
						        		<li>
						        			<!-- <div class="result_desc more">
						        				 <?php 
						       	   $text=str_ireplace('<p>','',$resource_detail['resource_desc']);
									$text=str_ireplace('</p>','',$text); 
								echo $text;?>
						       	   
						       </div>  -->
						       <div class="normal-newtext">Description:</div>
						       <div class="result_desc">
						       	<?php  echo strip_tags($resource_detail['resource_desc']); ?>
						       	   						       	  <?php  
						       	  // $text=str_ireplace('<p>','',$resource_detail['resource_desc']);
									//$text=str_ireplace('</p>','',$text); 
								//echo $text;?> 
						       </div>
						        		</li>
						        		
										<?php //} ?>
						        	</ul>
						         </div>
						        
						    </div>
				    	</div>
				    	<div class="clearfix"></div>
     			</div>
     			
     			
     			<div class="clearfix"></div>
     		</div>
     		
     	</div>	
   		</div>
 <div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $resource_detail['resource_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>    
   	</div>
   	
   	
   	