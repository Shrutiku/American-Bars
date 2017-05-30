<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.css" />


<!--<script>
    var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Select a settings function</a>';
	
</script>-->

<!--<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <?php //echo $this->load->view(getThemeName().'/bar/cocktail_suggest');?>
</div>	-->
<input type="hidden" name="beerval" id="beerval" value="0" />
<input type="hidden" name="cocktailval" id="cocktailval" value="0" />
<input type="hidden" name="liquorval" id="liquorval" value="0" />
<?php $theme_url = $urls= base_url().getThemeName();?>
<div class="wrapper row6 padtb10 has-js">
    <div class="container">
        <div class="margin-top-50 bg_brown">
                <?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>

            <div class="dashboard_detail">
                <div class="result_search">
                        <div class='pull-left'><div class="result_search_text"><i class="strip cocktails"></i>Drinks on Your Menu</div></div>
                    <div class="clear"></div>
                </div>
                <div class="dashboard_subblock">
                    <div id="list_hide" class="content">	

                        <div class="col-md-4 col-sm-12 padb20">
                            <div class="marr_10">
                                <h2  style="align: center;">Cocktails
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_cocktail');?>">Edit</a>
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_cocktail');?>">Add</a>
                                </h2>

                                <?php			// BEGIN SMALL COCKTAIL TABLE 
                                $attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
                                echo form_open('bar/actionbeer',$attributes);?> 
                                <input type="hidden" name="action" id="action" />
                                    <div class="table-responsive">
                                        <div id="responsecomment">
                                            <div class="pagination" id="at_ajax">
                                                <?php echo $page_link;?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <table class="table">
                                                <thead>
                                                    <th>Cocktail Name</th>
                                                    <!--<th>Type</th>-->
                                                </thead>
                                                <tbody>
                                                <?php


                                                if($resultCocktail)
                                                {
                                                    $i=1;
                                                    foreach($resultCocktail as $event){								

                                                if ($i % 2 == 0)
                                                    {
                                                      $dark =  "dark";
                                                    }
                                                    else
                                                    {
                                                      $dark =  "light";
                                                    }?>	
                                                        <tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->cocktail_bar_id; ?>'>
                                                            <td><?php echo $event->cocktail_name;?></td>
                                                            <!--<td><?php // echo $event->type;?></td>-->
                                                        </tr>
                                                <?php $i++; } } else { ?>
                                                        <tr>
                                                                <td colspan="6">No cocktails found at your bar.</td>
                                                        </tr>	

                                                        <?php } ?>	
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <p class="mug_count" style="text-align: center;">Total: <a href="<?php echo site_url('bar/bar_beer')?>"><?php echo $this->home_model->countcocktail(@$getbar['bar_id']);?></a></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-12 padb20">
                            <div class="marr_10">
                                <h2  style="align: center;">Beers
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_beer');?>">Edit</a>
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_beer');?>">Add</a>
                                </h2>

                                <?php			// BEGIN SMALL BEER TABLE 
                                $attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
                                echo form_open('bar/actionbeer',$attributes);?> 
                                <input type="hidden" name="action" id="action" />
                                    <div class="table-responsive">
                                        <div id="responsecomment">
                                            <div class="pagination" id="at_ajax">
                                                <?php echo $page_link;?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <table class="table">
                                                <thead>
                                                    <th>Beer Name</th>
                                                    <th>Type</th>
                                                </thead>
                                                <tbody>
                                                <?php


                                                if($resultBeer)
                                                {
                                                    $i=1;
                                                    foreach($resultBeer as $event){								

                                                if ($i % 2 == 0)
                                                    {
                                                      $dark =  "dark";
                                                    }
                                                    else
                                                    {
                                                      $dark =  "light";
                                                    }?>	
                                                        <tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->beer_bar_id; ?>'>
                                                            <td><?php echo $event->beer_name;?></td>
                                                            <td><?php echo $event->beer_type;?></td>
                                                            <input type="hidden" name="beer_bar_id" id="beer_bar_id" value="<?php echo $event->beer_bar_id; ?>" />
                                                        </tr>
                                                <?php $i++; } } else { ?>
                                                        <tr>
                                                                <td colspan="6">No beers found at your bar.</td>
                                                        </tr>	

                                                        <?php } ?>	
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <p class="mug_count" style="text-align: center;">Total: <a href="<?php echo site_url('bar/bar_beer')?>"><?php echo $this->home_model->countbeer(@$getbar['bar_id']);?></a></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-12 padb20">
                            <div>
                                <h2  style="align: center;">Liquors
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_liquor');?>">Edit</a>
                                    <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_liquor');?>">Add</a>
                                </h2>

                                <?php			// BEGIN SMALL LIQUOR TABLE 
                                $attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
                                echo form_open('bar/actionbeer',$attributes);?> 
                                <input type="hidden" name="action" id="action" />
                                    <div class="table-responsive">
                                        <div id="responsecomment">
                                            <div class="pagination" id="at_ajax">
                                                <?php echo $page_link;?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <table class="table">
                                                <thead>
                                                    <th>Liquor Name</th>
                                                    <th>Type</th>
                                                </thead>
                                                <tbody>
                                                <?php


                                                if($resultLiquor)
                                                {
                                                    $i=1;
                                                    foreach($resultLiquor as $event){								

                                                if ($i % 2 == 0)
                                                    {
                                                      $dark =  "dark";
                                                    }
                                                    else
                                                    {
                                                      $dark =  "light";
                                                    }?>	
                                                        <tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->beer_bar_id; ?>'>
                                                            <td><?php echo $event->liquor_title;?></td>
                                                            <td><?php echo $event->type;?></td>
                                                        </tr>
                                                <?php $i++; } } else { ?>
                                                        <tr>
                                                                <td colspan="6">No beers found at your bar.</td>
                                                        </tr>	

                                                        <?php } ?>	
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                                <p class="mug_count" style="text-align: center;">Total: <a href="<?php echo site_url('bar/bar_beer')?>"><?php echo $this->home_model->countliquor(@$getbar['bar_id']);?></a></p>
                            </div>
                        </div>
                        
                        
                    </div>	
                    
                </div>
            </div>
        </div>
    </div>
