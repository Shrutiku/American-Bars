<?php if($bar_cocktail){
        foreach($bar_cocktail as $row){?>     			
            <li class="mart10">
                <div class="media">
                    <a class="pull-left widheig70" href="<?php echo site_url('cocktail/detail/'.$row->cocktail_slug);?>">
                        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
                        <?php		     
                        if($row->cocktail_image!="" && is_file(base_path().'upload/cocktail_thumb_70by70/'.$row->cocktail_image)){ ?>
                            <img src="<?php echo base_url().'upload/cocktail_thumb_70by70/'.$row->cocktail_image; ?>"   />
                        <?php 
                        } else { ?>
                            <img class="img-responsive" src="<?php echo base_url()?>/upload/cocktail_thumb/no_image.png" alt="American Dive Bars"/>	
                        <?php } ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="<?php echo site_url('cocktail/detail/'.$row->cocktail_slug);?>" class="newsyellow">
                            <?php  if(strlen($row->cocktail_name)>35){ echo substr($row->cocktail_name, 0,35).'...'; } else { echo $row->cocktail_name; } ?>
                        </a></h4>
                        <div class="fourm_label"><?php  if(strlen($row->type)>35){ echo substr($row->type, 0,35).'...'; } else { echo $row->type; } ?></div>
                            <div class="fourm_label"><?php  if(strlen($row->base_spirit)>35){ echo substr($row->base_spirit, 0,35).'...'; } else { echo $row->base_spirit; } ?></div>
						        
                                <p class="fourm_label"><?php echo strlen($row->strength)>35 ? substr($row->strength,0,35).'...':$row->strength; ?></p>
                                <div class="clearfix"></div>
                    </div>
                </div>
            </li>
            <hr>
        <?php } ?>
	         			
        <?php } else { ?>
	         				
        <?php } ?>	