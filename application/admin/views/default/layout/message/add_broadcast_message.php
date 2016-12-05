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
   $('#usualValidate').on('submit', function() {
                    CKEDITOR.instances['description'].updateElement();
            });
});
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
			subject:'required',
			'to_user_id[]':'required',
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
					<h3 class="page_title"><?php if($message_id==""){ echo 'Add Broadcast Message'; } else { echo 'Edit Broadcast Message'; }?></h3>
					
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
									echo form_open_multipart('message/add_broadcast_message',$attributes);
								?>
			  						
									<div class="control_group">
										<label class="control_label">Select Type :</label>
										<div class="controls">
											<input type="radio" onclick="getuser('user')"  name="to_user_type[]" checked="checked" class="user_type" value="user" /> User
											<input type="radio" onclick="getuser('bar_owner')" name="to_user_type[]" class="user_type" value="bar_owner" /> Bar Owner
											<input type="radio" onclick="getuser('taxi_owner')" name="to_user_type[]" class="user_type" value="taxi_owner" /> Taxi Owner
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Search User :</label>
										<div class="controls">
											<input type="text"   name="search"  id="container-search" class="m_wrap wid360" value="" /> 
										</div>										
										<div class="clear"></div>
									</div>
									
									<div id="user_list" >
										<?php if(!empty($operator_list_user))
			{
		echo '<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list_user as $r)
		  {
		  			
						echo '<label style="width:350px; margin-bottom:10px;" class="checkbox wid228 pull-left"><input style="float:left;" type="checkbox" id="email'.$r->user_id.'" name="to_user_id[]" value="'.$r->email.'#user" /><div class="col-xs-4" style="float:left;">['.$r->first_name." ".$r->last_name.'] '.$r->email.'</div></label>';		
		  	 
		  }
			} 
			else
			{
				echo "No User Founds";
			}?>
									</div>	
									<div class="clear"></div>
									<div id="barowner_list" class="op0">
										<?php if(!empty($operator_list_bar_owner))
			{
		echo '<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll_bar" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list_bar_owner as $r)
		  {
		  			
						echo '<label style="width:350px; margin-bottom:10px;" class="checkbox wid228 pull-left"><input style="float:left;" type="checkbox" id="email'.$r->user_id.'" name="to_user_id[]" value="'.$r->email.'#bar_owner" /><div class="col-xs-4" style="float:left;">['.$r->first_name." ".$r->last_name.'] '.$r->email.'</div></label>';		
		  	 
		  }
			} 
			else
			{
				echo "No Bar Owner Founds";
			}?>
									</div>	
									<div class="clear"></div>
									<div id="taxiowner_list" class="op0">
										<?php if(!empty($operator_list_taxi_owner))
			{
		echo '<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll_taxi" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list_taxi_owner as $r)
		  {
		  			
						echo '<label style="width:350px; margin-bottom:10px;" class="checkbox wid228 pull-left"><input style="float:left;" type="checkbox" id="email'.$r->user_id.'" name="to_user_id[]" value="'.$r->email.'#taxi_owner" /><div class="col-xs-4" style="float:left;">['.$r->first_name." ".$r->last_name.'] '.$r->email.'</div></label>';		
		  	 
		  }
			} 
			else
			{
				echo "No Taxi Owner Founds";
			}?>
									</div>	
									<div class="clear"></div>
									<label style="display: none;" for="to_user_id[]" generated="true" class="error">Please Select User.</label><br>
									<div class="control_group">
										<label class="control_label">Subject :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" id="subject" name="subject" class="m_wrap wid360" />
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="description" id="description" placeholder="Description..." class="m_wrap span9 wid360 ckeditor" rows="20" cols="100"  ><?php echo $description; ?></textarea>
											<label for="description" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
									</div>
							</div>
							
							<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $admin_id;?>" />
							<input type="hidden" name="from_user_type" id="from_user_type" value="<?php echo ($admin_type=='1')?'admin':'';?>" />	
							
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
									<?php if($redirect_page == 'list_broadcast_message') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php }else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>
									
								<?php }else { ?>
									
									<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
									
									<?php if($redirect_page == 'list_broadcast_message') {?>
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