</div>

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
//    $(document).ready(function(){
//	
//	 $('.label_check, .label_radio').click(function(){
//    	        	
//            setupLabel();
//        });
//        setupLabel(); 	
//	  bindJquery();	
//	 var arrVal = new Array();
//	var t = $("[class=user_type]").val();
//	
//	 });
//        
//        $('#form').validate(
//		{
//		rules: {
//					'beer_id[]': {
//							required: true,
//					},
//					
//					
//						errorClass:'error fl_right'
//				},
//				
//		submitHandler: function(form){
//		$(form).ajaxSubmit({
//		type: "POST",
//		   		 dataType : 'json',
//				 beforeSubmit: function() 
//				 {
//		       		$('#dvLoading').fadeIn('slow');
//		    	 },
//		    	
//		    	uploadProgress: function ( event, position, total, percentComplete ) {	
//		        },
//		    
//		    	success : function ( json ) 
//		    	{
//					if(json.status == "fail" )
//					{
//						$("#cm-err-main1").show();
//						$("#cm-err-main1").html('Beer Name Field is required');
//			    		$('#dvLoading').fadeOut('slow');
//			    		scrollToDiv('cm-err-main1');
//				  		// setTimeout(function () 
//						// {
//						      // $("#cm-err-main1").fadeOut('slow');
//						// }, 3000);
//					return false;
//					}
//			
//					else
//					{
//						//alert("sdsa");
//						$("#cm-err-main1").hide();
//						$("#cm-err-main1").html("");
//						if($('#event_id').val()=='')
//						{
//							$.growlUI('Your beer was added successfully .');
//						}
//						else
//						{
//							$.growlUI('Your beer list was updated successfully .');
//						}
//						$(':input','#form')
//					 	.not(':button, :submit, :reset, :hidden')
//					 	.val('')
//					 	//.removeAttr('checked')
//					 	.removeAttr('selected');
//					 	 $("#list_hide").slideDown();
//					 	 $("#list_hide_m").slideDown();
//					     $("#hd_del").slideDown();
//					     $("#hs_del").slideUp();
//					     $('#list_show').slideUp();
//					     $("#at_ajax").remove();
//					     getData();
//					     
//					}
//					$('#dvLoading').fadeOut('slow');
//		   		 }
//		    });
//		  }
//		});
//                
//                
//    function getData()
//	{
//	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
//	var limit = $('#limit').val();
//    var keyword = $("#event_keyword").val();
//    if(keyword=='')
//    {
//    	var keyword = '1V1';
//    }
//	var offset = $('#offset').val();
//	var redirect_page=$('#redirect_page').val();
//	var url='<?php //echo site_url('bar/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
//	
//	
//	$.ajax({
//			url : url,
//			// beforeSend : function() {
//				// blockUI('.portlet-body');
//			// },
//			  beforeSend : function(){
//			      
//			      $('#dvLoading').fadeIn('slow');
//			   },
//			   complete: function(){
//			   
//			     $('#dvLoading').fadeOut('slow');
//			     
//			   },
//			success : function(response) {
//				// alert(response);
//				$('.content').html('');
//				$('.content').html(response);
//				setupLabel();
//				bindJquery();
//				
//				
//				//bindJquery();
//			},
//			// complete : function() {
//				// unblockUI('.portlet-body');
//			// },
//	});
//	
//	}
//        
//        function bindJquery()
//	{
//		
//		
//		jQuery('.group-checkable').change(function () {
//			
//	                if ($('.label_check input').length) {
//			            $('.label_check').each(function(){ 
//			                $(this).removeClass('c_on');
//			                            $('.checkboxes').removeAttr('Checked'); 
//			            });
//			            $('.label_check input:checked').each(function(){ 
//			            	
//			               // $(this).parent('label').addClass('c_on');
//			                $( ".radio-checkbox" ).addClass( "c_on" ); 
//			                            $('.checkboxes').attr('Checked','Checked'); 
//			                  //  $('#states').find('span').addClass('checked');        
//			            });                
//			        };
//	            });
//	
//	}
//
// function setupLabel() {
//        if ($('.label_check input').length) {
//            $('.label_check').each(function(){ 
//                $(this).removeClass('c_on');
//            });
//            $('.label_check input:checked').each(function(){ 
//                $(this).parent('label').addClass('c_on');
//            });                
//        };
//        if ($('.label_radio input').length) {
//            $('.label_radio').each(function(){ 
//                $(this).removeClass('r_on');
//            });
//            $('.label_radio input:checked').each(function(){ 
//                $(this).parent('label').addClass('r_on');
//            });
//        };
//    };
//    var base_url = "<?php echo base_url();?>";
//    $('#tokenize').tokenize({
//      // datas: '<?php //echo base_url(); ?>+"advertisement/getAllCityOrZipcode/city/"'
//         datas: ""+base_url+"bar/getallbeerbybar_new/?bar_id=<?php echo $getbar['bar_id'];?>/"
//    });
//</script>
                     
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>

<!--------------End Scroll ------------------->

<?php $theme_url = $urls= base_url().getThemeName();?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
<script type="text/javascript">InfiniteList.loadData(0,0); InfiniteList.loadData_cocktail(0,15);InfiniteList.loadData_liquor(0,15);</script>