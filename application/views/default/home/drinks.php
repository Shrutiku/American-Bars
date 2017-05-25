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
                        <?php			 
                        $attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
                        echo form_open('bar/actionbeer',$attributes);?> 
                        <input type="hidden" name="action" id="action" />
                            <div class="table-responsive">
                                <div id="responsecomment">
                                    <div class="pagination" id="at_ajax">
                                        <?php // echo $page_link;?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <table class="table">
                                        <thead>
                                            <th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
                                            <th>Beer Name</th>
                                            <th>Type</th>
                                            <th>Producer</th>
                                            <th>Served As</th>
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
                                                <tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->beer_bar_id; ?>'>
                                                    <td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->beer_bar_id;?>">
                                                            <input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->beer_bar_id;?>" value="<?php echo $event->beer_bar_id;?>"></label></td>
                                                    <td><?php echo $event->beer_name;?></td>
                                                    <td><?php echo $event->beer_type;?></td>
                                                    <td><?php echo $event->producer;?></td>
                                                    <td>
                                                            <label class="radio-checkbox label_check c_on" for="checkbox-tap<?php echo $event->beer_bar_id; ?>">
                                                            <input <?php if($event->tap=='yes'){ ?>checked<?php } ?> onchange="ChangeState('<?php echo $event->beer_bar_id; ?>','tap')"  type="checkbox"  class="checkboxes" name="tap" id="checkbox-tap<?php echo $event->beer_bar_id; ?>" value="<?php echo $event->tap; ?>">Tap</label>
                                                            <label class="radio-checkbox label_check c_on" for="checkbox-bottle<?php echo $event->beer_bar_id; ?>">
                                                            <input <?php if($event->bottle=='yes'){?>checked<?php } ?> onchange="ChangeState1('<?php echo $event->beer_bar_id; ?>','bottle')" type="checkbox"  class="checkboxes" name="bottle" id="checkbox-bottle<?php echo  $event->beer_bar_id;?>" value="<?php echo $event->bottle; ?>">Bottle</label>
                                                    </td>
                                                    <td>
                                                        <!-- <a href="javascript://" onclick="editbarevent('<?php echo $event->beer_id; ?>')"><i class="strip edit_table"></i></a> -->
                                                        <a href="javascript://" onclick="deletebeer('<?php echo $event->beer_bar_id; ?>')" ><i class="strip delete"></i></a>
                                                        <a onclick="morelink('<?php echo $event->beer_bar_id; ?>')"><i class="strip view"></i></a>

                                                        <div class="modal fade" id="myModalnew_open_<?php echo $event->beer_bar_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="padtb10">
                                                                <div>
                                                                    <div class="result_box clearfix mar_top30bot20">
                                                                        <div class="login_block br_green_yellow">
                                                                            <div class="result_search">
                                                                             <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                            <i class="strip login_icon"></i><div class="result_search_text">Beer Description </div>
                                                                            </div>
                                                                        <div class="pad20">
                                                                                <label class="control-label" style="color: #fff;"><?php echo $event->beer_desc; ?></label>	
                                                                        </div>		
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            </div>
                                                    </td>
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
<!--                                <input type="hidden" name="redirect_page" id="redirect_page" value="<?php // echo $redirect_page;?>"/>
                                <input type="hidden" name="offset" id="offset" value="<?php // echo ($offset!='')?$offset:0; ?>" />
                                <input type="hidden" name="limit" id="limit" value="<?php // echo ($limit>0)?$limit:10; ?>" />-->
                            </div>
                        </form>
                    </div>	





                    <div class="fullmug_block" style="width: 100%; padding-left: 3%">
                        <?php // if($getbar['bar_type']=='full_mug'){?>
                        <?php // } ?>
                        <div class="col-md-4 coctail-new col-sm-12 padb20">
                            <h2  style="align: center;">Beers
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_beer');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_beer');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
                                        <!--<h1 class="box_title">Beers</h1>-->
                                        <ul class="bottom_box" id="infinite-list">

                                <div class="clear"></div></ul><div class="clear"></div>
                                </div>
                        </div>
                        <div class="col-md-4 coctail-newright col-sm-12 padb20">
                            <h2  style="align: center;">Cocktails
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_cocktail');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_cocktail');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
                                        <!--<h1 class="box_title">Cocktails</h1>-->
                                        <ul class="bottom_box" id="infinite-list-cocktail">

                                <div class="clear"></div></ul><div class="clear"></div>
                                </div>
                        </div>     		
                        <div class="col-md-4 coctail-newright col-sm-12 padb20">
                            <h2  style="align: center;">Liquors
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_liquor');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_liquor');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
                                        <!--<h1 class="box_title">Liquors</h1>-->
                                        <ul class="bottom_box" id="infinite-list-liquor">

                                <div class="clear"></div></ul><div class="clear"></div>
                                </div>
                        </div>	
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
							$.growlUI('Your beer was added successfully .');
						}
						else
						{
							$.growlUI('Your beer list was updated successfully .');
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
		});
                
                
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
</script>
                     
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
<script type="text/javascript">
    $(function(){
        $('#infinite-list').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });
          $('#infinite-list-cocktail').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });
        $('#infinite-list-liquor').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });
      });
    var base_url = "<?php echo base_url();?>";
    $('#tokenize').tokenize({
      // datas: '<?php //echo base_url(); ?>+"advertisement/getAllCityOrZipcode/city/"'
         datas: ""+base_url+"bar/getallbeerbybar_new/?bar_id=<?php echo $getbar['bar_id'];?>/"
    });
</script>
<!--------------End Scroll ------------------->
<style>
    #gmap_marker {
        height: 322px;
        width: 100%;
    }
    .gm-style-iw {
        color:#000000;
    }
    #infinite-list {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-cocktail {
        height: 410px;
        background: '#222018',
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-liquor {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #drink-btn {
        padding: auto;
        padding-top: 1%;
        padding-bottom: 1%;
    }
</style>
<?php $theme_url = $urls= base_url().getThemeName();?>
<script>
//	var base_url = '<?php // echo site_url('bar/getmorebeer/?bar_id='.$bar_detail['bar_id']); ?>';
//	var base_url_cocktail = '<?php // echo site_url('bar/getmorecocktail/?bar_id='.$bar_detail['bar_id']); ?>';
//	var base_url_liquor = '<?php // echo site_url('bar/getmoreliquor/?bar_id='.$bar_detail['bar_id']); ?>';
        var base_url = '<?php echo site_url('bar/getmorebeer/?bar_id='.$getbar['bar_id']); ?>';
	var base_url_cocktail = '<?php echo site_url('bar/getmorecocktail/?bar_id='.$getbar['bar_id']); ?>';
	var base_url_liquor = '<?php echo site_url('bar/getmoreliquor/?bar_id='.$getbar['bar_id']); ?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
<script type="text/javascript">InfiniteList.loadData(0,0); InfiniteList.loadData_cocktail(0,15);InfiniteList.loadData_liquor(0,15);</script>