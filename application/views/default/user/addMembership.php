<?php
  $theme_url = $urls= base_url().getThemeName();
?>
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Add Membership Plan</h1>
  		<!-- <div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  			</select>
	  			<input type="text" name="textbox1" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
	  			<button type="submit" class="button fl_left">Search</button>
	  			<div class="clear"></div>
  			</div><div class="form-control">
  			<div class="fl_right">
	  			<label class="fl_left search_label mart7 marr10">Sort By :</label>
	  			<select class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  			</select>
	  			<div class="clear"></div>
  			</div>
  			<div class="clear"></div>
  		</div> -->
  	</div>
  	<?php $attributes = array('id'=>'frm_membership_add','name'=>'frm_membership_add','class'=>'form_horizontal');
							echo form_open('membership_plan/add_membership_plan',$attributes); ?>
  	<div class="row">
  		<div class="left_block">
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Title :</label>
	  			<div class="form-control">
	  			<input type="text" name="plan_title" id="plan_title" value="<?php if(isset($plan_title)){ echo $plan_title; } ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Category :</label>
	  			<div class="form-control">
	  			<select name="category" id="category" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="video" <?php echo ($category=='video')?'selected="selected"':''; ?>>Video</option>
	  				<option value="article" <?php echo ($category=='article')?'selected="selected"':''; ?>>Article</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart20 marr10 ">Description :</label>
	  			<div class="form-control">
	  			<textarea class="textarea wrap large br_silver" id="description" name="description" rows="8"><?php if(isset($description)){ echo $description; }  ?></textarea>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Price :</label>
	  			<div class="form-control">
	  			<input type="text" name="price" id="price" value="<?php if(isset($price)){ echo $price; }  ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">No. of Months :</label>
  				<div class="form-control">
	  			<select id="total_month" name="total_month" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="1"  <?php echo ($total_month=='1')?'selected="selected"':''; ?>>1</option>
	  				<option value="2"  <?php echo ($total_month=='2')?'selected="selected"':''; ?>>2</option>
	  				<option value="3" <?php echo ($total_month=='3')?'selected="selected"':''; ?>>3</option>
	  				<option value="4" <?php echo ($total_month=='4')?'selected="selected"':''; ?>>4</option>
	  				<option value="5" <?php echo ($total_month=='5')?'selected="selected"':''; ?>>5</option>
	  				<option value="6" <?php echo ($total_month=='6')?'selected="selected"':''; ?>>6</option>
	  				<option value="7" <?php echo ($total_month=='7')?'selected="selected"':''; ?>>7</option>
	  				<option value="8" <?php echo ($total_month=='8')?'selected="selected"':''; ?>>8</option>
	  				<option value="9" <?php echo ($total_month=='9')?'selected="selected"':''; ?>>9</option>
	  				<option value="10" <?php echo ($total_month=='10')?'selected="selected"':''; ?>>10</option>
	  				<option value="11" <?php echo ($total_month=='11')?'selected="selected"':''; ?>>11</option>
	  				<option value="12" <?php echo ($total_month=='12')?'selected="selected"':''; ?>>12</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  				<input type="hidden" name="membership_plan_id" id="membership_plan_id" value="<?php if(isset($membership_plan_id)){ echo $membership_plan_id; } ?>" />
  			<div class="form-control-div text-center mart20">
				<button type="submit" name="b1" class="button marr10">Save</button>
				<button type="submit" name="b1" class="button">Cancel</button>
			</div>
	
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url; ?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>
	</form>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_membership_add").validate({
		rules: {
			
			plan_title: {
				required: true,
			},
			
			category: {
				required: true,
				
			},
			description: {
				required: true,
			},
			price: {
				required: true,
			},
			total_month: {
				required: true,
			},
			
		  	errorClass:'error fl_right'
			
		}
	});
	
	});
</script>