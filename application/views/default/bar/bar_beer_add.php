<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.css" />


<script>
	 var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Suggest New Beer</a>';
	
</script>

<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip beers"></i> Beers</div></div>
		     		<div class="dashboard_subblock">
		     			<div>     										
				<div id="list_show" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="form" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_beer/'.base64_encode($getbar['bar_id']),"/bar_beer"); ?>">
						<!-- <input type="hidden" name="event_id" id="event_id" value="" /> -->
     				
		     			<div class="text-center pad_t15b20">
		     				
		     				
		     				
		     				<div class="padtb">
		     					<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Add Beer : <span class="aestrick"> * </span></label>
	        				 	</div>
										<div class="input_box col-sm-7">
											<!-- <select data-placeholder="Add Beer" name="beer_id[]" id="beer_id" style="width:100%; height: 100px;" class="chosen select_box" multiple="multiple" tabindex="6">
												<option value=""></option>
											   
											</select> -->
											
											<select style="display: block ; z-index: 0; border: solid 1px #C57B00!important; background: rgb(43, 41, 35);" id="tokenize" name="beer_id[]" class="tokenize-sample m_wrap" multiple="multiple">
				                     
				                    </select>
										</div>
									</div>
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Add Beer : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad tags" id="beer_id1" name="beer_id1" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/add_drink');?>" >Cancel</a>
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

<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
    
    <script>
   function morelink(id)
    {
    	  $("#myModalnew_open_"+id).modal('show');
    }
    function ChangeState(id,val)
   {
   	 //var acc_type = "dig";
   	// var value = $("#is_sales"+acc_id).val();
   	 
   	 var tapval = $("#checkbox-tap"+id).val();
   	 //alert(value);
   	 //return false;
	 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/ChaneState/');?>',
			   data: {id:id,val:val,tapval:tapval},
			   dataType: 'post', 
			   cache: false,
			     beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			   },
			    success : function () 
		    	{
		    		$.growlUI('Record update successfully .');
		    	},
			   async: false                     
			}).responseText;	
	 if($("#checkbox-tap"+id).val()=='no')
	 {
	 	 $("#checkbox-tap"+id).val('yes');
	 }		
	 else
	 {
	 	$("#checkbox-tap"+id).val('no');
	 }
   }
   
   function ChangeState1(id,val)
   {
   	 //var acc_type = "dig";
   	// var value = $("#is_sales"+acc_id).val();
   	 
   	 var tapval = $("#checkbox-bottle"+id).val();
   	 //alert(value);
   	 //return false;
	 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/ChaneState1/');?>',
			   data: {id:id,val:val,tapval:tapval},
			   dataType: 'post', 
			     beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			   },
			   success : function () 
		    	{
		    		$.growlUI('Record update successfully .');
		    	},
			   cache: false,
			   async: false                     
			}).responseText;	
	 if($("#checkbox-bottle"+id).val()=='no')
	 {
	 	 $("#checkbox-bottle"+id).val('yes');
	 }		
	 else
	 {
	 	$("#checkbox-bottle"+id).val('no');
	 }
   }
