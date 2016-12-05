<div class="page_content">
            <div class="container_fluid">
                <div class="row_fluid"> 
                    <h3 class="page_title"></h3>
                </div>
                <div class="row_fluid"> 
                    <div class="portlet blue">
                        <div class="portlet-title">
                            <div class="caption">Log Activity</div>
                        </div>
                        <div class="portlet-body form">
                            <div class="content ">
                                    <div class="row-fluid">
                                    <div class="span12">
                                        <!-- BEGIN PORTLET-->
                                        <?php if($result)
                                        {
                                        ?>
                                            <div class="portlet-body" id="chats">
                                                    <ul class="chats">
                                                        <?php foreach($result as $rs)
                                                        {?>
                                                        <li class="in">
                                                            <div class="message">
                                                                <span class="datetime"><?php echo constant($rs->activity_name);?> </span>
                                                                <span style="float: right;"><?php echo getDuration($rs->date_added);?></span>
                                                            </div>
                                                        </li>
                                                        <?php }?>       
                                                    </ul>
                                                    <?php if(strlen($page_link)>0){ ?>
                                                    <div class="dataTables_paginate paging_full_numbers" style="float:right">
                                                        <ul class="pagination_new"><?php echo $page_link; ?></ul>
                                                     </div>  
                                                     <?php } ?>          
                                                <div class="clear"></div>
                                               
                                            </div>
                                    <?php }
                                    else
                                    {
                                        echo "No records found";
                                    }?>
                                        <!-- END PORTLET-->
                                    </div>
                                    
                                  
                                    </div>
                            </div>
                            
                          
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
</div>
