<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
            <?php  if($this->session->userdata('user_type')!='bar_owner'){ ?>
                    <div class="wrapper row4">
                        <div class="carousel slide" id="slider-fixed-banner">
                            <div class="carousel-inner">
                                <div class="active item">
                                    <?php $userinfo_new = get_user_info(get_authenticateUserID());
                                      if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag/'.@$userinfo_new->user_banner)) {?>
                                          <img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Bars"/> <?php 
                                      } else if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag_without/'.@$userinfo_new->user_banner)) {?>
                                          <img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Bars"/> <?php 
                                      } else { ?>
                                          <img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Bars"/> <?php
                                      } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }  ?>
        </div>
        <div class="<?php if($this->session->userdata('user_type')=='user'){?>user-top-border<?php } else {?>margin-top-50<?php } ?>">
            <div class="container">
                <div class="bg_brown">
                    <?php if($this->session->userdata('user_type')!='taxi_owner'){?>	
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
                    <?php } else {?>
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu_taxi_owner'); ?>
     			<?php } ?>	
     			<div class="dashboard_detail">
                            <div class="result_search event"><div class="result_search_text"><i class="strip change_pwd"></i> Change Password</div></div>
                            <div class="dashboard_subblock">
                                <div>
                                        
				<div id="list_show" style="display: block;" >	
                                    <div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
                                    <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('home/changepassword'); ?>">
     				
                                        <div class="text-center pad_t15b20">
                                            <div class="padtb">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label">Old Password : <span class="aestrick"> * </span></label>
                                                </div>

                                                <div class="input_box col-sm-7">
                                                    <input type="password" class="form-control form-pad" id="oldpassword" name="oldpassword" value="">
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="padtb">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label">Password :  <span class="aestrick"> * </span></label>
                                                </div>

                                                <div class="input_box col-sm-7">
                                                    <input type="password" class="form-control form-pad" id="upassword" name="upassword" value="">
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="padtb">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label">Confirm Password : <span class="aestrick"> * </span></label>
                                                </div>

                                                <div class="input_box col-sm-7">
                                                    <input type="password" class="form-control form-pad" id="cpassword" name="cpassword" value="">
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>


                                            <div class="padtb8">
                                                <div class="col-sm-3"></div>

                                                <div class="col-sm-7 mart10 text-left">
                                                    <button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
     			
                                </div>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    <link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    
    <script>
   
    $(document).ready(function(){
    	      
        $('#form').validate(
		{
		rules: {
                    oldpassword: {
                        required: true,
                    },
                    upassword: {
                        required: true,
                       	loginRegex: true,
                        rangelength: [8, 16]
                    },
                    cpassword: {
                        required: true,
                        equalTo:'#upassword', 
                    },
                    errorClass:'error fl_right'
                },
				
		submitHandler: function(form){
                    $(form).ajaxSubmit({
                        type: "POST",
                        dataType : 'json',
                        beforeSubmit: function() {
                            $('#dvLoading').fadeIn('slow');
                        },
		    	uploadProgress: function ( event, position, total, percentComplete ) {},
		    	success : function (json) {
                            if(json.status === "fail") {
                                $("#cm-err-main1").show();
                                $("#cm-err-main1").html(json.comment_error);
                                $('#dvLoading').fadeOut('slow');
                                scrollToDiv('cm-err-main1');
				  	
                                return false;
                            } else {
                                //alert("sdsa");
                                $("#cm-err-main1").hide();
                                $("#cm-err-main1").html("");
                                $.growlUI('Your password change successfully .');
                                $(':input','#form')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                //.removeAttr('checked')
                                .removeAttr('selected');
                            }
                                $('#dvLoading').fadeOut('slow');
                        }
		    });
		  }
		});
		
                $.validator.addMethod("loginRegex", function(value, element) {
                    return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
                }, "Provide atleast 1 Number, 1 Special character,1 Alphabet and between 8 to 16 characters.");
    });
   
</script>