$(document).ready(function(){
	
	 $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 	
	  bindJquery();	
	 var arrVal = new Array();
	var t = $("[class=user_type]").val();
	
	 });
        
        $('#form').validate(
		{
		rules: {
					'beer_id[]': {
							required: true,
					},
					
					
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
		$(form).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
					if(json.status == "fail" )
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html('Beer Name Field is required');
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
							$.growlUI('Your beer add successfully .');
						}
						else
						{
							$.growlUI('Your beer update successfully .');
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
		   		 }
		    });
		  }
                  list_add();
		})
		
		
    function getData()
	{
	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
	var limit = $('#limit').val();
    var keyword = $("#event_keyword").val();
    if(keyword=='')
    {
    	var keyword = '1V1';
    }
	var offset = $('#offset').val();
	var redirect_page=$('#redirect_page').val();
	var url='<?php echo site_url('bar/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
	$.ajax({
			url : url,
			// beforeSend : function() {
				// blockUI('.portlet-body');
			// },
			  beforeSend : function(){
			      
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			   },
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
    		$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
    	 // $.ajax({
	       // type: "POST",
		   // url: "<?php //echo site_url('bar/getallbeerbybar')?>",
		   // data : {id:<?php //echo  $getbar['bar_id']; ?>},
		   // dataType : 'json',
		   // beforeSend : function(){
			      // $('#dvLoading').fadeIn('slow');
			   // },
			   // complete: function(){
// 			   
			     // $('#dvLoading').fadeOut('slow');
// 			     
			   // },
		   // success: function(response) {
// 		   	
		   	    // $(".search-choice").remove();
		   	    // $('.result-selected').removeClass('result-selected').addClass('active-result');
		   	    // $('#beer_id').html(response.result1);
		   	    // $('.chzn-results').html(response.result2);
		     // $(".chosen").each(function () 
		   	// {
	            // $(this).chosen({
	                // allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
	            // });
        	// });
// 		   
// 		       
		      // } 
	   // });
    	$("#event_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
		$("#beer_id").val('');
		$('#tokenize').data('tokenize').clear();
		$("#beer_id_tagsinput span").remove();			 	
    	$("#list_hide").slideUp();
    	$("#list_hide_m").slideUp();
    	$("#hd_del").slideUp();
    	$("#hs_del").slideDown();
    	$('#list_show').slideDown();
    	
    }
    
    function goto_main()
    {
    		$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
    	$("#event_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
</script>

<script>
	
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
 function editbarevent(id)
 {
 			$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
 	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/bareventdetail')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		   
		      $("#event_id").val(response.event_id);
		      $("#event_title").val(response.event_title);
		      $("#event_desc").val(response.event_desc);
		      $("#start_date").val(response.start_date);
		      $("#end_date").val(response.end_date);
		      $("#address").val(response.address);
		      $("#city").val(response.city);
		      $("#state").val(response.state);
		      $("#phone").val(response.phone);
		      $("#zipcode").val(response.zipcode);
		      $("#event_video_link").val(response.event_video_link);
		      $("#is_power_boost_event").val(response.is_power_boost_event);
		      $("#status").val(response.status);
		      $("#prev_event_image").val(response.event_image);
		      $("#prev_event_video").val(response.event_video);
		      
		      if(response.event_video!='')
		      {
		      		 var src_vid = '<?php echo base_url().'upload/event_video/'?>';
		      	     var htm = '<a href="'+src_vid+response.event_video+'" id="video_add" class="image_play fancybox-video">'+response.event_video+'</a>';
		      	   //  $("#video_add").attr("href", src_vid+response.event_video);
		      		 $("#prev_event_video_htm").html(htm);
			  }
		     
		      if(response.event_image!='')
		      {
		      		var src1 = '<?php echo base_url().'upload/event_thumb/'?>';
					$("#img_here").attr("src", src1+response.event_image);
			 }
		      $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
	    	bindJquery();
		     
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
			   url: '<?php echo site_url('bar/bar_beer/')?>',
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
			//bindJquery();
			 $('.label_check').removeClass('c_on');
                    $('.checkboxes').removeAttr('Checked'); 
                    bindJquery();
 }
 
 function deletebeer(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this beer?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/barbeerdelete/')?>',
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
				     $.growlUI('Your beer deleted successfully .');
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
		
		alertify.confirm("Are you sure you want to delete this beer?", function (e) {
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
                	$.growlUI('Your beer deleted successfully .'); 
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
var base_url = "<?php echo base_url();?>";
 $('#tokenize').tokenize({
	  // datas: '<?php //echo base_url(); ?>+"advertisement/getAllCityOrZipcode/city/"'
	     datas: ""+base_url+"bar/getallbeerbybar_new/?bar_id=<?php echo $getbar['bar_id'];?>/"
	});
</script>

