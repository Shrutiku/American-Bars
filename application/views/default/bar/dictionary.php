<script type="text/javascript">
	function set_orderby(limit,alpha,option,keyword,offset)
	{
		$('#beer-search-frm').submit();
	}
	function limitsubmit()
	{	
		$('#beer-search-frm').submit();
	}
</script>
<div class="wrapper row5">
     	<div class="container">
     	<div class="beer_details">
     		<div class="mar_top20">
	     		<div class="left_block">
	     			
     				<form class="form-horizontal" id="beer-search-frm" method="post" role="form" action="<?php echo site_url("bar/dictionary"); ?>">
     					
     					<div class="result_search">
					<div class="col-sm-6">
						<div class="result_search_text pull-left">Dictionary</div>
					</div>
					<!-- <div class="col-sm-5">
						   <div class="form-group pull-left">
								<label for="inputEmail3" class="control-label">Results Per Page :</label>
								<select class="select_box" name="limit" id="limit" onchange="limitsubmit();">
									<option value="1" <?php if($limit==1){ ?> selected="selected"<?php } ?>>1</option>
									<option value="5" <?php if($limit==5){ ?> selected="selected"<?php } ?>>5</option>
									<option value="10"<?php if($limit==10){ ?> selected="selected"<?php } ?>>10</option>
									<option value="20"<?php if($limit==20){ ?> selected="selected"<?php } ?>>20</option>
									<option value="30"<?php if($limit==30){ ?> selected="selected"<?php } ?>>30</option>
									<option value="40"<?php if($limit==40){ ?> selected="selected"<?php } ?>>40</option>
									<option value="50"<?php if($limit==50){ ?> selected="selected"<?php } ?>>50</option>
								 </select>
						   </div>
						   <div class="form-group  pull-right">						  
								<label for="inputEmail3" class="control-label">Sort By :</label>
								 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo $alpha;?>','<?php echo $options;?>','<?php echo $keyword;?>','<?php echo $offset; ?>')">
									<option value="divtionary_title#ASC" <?php if($order_by == "divtionary_title#ASC"){ ?> selected="selected" <?php } ?>>Name ASC</option>
									<option value="divtionary_title#DESC"<?php if($order_by == "divtionary_title#DESC"){ ?> selected="selected" <?php } ?>>Name DESC</option>
								 </select>
						   </div>
						   <div class="clearfix"></div>
					  </div> -->
					  <div class="clearfix"></div>
				</div>
     		<div class="alphabate_block">
					<ul class="alphabate_list" style="width: 84%;" >
						<?php for($i=65;$i<=90;$i++){?>
							<li><a href="<?php echo site_url("bar/dictionary/".$limit."/".base64_encode($i)); ?>" <?php if($alpha == base64_encode($i)){ ?> class="active" <?php }?>><?php echo chr($i); ?></a></li>
						<?php } ?>
						<div class="clearfix"></div>
					</ul>
					
				</div>
				
				<!-- <div class="pull-left padt10">
						   <div class="form-group">
							   <div class="col-sm-10 input_box pull-left">
								   <input type="text" class="form-control form-pad" id="keyword" name="keyword" placeholder="Beer Name Here" value="<?php echo $keyword; ?>">
								   <input type="hidden" name="alpha" id="alpha" value="<?php echo $alpha; ?>" />
							   </div>
							   <div class="col-sm-2 input_box pull-left">
									<button class="btn btn-lg btn-primary"><i class="strip search"></i></button>
							   </div>
							   <div class="clearfix"></div>
							</div>
				</div> --><div class="clearfix"></div>
				</form>
     		<div id="list_hide">		
     		<?php if($result){
     			
     			   foreach($result as $row){?>		
     				<div class="padtb10 pad_lr10 br_bott_gray ">
     					<a href="" class="beer_title"><?php echo ucfirst($row->dictionary_title);?></a>
     					<div class="img_wid95 ">
     						
     						<div class="result_desc padtb10">
     							<?php echo $row->dictionary_description;?>
     						</div>
     					</div>
     					
     				</div>
     				
     			<?php } } else { ?>
     				 No Records Founds .
     		  <?php } ?>		 
     			
     			<div class="pagination" >
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>	
     				
     				<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				</div>	
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     		<div class="right_block_releated">
	     			<div class="text-left">
	     				<h1 class="productbar_title">Latest Dictionary</h1>
	     				<div class="clearfix"></div>
	     				<?php if($latest_mews){
	     					
	     					  foreach($latest_mews as $rows_new){
	     					  	
							//die;?>
	     				<div>
	     					
	     					
		     				<div>
		     					<a href="" class="beer_title"><?php echo ucfirst($rows_new->dictionary_title);    ?></a>
		     				</div>
		     				<div class="result_desc padtb">
	     						<?php if(strlen(strip_tags($rows_new->dictionary_description) > 400)){ echo substr(strip_tags($rows_new->news_desc), 0 , 400)."..."; } else { echo strip_tags($rows_new->dictionary_description).""; }  ?> 
	     					</div>
     					</div>
     					<?php } } ?>
     					
	     			</div>
	     			
	     			
	     			<div class="mar_top20">
	     				<?php $getad = getadvertisement('dictionary','0'); 
	     				if($getad){
	     					
	     				$count = getadvertisementByIDCount(@$getad['advertisement_id'],$getad['type']);
							
							
						if($getad['type']=='click')
						{
							$cnt = $getad['number_click'];
						}
						else
						{
							$cnt = $getad['number_visit'];
						}
						$getad_new = getadvertisementByID(@$getad['advertisement_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt  && $getad['type']=='visit')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$getad['advertisement_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement',$array);
							
								$array1 = array('total_visit'=>$getad['total_visit']+1);
							$this->db->where('advertisement_id',$getad['advertisement_id']);
							$this->db->update('advertisement_master',$array1);
						}
	     				if($getad && $count < $cnt){ ?>
	     					<?php if(($getad['advertisement_image']!='' && file_exists(base_path().'upload/advertisement_thumb/'.$getad['advertisement_image']))){ ?>
	     						<a target="_blank" <?php if($getad['type']=='click'){?>onclick="add_click('<?php echo $getad['advertisement_id'];?>');"<?php } ?> href="<?php echo $getad['url']; ?>"><img src="<?php echo base_url().'upload/advertisement_thumb/'.$getad['advertisement_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php }  else {
	     						?>
		     			<img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/>
		     			
		     			  <?php } } else {?>
		     			  <!-- <img src="<?php echo base_url().getThemeName(); ?>/images/adv1.png" class="img-responsive"/> -->	
		     			  	<?php } ?>
		     		</div>
	     			
	     		</div>
	     		<div class="clearfix"></div>
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
			return false;
			
		});
		
		function add_click(id)
		{
			//  window.location.href = '<?php //echo site_url('bar/dictionary');?>'; 
		   $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('home/add_clcik')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		   
		     
		  }
	   });
		}
 </script>  	