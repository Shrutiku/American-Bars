<?php if($bar_cocktail){
     						  foreach($bar_cocktail as $row){?>	
	         			
	         			
	         			<li class="mart10">
						         				<div class="media">
							         				
												      
												       <a class="pull-left widheig70" href="<?php echo site_url('bar/details/'.$row->bar_slug);?>">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      <?php
				        if($row->bar_logo!="" && is_file(base_path().'upload/barlogo_thumb/'.$row->bar_logo)){ ?>
										<img style="width: 70px; height: 70px;" src="<?php echo base_url().'upload/barlogo_thumb/'.$row->bar_logo; ?>"   />
									<?php
									} else {
		            		?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/barlogo/no_image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
						      </a>
												     <div class="media-body"> 
							         					<div class="fourm_label"><a href="<?php echo site_url('bar/details/'.$row->bar_slug);?>" class="newsyellow"><?php echo strlen($row->bar_title)>25 ? substr($row->bar_title,0,25).'...':$row->bar_title;?></a></div>
							         					<p class="pera"><?php echo strlen($row->address)>25 ? substr($row->address,0,25).'...':$row->address;?> <br/><?php echo $row->city; ?>, <?php echo $row->state; ?> <?php echo $row->zipcode; ?></p>
							         				 </div>
						         				</div>
						         			</li>
						         			
	         			
	         			<hr>
	         			<?php } ?>
	         			
	         			<?php } else { ?>
	         				
	         				
<?php }?>