<?php
  $theme_url = $urls= base_url().getThemeName();
?>

<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">My Aricle</h1>
  		<?php $attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('myarticle/search_list_article/',$attributes);?>
  		<div class="form-control-group">
  			<div class="fl_left">
  				<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select id="option" name="option" class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  				<option value="article_title" <?php if($option=='article_title'){?> selected="selected"<?php }?> >Article Title</option>
	  				<option value="article_price" <?php if($option=='article_price'){?> selected="selected"<?php }?>>Article Price</option>
	  				<option value="article_type"  <?php if($option=='article_type') {?> selected="selected" <?php }?>>Article Type</option>
	  			</select>
	  			<input type="text" name="keyword" value="<?php echo $keyword ?>" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
	  			<button type="submit" class="button fl_left">Search</button>
	  			<div class="clear"></div>
  			</div>
  			<div class="clear"></div>
  		</div>
  	</form>
  	</div>
  	<div class="row">
  		<!--<div class="videolist_left_block mart70">
  			<ul class="videoside_menu">
    			<li><a href="#">My Videos</a></li>
    			<li><a href="#">My Contents</a></li>
    			<li><a href="#" class="active">My Articles</a></li>
    			<li><a href="#">My Earnings</a></li>
    			<li><a href="#">Membership Plan</a></li>
    		</ul>

  		</div>-->
  		<?php $this->load->view(getThemeName ().'/user/user_sidebar'); ?>
  		<div class="videolist_righ_block">
  			<?php  
					if($msg =='insert') {
						echo '<div class="success text-center"><p>Record has been Add Successfully.</p></div>';
					}
					elseif($msg=='update'){
						echo '<div class="success text-center"><p>Record has been Updated Successfully.</p></div>';
					}
					elseif ($msg=='delete') {
						echo '<div class="success text-center"><p>Record has been Delete Successfully.</p></div>';
					} ?>
  			<div class="wid670 fl_left">
  				<div class="pagination padtb5">
		  			<ul class="pagination">
		  				<?php echo $page_link; ?>
		  				<div class="clear"></div>
		  			</ul>
	  			</div>
	  		 </div>
	  			<div class="fl_right">
	  			<?php echo anchor('myarticle/add_myarticle','Add', 'class="button" id="add_new_mwmbership_plan"'); ?>	
	  			<!--<button type="submit" class="button">Add</button>-->
	  			</div>
	  			<div class="clear"></div>
	 
	  		<div class="mart20">
	  			<table>
	  				<thead>
	  					<th>Title</th>
	  					<th>Category</th>
	  					<th>Price</th>
	  					<th>Article</th>
	  					<!--<th>Description</th>-->
	  					<th>Action</th>
	  				</thead>
	  				<tbody>
	  					<?php
								if($result)
								{
									$i=1;
									foreach($result as $row)
									{    //print_r($row); die;
									 ?>
	  					<tr>
	  						<td><a href="#" class="red"><?php echo $row->article_title ?></a></td>
	  						<td><?php echo $row->category_name ?></td>
	  						<td>$<?php echo $row->article_price ?></td>
	  						<td>  <?php if($row->article_image !="" && file_exists(base_path()."upload/article_image/".$row->article_image)){ ?> <img src="<?php echo base_url();?>upload/article_image/<?php echo $row->article_image; ?> " width="62" height="42"  class="fl_left marr10"/>  <?php } else { ?> <img src="<?php echo base_url();?>upload/no-image.png" width="62" height="42"  class="fl_left marr10"/> <?php } ?> </td>
	  						<!--<td class="wid270">
	  							<?php echo $row->article_desc ?>
	  						</td>-->
	  						<td>
	  							<?php 
									echo anchor('myarticle/add_myarticle/edit/'.$row->article_id,'<i class="strip edit"></i>'); 
								?>
	  							<a href="javascript://" onClick="delete_rec('<?php echo $row->article_id; ?>')"><i class="strip delete"></i></a>
	  							
	  						</td>
	  					</tr>
	  					<?php $i++;} }else{ ?>
											<tr>
												<td  colspan="7" style="text-align:center!important;">No Records Found</td>
											</tr>
								<?php } ?>
	  					<!--<tr class="dark">
	  						<td><a href="#" class="red">Lorem Ipsum</a></td>
	  						<td>Lorem Ipsum</td>
	  						<td>$15</td>
	  						<td><img src="images/62c42_img.png" class="fl_left marr10"/></td>
	  						<td class="wid270">
	  							
	  							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	  							
	  						</td>
	  						<td>
	  							<a href="#"><i class="strip edit"></i></a>
	  							<a href="#"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>-->
	  					
	  				</tbody>
	  			</table>
	  		</div>
	  		<div class="pagination pad20">
		  			<ul class="pagination">
		  				<?php echo $page_link; ?>
		  				<div class="clear"></div>
		  			</ul>
	  		</div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
  <script type="text/javascript" language="javascript">
	function delete_rec(id)
	{
		alert(id);
		var ans = confirm("Are you sure, you want to delete Article?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>myarticle/delete_article/"+id;
		}
		else
		{
					
			return false;
		}
	}
</script>
</div>