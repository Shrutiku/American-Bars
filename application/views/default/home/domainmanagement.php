<div class="wrapper row6 padtb10 has-js">
    <div class="container">
        <div class="margin-top-50 bg_brown">
            <?php echo $this->load->view(getThemeName() . '/home/dashboard_menu'); ?>
            <div class="dashboard_detail">
                <div class="result_search event">
                    <div class="result_search_text"><i class="strip update_domain"></i> Domain Managment</div>
                </div>
                <div class="dashboard_subblock">
                    <div>


                        <div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
                        <!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/' . base64_encode($getbar['bar_id'])); ?>"> -->

                        <?php
                        $attributes = array('id' => 'form', 'name' => 'add_event');
                        echo form_open_multipart('home/domainmanagement', $attributes);
                        ?>
                        <input type="hidden" name="event_id" id="event_id" value=""/>

                        <div class="text-center pad_t15b20">
                            <div class="padtb">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label">Domain Registrar:</label>
                                </div>
                                <div class="input_box col-sm-7">
                                    <select class="select_box" name="domain_registrar" id="domain_registrar">
                                        <option value="">SELECT DOMAIN REGISTRAR...</option>
                                        <?php foreach ($companies as $company){
                                            echo '<option ' . ($domain_registrar == $company ? 'selected' : '') . ' value="' . $company . '">' . $company . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="padtb">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label">Domain Name: </label>
                                </div>
                                <div class="input_box col-sm-7">
                                    <input type="text" class="form-control form-pad" id="url" name="url"
                                           value="<?php echo $url; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <div class="padtb">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label">Username: </label>
                                </div>
                                <div class="input_box col-sm-7">
                                    <input type="text" class="form-control form-pad" id="un" name="un"
                                           value="<?php echo $un; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="padtb">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label">Password: </label>
                                </div>
                                <div class="input_box col-sm-7">
                                    <input type="password" class="form-control form-pad" id="pw" name="pw"
                                           value="<?php echo $pw; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="padtb">
                                <div class="col-sm-3 text-right">
                                    <label class="control-label">Terms & Conditions: </label>
                                </div>
                                <div class="input_box col-sm-7">
                                    <input class="domain-agree" type="checkbox" <?php echo($agree == '1' ? 'checked' : ''); ?>
                                           class="form-control form-pad" id="agree" name="agree" value="1">
                                    <div class="domain-terms">
                                        By clicking submit you are authorizing American Bars and/or related personnel to
                                        access your domain registrar and to point the domain listed above to your
                                        American Bars profile page. American Bars specifically disclaims any warranty
                                        and/or responsibility for any damage or loss of data.
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </div>


                            <div class="padtb8">
                                <div class="col-sm-3 text-right"></div>
                                <div class="col-sm-7 mart10 text-right">
                                    <button type="submit" class="btn btn-lg btn-primary marr_10">Submit</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        </form>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/js/jquery_form.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/js/jquery.easing.1.3.js"></script>

    <script>

        $(document).ready(function () {
            $('#form').validate({
                rules: {
                    domain_registrar: {
                        required: true,
                    },
                    url: {
                        required: true,
                    },
                    un: {
                        required: true,
                    },
                    pw: {
                        required: true,
                    },
                    agree: {
                        required: true,
                    },
                    errorClass: 'error fl_right'
                },

                submitHandler: function (form) {

                    $(form).ajaxSubmit({

                        type: "POST",
                        dataType: 'json',
                        beforeSubmit: function () {
                            $('#dvLoading').fadeIn('slow');
                        },

                        uploadProgress: function (event, position, total, percentComplete) {
                        },

                        success: function (json) {

                            if (json.status == "fail") {
                                $("#cm-err-main1").show();
                                $("#cm-err-main1").html(json.comment_error);
                                $('#dvLoading').fadeOut('slow');
                                scrollToDiv('cm-err-main1');
                                // setTimeout(function ()
                                // {
                                // $("#cm-err-main1").fadeOut('slow');
                                // }, 3000);
                                return false;
                            }

                            else {
                                $.growlUI('Your domain settings update successfully .');
//                                $(':input', '#form')
//                                    .not(':button, :submit, :reset, :hidden')
//                                    .val('')
//                                    //.removeAttr('checked')
//                                    .removeAttr('selected');
                            }
                            $('#dvLoading').fadeOut('slow');
                        }
                    });
                }
            })

        });


    </script>


    </script>

