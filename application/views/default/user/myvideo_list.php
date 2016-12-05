<?php
  $theme_url = $urls= base_url().getThemeName();
?>

<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">My Video</h1>
  		<?php $attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('myvideo/search_list_video/',$attributes);?>
  		<div class="form-control-group">
  			<div class="fl_lef">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select id="option" name="option" class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  				<option value="video_title" <?php if($option=='video_title'){?> selected="selected"<?php }?> >Video Title</option>
	  				<option value="video_price" <?php if($option=='video_price'){?> selected="selected"<?php }?>>Video Price</option>
	  				<option value="video_type" <?php if($option=='video_type'){?> selected="selected"<?php }?>>Video Type</option>
	  			</select>
	  			<input name="keyword" id="keyword" type="text" value="<?php echo $keyword; ?>" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
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
    			<li><a href="#" class="active">My Videos</a></li>
    			<li><a href="#">My Contents</a></li>
    			<li><a href="#">My Articles</a></li>
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
  			<div>
	  			<div class="wid670 fl_left">
	  				<div class="pagination padtb5">
			  			<ul class="pagination">
			  				<?php echo $page_link; ?>
			  				<div class="clear"></div>
			  			</ul>
		  			</div>
		  		 </div>
		  		  <form id="imageform" method="post" enctype="multipart/form-data" action="<?php echo base_url("myvideo/add_myvideo") ?>">
		  			<div class="fl_right">
		  			<?php echo anchor('myvideo/add_myvideo','Add', 'class="button" id="add_new_mwmbership_plan"'); ?>
		  			<!--<button type="submit" class="button">Add</button>-->
		  			</div>
		  		</form>	
		  			<div class="clear"></div>
	  		</div>
	 
	  		<div class="mart20">
	  			<table>
	  				<thead>
	  					<th>Title</th>
	  					<th>Category</th>
	  					<th>Price</th>
	  					<th>Video</th>
	  					<th>Description</th>
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
	  						<td><a href="#" class="red"><?php echo $row->video_title ?></a></td>
	  						<td><?php echo $row->category_name ?></td>
	  						<td>$<?php echo $row->video_price ?></td>
	  						<td> <?php if($row->video_image !="" && file_exists(base_path()."upload/video_image/".$row->video_image)){?> <img src="<?php echo base_url();?>upload/video_image/<?php echo $row->video_image; ?>" width="62" height="42"  class="fl_left marr10"/> <?php } else { ?> <img src="<?php echo base_url();?>upload/no-image.png" width="62" height="42"  class="fl_left marr10"/> <?php } ?></td>
	  						<td class="wid270">
	  							
	  							Lorem Ipsum is simply dummy text of the printing and typesetting industry.
	  							
	  						</td>
	  						<td>
	  							<!--<a href="#"><i class="strip edit"></i></a>-->
	  							<?php 
									echo anchor('myvideo/add_myvideo/edit/'.$row->video_id,'<i class="strip edit"></i>'); 
								?>
	  							<a href="javascript://" onClick="delete_rec('<?php echo $row->video_id; ?>')"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>
	  					<?php $i++;} }else{ ?>
											<tr>
												<td  colspan="6" style="text-align:center!important;">No Records Found</td>
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
	  		<!--<div class="pagination pad20">
		  			<ul class="pagination">
		  				<li class="first"> < </li>
		  				<li class="active"> 1 </li>
		  				<li> 2 </li>
		  				<li> 3 </li>
		  				<label class="fl_left marlr10"> ... </label>
		  				<li> 8 </li>
		  				<li class="last"> > </li>
		  				<div class="clear"></div>
		  			</ul>
		  				location.href = "<?php echo base_url(); ?>myvideo/delete_video/"+id;
			alert();
	  		</div>-->
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
  <script type="text/javascript" language="javascript">
	function delete_rec(id)
	{
		var ans = confirm("Are you sure, you want to delete Video?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>myvideo/delete_video/"+id;
		}
		else
		{
					
			return false;
		}
	}
</script>
</div>