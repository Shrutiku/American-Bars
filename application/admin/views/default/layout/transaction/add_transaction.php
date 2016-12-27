<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script>

$(document).ready(function(){
	$("#usualValidate").validate({
		
		rules: {
			transaction_title:'required',
			transaction_desc:'required',
			transaction_category_id:'required',
			transaction_price:'required',
			transaction_type:'required',
			pre_file_up_transaction:'required',
			
			pre_transaction_preview:'required',
			status : 'required'
			
			
		},
		
	});
	});
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($transaction_id==""){ echo 'Add Transaction'; } else { echo 'Edit Transaction'; }?></h3>
					
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
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addtransaction','class'=>'main');
				echo form_open_multipart('transaction/add_transaction',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Transaction Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Transaction Title...." class="m_wrap wid360" name="transaction_title" id="transaction_title" value="<?php echo $transaction_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Transaction Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="transaction_desc"  id="transaction_desc" placeholder="Transaction Description..." class="m_wrap wid360"><?php echo $transaction_desc; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="transaction_category_id" id="transaction_category_id"> 
												<option value="">--Select--</option>
												<?php if($category){
													foreach ($category as $cat) {
												?>
													<option value="<?php echo $cat->category_id; ?>" <?php echo ($cat->category_id==$transaction_category_id)?'selected="selected"':''; ?> ><?php echo $cat->category_name; ?></option>
												<?php		
													}
												} ?>
												
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Transaction Price :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Transaction Price...." class="m_wrap wid360" name="transaction_price" id="transaction_price" autocomplete="off" value="<?php echo $transaction_price; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Transaction Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="transaction_type" id="transaction_type"> 
												<option value="">--Select--</option>
												<option value="free" <?php echo ($transaction_type=='free')?'selected="selected"':''; ?> >Free</option>
												<option value="paid" <?php echo ($transaction_type=='paid')?'selected="selected"':''; ?> >Paid</option>
												<option value="transaction_plan" <?php echo ($transaction_type=='transaction_plan')?'selected="selected"':''; ?> > Transaction Plan</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Transaction :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="file_up_transaction" id="file_up_transaction" />
											<input type="hidden" name="pre_file_up_transaction" id="pre_file_up_transaction" value="<?php echo $transaction_file_name ?>" />
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Transaction Preview :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="transaction_preview" id="transaction_preview" />
											<input type="hidden" name="pre_transaction_preview" id="pre_transaction_preview" value="<?php echo $transaction_preview ?>" />
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
								
							</div>	
							<input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $transaction_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($transaction_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_transaction')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>transaction/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>transaction/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_transaction')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>transaction/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>transaction/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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