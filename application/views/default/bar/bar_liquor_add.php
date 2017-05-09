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
<div id="list_show" style="display: none;" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_liquor/'.base64_encode($getbar['bar_id'])); ?>">
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
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/bar_liquor');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
     			</div>
</div>
</div>