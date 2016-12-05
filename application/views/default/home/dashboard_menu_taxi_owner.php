<div class="vertical_menu">
     				<ul>
     					<li class="<?php echo $this->uri->segment(2)=='taxi_owner_dashboard' ? 'active':'';?>">
     						<a href="<?php echo site_url('home/taxi_owner_dashboard')?>">
     							<i class="strip bar_profile"></i>
     							MY Profile
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='changepassword' ? 'active':'';?>">
     						<a href="<?php echo site_url('home/changepassword')?>">
     							<i class="strip postcards"></i>
     							Change Password
     						</a>
     					</li>
     					
     				
     				</ul>
     			</div>