
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
     				<div class="result_search event"><div class="result_search_text"><i class="strip gallery"></i> Album</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
		     				<div class="dash-btngroup">
	     						<div id="hd_del">
	     							<button type="submit" class="btn btn-lg btn-primary marr_10" onclick="list_add()">Add</button>
		                       		<a class="btn btn-lg btn-primary marr_10" href="javascript:void(0)" onclick="setaction('chk[]','delete',   'frm_event');">Delete</a>
		                       		
	     						</div>
	     						<div id="hs_del" style="display: none;">
	     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
	     						</div>
     						</div>
     					<div id="list_hide_m">
     						<?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search','data-async'=>'','data-target'=>'.content');
					echo form_open('admin/search_bar_gallery/'.$limit,$attributes);?>
					<div class="search_block">
						<input type="hidden" name="limit" id="search-limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				     			<div class="search-strip">
				     				<form class="form-horizontal" role="form">
					                   <div class="form-group">
					                       <div class="col-sm-7 input_box pull-left" style="padding-left: 0;">
					                           <input type="text" name="event_keyword" id="event_keyword" class="form-control form-pad"  placeholder="Search By Title" onkeydown="if (event.keyCode == 13) { get_search_event(); return false; }" />
					                       </div>
					                       <div class="col-sm-2 input_box pull-left">
				                        		<button type="button" onclick="get_search_event()" id="search" class="btn btn-lg btn-primary search"><i class="strip search"></i></button>
				                       	   </div>
				                       	   <div class="col-sm-2 input_box pull-left">
				                        		<a href="<?php echo site_url('bar/bar_gallery')?>" class="btn btn-lg btn-primary search" type="submit"><i class="strip refresh"></i>
				                       	   </a></div>
				                       	   <div class="clearfix"></div>
					                    </div>
				                    </form>
				     			</div>
					     		
					     		<div class="clearfix"></div>
					     		</form>
					     	</div>
					     	</div>
     					<div id="list_hide" class="content">	
     						<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('bar/actiongallery',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table  class="table  sorted_table table border">
								<thead>
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th>Reorder</th>
									<th>Title</th>
									<th>Gallery Type</th>
									<th>Date</th>
									<th>Status</th>
									<th>Action</th>
								</thead>
								<tbody>
								<?php
								
								if($result)
								{
									$i=1;
									foreach($result as $event){								
								
								if ($i % 2 == 0)
										  {
										    $dark =  "dark";
										  }
										  else
										  {
										    $dark =  "light";
										  }?>	
									<tr data-id="<?php echo $event->bar_gallery_id; ?>" class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->bar_gallery_id; ?>'>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->bar_gallery_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->bar_gallery_id;?>" value="<?php echo $event->bar_gallery_id;?>"></label></td>
										<td ><i class="strip sort_icon"></i></td>
										<td><?php echo $event->title;?></td>
										<td><?php if($event->gallery=='gallery'){ echo  "Bar Gallery"; } else { echo "Postcard Gallery"; } ?></td>
										<td><?php echo $event->date_added;?></td>
										<td><?php echo ucfirst($event->status);?></td>
										<td>
											<a href="javascript://" onclick="editbargallery('<?php echo $event->bar_gallery_id; ?>')"><i class="strip edit_table"></i></a>
											<a href="javascript://" onclick="deletegallery('<?php echo $event->bar_gallery_id; ?>')" ><i class="strip delete"></i></a>
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="5">No bar galleries have been added.</td>
									</tr>	
										
									<?php } ?>	
								</tbody>
							</table>
							</div>
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
						</div>
						</form>
					</div>	
					
				<div id="list_show" style="display: none;" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_gallery/'.base64_encode($getbar['bar_id'])); ?>">
						<input type="hidden" name="bar_gallery_id" id="bar_gallery_id" value="" />
     				
		     			<div class="text-center pad_t15b20">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Title : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="title" name="title" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :  <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" name="description" id="description" placeholder="Description" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	
	                     <div id="hide_edit">
	                     	<div id="inner">  	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Gallery Image : <span class="aestrick"> * </span></label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                           		<input type="file" accept="image/*" class="form-control form-pad" id="photo_image" name="photo_image[]">
	                           		<input type="hidden" name="prev_event_image" id="prev_event_image" value="" />
	                           		<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />
														<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="" />	
														
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
	                       	</div>
	                      </div> 	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Gallery Type :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="gallery" id="gallery">
		                           		<option value="gallery">Bar Gallery</option>
		                           		<option value="postcard">Postcard Gallery</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Status :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="status" id="status">
		                           		<option value="active">Active</option>
		                           		<option value="inactive">Inactive</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/bar_gallery');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    
    <script>
   $("form#form").submit(function(){

    var formData = new FormData($(this)[0]);
   
   
    $.ajax({
        url: '<?php echo site_url('bar/add_gallery/'.base64_encode($getbar['bar_id']));?>',
        type: 'POST',
        data: formData,
        async: false,
         dataType : 'json',
         beforeSend: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    
		    	success : function ( json ) 
		    	{
		    		
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					   return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						if($('#event_id').val()=='')
						{
							$.growlUI('Your gallery add successfully .');
						}
						else
						{
							$.growlUI('Your gallery update successfully .');
						}
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	 $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					}
					$('#dvLoading').fadeOut('slow');
		   		},
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});
    $(document).ready(function(){
    	        $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 
        
       
		
    });
    
    function getData()
	{
	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
	var limit = $('#limit').val();
    var keyword = $("#event_keyword").val();
    
   
    if(keyword=='' || keyword==0)
    {
    	var keyword = '1V1';
    }
	var offset = $('#offset').val();
	var redirect_page=$('#redirect_page').val();
	var url='<?php echo site_url('bar/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
	$.ajax({
			url : url,
			cache: false,
			// beforeSend : function() {
				// blockUI('.portlet-body');
			// },
			success : function(response) {
				// alert(response);
				$('.content').html('');
				$('.content').html(response);
				setupLabel();
				bindJquery();
				//bindJquery();
			},
			// complete : function() {
				// unblockUI('.portlet-body');
			// },
	});
	
	}
    function list_add()
    {
    	$("#bar_gallery_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
    	$("#list_hide").slideUp();
    	$("#list_hide_m").slideUp();
    	$("#hd_del").slideUp();
    	$("#hs_del").slideDown();
    	
    	$('#list_show').slideDown();
    	
    	//$('#hide_edit').html('<div id="inner"><div class="padtb"><div class="col-sm-3 text-right"><label class="control-label">Gallery Image:</label></div><div class="input_box upload_btn"><input type="file" class="form-control form-pad" id="photo_image" name="photo_image[]"><input type="hidden" name="prev_event_image" id="prev_event_image" value="" /><input type="hidden" name="image_count" id="image_count" value="0" /><input type="hidden" name="cntpro" id="cntpro" value="0" /><input type="hidden" name="prev_photo_image" id="prev_photo_image" value="" /></div><a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a><div class="clearfix"></div></div></div>');
    	
    }
    
    function goto_main()
    {
    	$("#bar_gallery_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
		//$('#hide_edit').html('<div id="inner"><div class="padtb"><div class="col-sm-3 text-right"><label class="control-label">Gallery Image:</label></div><div class="input_box upload_btn"><input type="file" class="form-control form-pad" id="photo_image" name="photo_image[]"><input type="hidden" name="prev_event_image" id="prev_event_image" value="" /><input type="hidden" name="image_count" id="image_count" value="0" /><input type="hidden" name="cntpro" id="cntpro" value="0" /><input type="hidden" name="prev_photo_image" id="prev_photo_image" value="" /></div><a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a><div class="clearfix"></div></div></div>');
		
		 $.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/bargalleryimages')?>",
				   data : {id:$("#bar_gallery_id").val()},
				   dataType : 'html',
				   success: function(responsenew) {
				   	$("#hide_edit").html(responsenew);
				  }
			   });			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
</script>

<script>

$(document).ready(function(){	
	  bindJquery();	
	  $('.fancybox-video').fancybox({type: 'iframe'});
		
	 });	
	 $(".pagination li a").click(function() {
		  //alert("Handler for .click() called.");
		  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: $(this).attr("href"),
			   dataType: 'post', 
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			bindJquery();
			setupLabel();	
			
			return false;
			
		});
 function editbargallery(id)
 {
 		
 	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/bargallerydetail')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		      $("#bar_gallery_id").val(response.bar_gallery_id);
		      $("#title").val(response.title);
		      $("#description").val(response.description);
		      $("#status").val(response.status);
		      $("#gallery").val(response.gallery);
			  $("#list_hide").slideUp();
	    	  $("#list_hide_m").slideUp();
	    	  $("#hd_del").slideUp();
	    	  $("#hs_del").slideDown();
	    	  $('#list_show').slideDown();
	    	  bindJquery();
	    	  
	    	  $.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/bargalleryimages')?>",
				   data : {id:response.bar_gallery_id},
				   dataType : 'html',
				   success: function(responsenew) {
				   	$("#hide_edit").html(responsenew);
				  }
			   });
		  }
	   });
	   
	   
 }
 function get_search_event()
 {
 	  var event_keyword = $("#event_keyword").val();
 	  var limit = $("#limit").val();
 	  var offset = 0; 
 	  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/bar_gallery/')?>',
			   dataType: 'post', 
			   data : {event_keyword:event_keyword,limit:limit,offset:offset},
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			 $('.label_check').removeClass('c_on');
                    $('.checkboxes').removeAttr('Checked'); 
                    bindJquery();
 }
 
 function deletegallery(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this gallery?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/bargallerydelete/')?>',
			   dataType: 'post', 
			   data : {id:id},
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
				complete: function(){
				     $('#dvLoading').fadeOut('slow');
				     getData();
				     $("#remove_event_"+id).remove();
				     $.growlUI('Your gallery deleted successfully .');
				    }
				}).responseText;
				bindJquery();
			}
			return false;
			
 });
 }
 
 function bindJquery()
	{
		
		jQuery('.group-checkable').change(function () {
	                if ($('.label_check input').length) {
			            $('.label_check').each(function(){ 
			                $(this).removeClass('c_on');
			                            $('.checkboxes').removeAttr('Checked'); 
			            });
			            $('.label_check input:checked').each(function(){ 
			            	
			               // $(this).parent('label').addClass('c_on');
			                $( ".radio-checkbox" ).addClass( "c_on" ); 
			                            $('.checkboxes').attr('Checked','Checked'); 
			                  //  $('#states').find('span').addClass('checked');        
			            });                
			        };
	            });
	
	}

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
    
    function setaction(elename, actionval, formname) {

	vchkcnt=0;
	elem = document.getElementsByName(elename);
	
	
	for(i=0;i<elem.length;i++){
		if(elem[i].checked) vchkcnt++;
		//vchkcnt++;
			
	}
	if(vchkcnt==0) {
			alertify.alert("Please select a record .");
			return false;
	} else {
		
		alertify.confirm("Are you sure you want to delete this gallery?", function (e) {
				if (e) {
			document.getElementById('action').value=actionval;	
			//$('#frm_admin').submit();
		var $form = $('#actionevent');
        var $target = $($form.attr('data-target'));
 		var limit=$('#limit').val();
 		var offset=$('#offset').val();
 		var keyword=$('#event_keyword').val();
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            cache: false,
            dataType:'json',
            data: $form.serialize(),
            beforeSend : function() {
				$('#dvLoading').fadeIn('slow');
			},success: function(res, status) {
				// alert(res);
                if(res.status=='done'){
                	$.growlUI('Your gallery deleted successfully .'); 
                	getData();	
                }
                
            },complete : function() {
				$('#dvLoading').fadeOut('slow');
			},
        });
		}		
		else
		{
			return false;
		}
		});
	}
}

$('#add_row').click(function(){
	
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="col-sm-3 text-right"><label class="control-label"></label></div><div class="input_box upload_btn" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><div class="input_box upload_btn"><span class="fileupload-exists"></div><input type="file" class="form-control form-pad" name="photo_image[]" id="photo_image_'+cnt+'" /></span></div><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
			
		});
		
		
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
		alertify.confirm("Are you sure you want to delete this gallery image?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removeImageAjax') ?>/'+id,
				success:function(res){
				var cnt=parseInt($('#cnt').val())-1;
	           // alert(cnt);
				$('#cntpro').val(cnt);
				$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your gallery image deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
</script>

