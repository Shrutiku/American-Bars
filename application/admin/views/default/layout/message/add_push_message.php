<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.searchable-1.0.0.min.js"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.searchable.js"></script>
<style>
	.row-padding {
    margin-top: 25px;
    margin-bottom: 25px;
}
</style>
<script>
	$(document).ready(function(){
		
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });
    if($(".user_type").val()=="user")
    {
    $( '#user_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
    }
    else if($(".user_type").val()=="bar_owner")
    {
    	$( '#barowner_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
    }
    else if($(".user_type").val()=="taxi_owner")
    {
    	$( '#taxiowner_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
    }
});

</script>
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<style>
	.ui-widget{
		max-height:250px;
		overflow-x: scroll;
	}
</style>

<script type="text/javascript">

	
$(document).ready(function(){
	
	$("#search").keyup(function(){
		//alert(1);
    //$("input").css("background-color", "pink");
}); 

	   $('#selectAll').click(function(){
			    	if($(this).is(':checked')){
			    		//$('#user_list input[type=checkbox]').attr('checked',true);
			    		 $("#user_list input[type=checkbox]").prop('checked', $(this).prop("checked"));
			    	}else{
			    		$('#user_list input[type=checkbox]').attr('checked',false);
			    	}
			    	//$('#user input[type=checkbox]').uniform();
			    });
			    
			    $('#selectAll_bar').click(function(){
			    	if($(this).is(':checked')){
			    		//$('#barowner_list input[type=checkbox]').attr('checked',true);
			    		$("#barowner_list input[type=checkbox]").prop('checked', $(this).prop("checked"));
			    	}else{
			    		$('#barowner_list input[type=checkbox]').attr('checked',false);
			    		
			    	}
			    //	$('#bar_owner input[type=checkbox]').uniform();
			    });
			    
			    $('#selectAll_taxi').click(function(){
			    	if($(this).is(':checked')){
			    		//$('#taxiowner_list input[type=checkbox]').attr('checked',true);
			    		$("#taxiowner_list input[type=checkbox]").prop('checked', $(this).prop("checked"));
			    	}else{
			    		$('#taxiowner_list input[type=checkbox]').attr('checked',false);
			    	}
			    	//$('#taxi_owner input[type=checkbox]').uniform();
			    });
	$("#usualValidate").validate({
             	ignore : false,  	
		rules: {
			description:'required',
			
		},
		
	});
	});
</script>

<!-- <style type="text/css">
	div.tagsinput input{ width:auto !important; }
</style> -->

<script>
	function getuser(type)
	{
	
		if(type=="user")
		{
			
			$("#user_list").removeClass("op0");
			$("#barowner_list").addClass("op0");
			$("#taxiowner_list").addClass("op0");
			 $( '#user_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
		}
		else if(type=="bar_owner")
		{
			$("#user_list").addClass("op0");
			$("#barowner_list").removeClass("op0");
			$("#taxiowner_list").addClass("op0");
			 $( '#barowner_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
		}
		else
		{
			$("#user_list").addClass("op0");
			$("#barowner_list").addClass("op0");
			$("#taxiowner_list").removeClass("op0");
			 $( '#taxiowner_list' ).searchable({
        searchField: '#container-search',
        selector: '.checkbox',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    });
		}
			bindFunction();
		// $.ajax({
	       // type: "POST",
		   // url: "<?php //echo site_url('message/getAllUser')?>",
		   // data : {type:type},
		   // success: function(response) {
		   	// if(type=="user")
		   	// {
		   	// $('#user_list').html(response);
		   	// }
// 		   	
		   		// if(type=="bar_owner")
		   	// {
		   	// $('#barowner_list').html(response);
		   	// }
// 		   	
		   		// if(type=="taxi_owner")
		   	// {
		   	// $('#taxiowner_list').html(response);
		   	// }
		   // bindFunction();
// 		   
// 		     
		  // }
	   // });
	}
	
	
function bindFunction()
{
	//jQuery('input[type=checkbox]').uniform();
			    
			    $('#selectAll').click(function(){
			    	if($(this).is(':checked')){
			    		$('#user_list input[type=checkbox]').attr('checked',true);
			    	}else{
			    		$('#user_list input[type=checkbox]').attr('checked',false);
			    	}
			    	//$('#user input[type=checkbox]').uniform();
			    });
			    
			    $('#selectAll_bar').click(function(){
			    	if($(this).is(':checked')){
			    		$('#barowner_list input[type=checkbox]').attr('checked',true);
			    	}else{
			    		$('#barowner_list input[type=checkbox]').attr('checked',false);
			    	}
			    //	$('#bar_owner input[type=checkbox]').uniform();
			    });
			    
			    $('#selectAll_taxi').click(function(){
			    	if($(this).is(':checked')){
			    		$('#taxiowner_list input[type=checkbox]').attr('checked',true);
			    	}else{
			    		$('#taxiowner_list input[type=checkbox]').attr('checked',false);
			    	}
			    	//$('#taxi_owner input[type=checkbox]').uniform();
			    });
}

	


</script>



<div class="page_content">
	

			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($message_id==""){ echo 'Send Push Notification'; } else { echo 'Edit Broadcast Message'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
				<?php  
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error_red">'.$error.'</div>';	
						}
					}
				?>		
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="content ">
								<?php
									$attributes = array('id'=>'usualValidate','name'=>'frm_addmessage','class'=>'main');
									echo form_open_multipart('message/send_push_notification',$attributes);
								?>
			  						
									
									<div class="control_group">
										<label class="control_label">Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea maxlength="230" name="description" id="description" placeholder="Description..." class="m_wrap span9 wid360" rows="30" cols="100"  ><?php echo $description; ?></textarea>
											<div class="clear"></div>
											<span class="inline">(Max 230 character allow.)</span>
											<label for="description" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
									</div>
							</div>
							
							
							<input type="hidden" name="message_id" id="message_id" value="<?php echo $message_id; ?>" />
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
							<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
							<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
							<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
							
							<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
							<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							
							<div class="form_action">
								
								<?php if($message_id==""){ ?>
					
									<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
									<?php if($redirect_page == 'list_push_notification') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php }else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>
									
								<?php }else { ?>
									
									<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
									
									<?php if($redirect_page == 'list_push_notification') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php } else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>								
								<?php } ?>
								</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>