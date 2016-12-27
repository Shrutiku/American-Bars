<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/developer_js/login.js"></script>
<script type="text/javascript">
function call_login()
{
    window.location.href='<?php echo base_url();?>professional_login';
}
</script>
<!-- ************************************************************************ -->
  <div class="main-container">
    <div class="container">
        <div class="jumbotron">
            <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form_horizontal');
                            echo form_open('home/login',$attributes); ?>    
            <section class="login-block">
                 <div class="login_title text-center"> <h2> S'inscrire</h2></div>
                 <div class="login-form">
                     
                       <?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      <?php if($msg!="" && $maximum_attemp_cond == ''){
                                if($msg=="activate") 
                                {
                                    echo "<div class='success text-center'>".ACCOUNT_ACTIVATE_SUCCESS."</div>";
                                }
                                
                                if($msg=="expired") 
                                {
                                    echo "<div class='error text-center'>".ACTIVATION_LINK_EXP."</div>";
                                }
                                
                                if($msg=="signup_sucess") 
                                {
                                    echo "<div class='success text-center'>".SIGNUP_SUCCESS."</div>";
                                }
                                
                                if($msg=="invalid")
                                {
                                    echo "<div class='error text-center'>".INVALIDE_USER_AND_PASSWORD."</div>";
                                }
                                if($msg=='forget')
                                {
                                    echo "<div class='success text-center'>".RESET_PASSWORD_SUCCESS.' '.$reset_email."</div>";
                                }
                                if($msg=='set')
                                {
                                    
                                    echo "<div class='error text-center'>".PASSWORD_ALREADY_RESET."</div>";
                            
                                }
                        
                                if($msg=="reset")
                                {
                                      echo "<div class='success text-center'>".RESET_PASSWORD."</div>";
                                }
                                
                                 if($msg=="resetlinksend")
                                {
                                     echo "<div class='error text-center'>".MAX_LOGIN_ATTEMPT.'<p>'.RESET_PASSWORD_SUCCESS.' '.$this->input->post("username").'</p>'."</div>";
                                }
                                
                        }  

                           
                        
                            
                                ?>
                      <!--<div class="col-lg-12 text-center">
                          <div class="radio-inline">
                              <label>
                                <input type="radio" name="login_radio" value="1" checked="checked"/>
                                Connectez-vous en tant que patient
                              </label>
                            </div>
                             <div class="radio-inline">
                              <label>
                                <input type="radio" name="login_radio" value="2" onclick="call_login();"/>
                               Connectez-vous en tant qu'opérateur
                              </label>
                            </div>
                      </div> --> 
                        
                    <div class="col-lg-12 margin-top-15">
                        <div class="row">
                            <div class="col-lg-6">
                            <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="form-control" placeholder="Adresse email"> 
                            </div>
                            <div class="col-lg-6">
                            <input type="password" name="password" id="password" value="<?php echo $password; ?>" class="form-control" placeholder="Mot de passe"> 
                            </div>
                        
                          <div class="clearfix"></div>
                       </div>
                       
                    </div>
               
                    <div class="col-lg-12">
                    
                             <div class="checkbox col-lg-6">
                                 <label>
                                  <input type="checkbox" value="1" name="remember_me" id="remember_me" <?php if($remember_me==1){?> checked="checked" <?php }?>>Rester connecté
                                </label>
                             </div>
                            <div class="row">                           
                             <div class=" col-lg-6 text-right mmtop">
                                 <a href="<?php echo site_url("forget_password/") ?>" class="link underline"> Mot de passe oublié ?</a>
                             </div>
                           </div>  
                       
                         <div class="clearfix"></div>
                    </div> 
                       
                    <div class="col-lg-12 text-center margin-top-15">
                            <div class="action-btn "> 
                                <input  name="submit" id="submit" type="submit" class="buton btn-green" value="Se connecter" />
                             </div>
                             <p> Vous n’avez pas encore de compte ? <a href="<?php echo site_url("offer"); ?>" class="link underline">  Inscrivez-vous ? </a> </p>
                   <div class="clearfix"></div>           
                 </div>
                 </div> 
                  <div class="clearfix"></div>
                 
            </section>
          </form>
        
         
       </div><!---->
      </div> <!-- /container -->
  </div>
<!-- ************************************************************************ -->