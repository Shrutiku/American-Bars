<?php
  $theme_url = $urls= base_url().getThemeName();
?>
<script type="text/javascript" language="javascript">
	function delete_rec(id,redirectpage,option,keyword,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete Membership Plan?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>membership_plan/delete_membership/"+id;
		}else{
			return false;
		}
	}
</script>
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Membership Plan</h1>
  		<?php $attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('membership_plan/search_list_membership/',$attributes);?>
  		<div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select name="option" id="option" class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  				<option value="plan_title" <?php if($option=='plan_title'){?> selected="selected"<?php }?> >Plan Title</option>  
                   	<option value="category" <?php if($option=='category'){?> selected="selected"<?php }?> >Category</option>
	  			</select>
	  			<input name="keyword" id="keyword" value="<?php echo  $keyword ?>" type="text" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
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
    			<li><a href="#">My Articles</a></li>
    			<li><a href="#">My Earnings</a></li>
    			<li><a href="#" clfunction delete_rec(id,redirectpage,option,keyword,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete Membership?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>membership/delete_membership/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
		}else{
			return false;
		}
	}ass="active">Membership Plan</a></li>
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
  				
  				<!-- <div class="pagination padtb5">
		  			<ul class="pagination">
		  				<li class="first"><a href="" < </li>
		  				<li class="active"> 1 </li>
		  				<li> 2 </li>
		  				<li> 3 </li>
		  				<label class="fl_left marlr10"> ... </label>
		  				<li> 8 </li>
		  				<li class="last">  </li>
		  				<div class="clear"></div>
		  			</ul>
	  			</div> -->
	  			<div class="pagination padtb5">
		  			<ul class="pagination">
		  				<?php echo $page_link; ?>
		  				<div class="clear"></div>
		  			</ul>
	  			</div>
	  		 </div>
	  		 	 <form id="imageform" method="post" enctype="multipart/form-data" action="<?php echo base_url("membership_plan/add_membership_plan") ?>">
	  			<div class="fl_right">
	  			<?php echo anchor('membership_plan/add_membership_plan','Add', 'class="button" id="add_new_mwmbership_plan"'); ?>	
	  			<!--<button type="submit" name="add_new_mwmbership_plan" id="add_new_mwmbership_plan" class="button">Add</button>-->
	  			</div>
	  			<div class="clear"></div>
	 			</form>
	  		<div class="mart20">
	  			<table>
	  				<thead>
	  					<th>Title</th>
	  					<th>Category</th>
	  					<th>Price</th>
	  					<th>Number of Months</th>
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
	  						<td><a href="#" class="red"><?php echo $row->plan_title; ?></a></td>
	  						<td><?php echo $row->category; ?></td>
	  						<td><?php echo $row->price; ?></td>
	  						<td><?php echo $row->total_month; ?></td>
	  						<td>
	  							<?php 
									echo anchor('membership_plan/add_membership_plan/edit/'.$row->membership_plan_id,'<i class="strip edit"></i>'); 
								?>
	  							<!--<a href="#"><i class="strip edit"></i></a>-->
	  							<!--<a href="#"><i class="strip delete"></i></a>-->
	  							<a href="javascript://" onClick="delete_rec('<?php echo $row->membership_plan_id; ?>')"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>
	  					<?php $i++;} }else{ ?>
											<tr>
												<td  colspan="5" style="text-align:center!important;">No Records Found</td>
											</tr>
								<?php } ?>
	  					
	  					<!--<tr class="dark">
	  						<td><a href="#" class="red">Lorem Ipsum</a></td>
	  						<td>Lorem Ipsum</td>
	  						<td>$15</td>
	  						<td>12</td>
	  						<td>
	  							<a href="#"><i class="strip edit"></i></a>
	  							<a href="#"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>
	  					<tr>
	  						<td><a href="#" class="red">Lorem Ipsum</a></td>
	  						<td>Lorem Ipsum</td>
	  						<td>$15</td>
	  						<td>12</td>
	  						<td>
	  							<a href="#"><i class="strip edit"></i></a>
	  							<a href="#"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>
	  					<tr class="dark">
	  						<td><a href="#" class="red">Lorem Ipsum</a></td>
	  						<td>Lorem Ipsum</td>
	  						<td>$15</td>
	  						<td>12</td>
	  						<td>
	  							<a href="#"><i class="strip edit"></i></a>
	  							<a href="#"><i class="strip delete"></i></a>
	  						</td>
	  					</tr>
	  					<tr>
	  						<td><a href="#" class="red">Lorem Ipsum</a></td>
	  						<td>Lorem Ipsum</td>
	  						<td>$15</td>
	  						<td>12</td>
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
	  		</div>-->
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>