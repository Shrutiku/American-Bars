
<style>
	.ps-list .ps-prev
	{
		display: none !important;
	}
	.ps-list .ps-next
	{
		display: none !important;
	}
	.ps-current{
		height: 470px !important;
	}
</style>
<div class="login_block">
<div><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button></div>
<ul class="pgwSlideshow">
	<?php if($bar_gallery){
		 foreach($bar_gallery as $row){
		 	
		 	?>
    <li><a target="_blank" href="javascript://"><img data-description="<?php echo strlen($row->image_title)>85 ? substr($row->image_title,0,85)."...":$row->image_title;?>" src="<?php echo base_url().'upload/bar_gallery_thumb_big650by470/'.$row->bar_image_name;?>"  ></a>
   	
    </li>
    <?php } } ?>
   
</ul>
</div>
