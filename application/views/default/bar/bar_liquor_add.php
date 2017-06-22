<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.css" />

<script>
	 var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Suggest New Liquor</a>';
	
</script>
<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view(getThemeName().'/bar/liquor_suggest');?>
</div>	
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip liquor"></i> Liquors</div></div>
		     		<div class="dashboard_subblock">
                                    <div>
					
				<div id="list_show" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_liquor/'.base64_encode($getbar['bar_id'])."/bar_liquor"); ?>">
						<!-- <input type="hidden" name="event_id" id="event_id" value="" /> -->
     				
		     			<div class="text-center pad_t15b20">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Add Liquor : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<!-- <input type="text" class="form-control form-pad tags" id="liquor_id" name="liquor_id" value=""> -->
	                           		<select style="display: block ; z-index: 0; border: solid 1px #C57B00!important; background: rgb(43, 41, 35);" id="tokenize" name="liquor_id[]" class="tokenize-sample m_wrap" multiple="multiple">
				                     
				                    </select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-3 mart10 text-left" style="margin-left:1%; margin-right:-8%">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/bar_liquor');?>" >Cancel</a>
	                       		</div>
                                        <div class="col-sm-5" style="margin-top:10px;">
                                            <div class="pull-right">
                                                <label class="control-label">Can't find a liquor?</label>
                                                    <a href="#suggestmodal" onclick="blank()"  data-toggle="modal" class="btn btn-lg btn-primary" style="margin-right:10px;">Suggest New Liquor</a>
                                            </div>
                                            
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
    <div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                                                <?php echo $this->load->view(getThemeName().'/bar/liquor_suggest');?> 
                                            </div>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
    <script>
   
   
$(document).ready(function(){
	 $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 	
	  bindJquery();	
	 var arrVal = new Array();
	var t = $("[class=user_type]").val();
	$('.tags').tagsInput({
		autocomplete_url:'<?php echo site_url('bar/getallliquorbybar/');?>',
		itemValue: 'value',
		itemText: 'text',
		autocomplete:{
		   source: function(request, response) {
		  var t = <?php echo $getbar['bar_id']; ?>;
			  $.ajax({
				 url: "<?php echo site_url('bar/getallliquorbybar');?>",
				 dataType: "json",
				 data: {
				   	utype : t,
					em: request.term,
					
				 },
				 success: function(data) {
					response( $.map( data, function( item ) {
						return {
							label: item.label,
							value: item.value
						}
					}));
				}
			  })
		   },
		}
	});
        list_add();
	 });
        
        /*$('#form').validate(
		{
		rules: {
					'liquor_id[]': {
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
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
					$("#cm-err-main1").html('Liquor Name Field is required');
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
							$.growlUI('Your liquor add successfully .');
						}
						else
						{
							$.growlUI('Your liquor update successfully .');
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
		})*/
		
		
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
			cache: false,
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
		   // url: "<?php //echo site_url('bar/getallliquorbybar')?>",
		   // data : {id:<?php //echo  $getbar['bar_id']; ?>},
		   // dataType : 'json',
		   // success: function(response) {
		   	// $("#liquor_id").empty();
		   	    // $(".search-choice").remove();
		   	    // $('.result-selected').removeClass('result-selected').addClass('active-result');
		   	    // $('#liquor_id').html(response.result1);
		   	    // $('.chzn-results').html(response.result2);
// 		   
		     // $(".chosen").each(function () 
		   	// {
	            // $(this).chosen({
	                // allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
	            // });
        	// });
// 		       
		      // } 
	   // });
    	$("#event_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
		//$("#liquor_id").val('');
		
		$("#liquor_id_tagsinput span").remove();			 	
    	$("#list_hide").slideUp();
    	$("#list_hide_m").slideUp();
    	$('#tokenize').data('tokenize').clear();
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
 
 function get_search_event()
 {
 	  var event_keyword = $("#event_keyword").val();
 	  var limit = $("#limit").val();
 	  var offset = 0; 
 	  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/bar_liquor/')?>',
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
			    setupLabel();
				bindJquery();
 }
 
 function deleteliquor(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this liquor?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/barliquordelete/')?>',
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
				     $.growlUI('Your liquor deleted successfully .');
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
		
		alertify.confirm("Are you sure you want to delete this liquor?", function (e) {
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
                	$.growlUI('Your liquor deleted successfully .'); 
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
	     datas: ""+base_url+"bar/getallliquorbybar_new/?bar_id=<?php echo $getbar['bar_id'];?>/"
	});
</script>

