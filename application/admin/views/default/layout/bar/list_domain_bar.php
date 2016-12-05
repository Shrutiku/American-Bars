<script type="text/javascript" language="javascript">
    $(document).ready(function (e) {
        $('.domain-switch').change(function (e) {
            var check = 0;
            if (this.checked) {
                check = 1;
            }

            var tr = $(this).parent().parent();
            var id = $(tr).find('.user-id').text();
            $.ajax({
                method: "POST",
                data: {
                    'user_id': id,
                    'action': check
                },
                success: function(responseText){
                    if(responseText){
                        var json = $.parseJSON(responseText);
                        if(json.status != 'success'){
                            alert('Something went wrong');
                        }
                        else{
                            $(tr).find('.date-shown').text(json.date_shown);
                        }
                    }
                },
                failure: function(){
                    alert('Something went wrong');
                }
            })
        });
    });
</script>
<div class="page_content">

    <div class="container_fluid">

        <div class="row_fluid">
            <h3 class="page_title">Domain Bar List </h3>

        </div>

        <div class="row_fluid">
            <div class="portlet blue">
                <div class="portlet-title">
                    <div class="caption fl_left"> Domain Bar List</div>
                    <div class="clear"></div>
                </div>
                <div class="portlet-body form">

                    <div class="clear"></div>
                    <form name="frm_listlogin" id="frm_listlogin"
                          action="<?php echo base_url(); ?>suggest_bar/action_suggest_bar" method="post">


                        <input type="hidden" name="action" id="action"/>
                        <div class="scroll-pane horizontal-only">
                            <table class="table border">
                                <thead>
                                <tr>
                                    <th class="sorting_disabled" style="width: 6%;">ID</th>
                                    <th class="sorting_disabled" style="width: 6%;">Name</th>
                                    <th class="sorting_disabled" style="width: 6%;">User Email</th>
                                    <th class="sorting" style="width: 5%;">Domain Registrar</th>
                                    <th class="sorting" style="width: 5%;">Domain URL</th>
                                    <th class="sorting" style="width: 5%;">Username</th>
                                    <th class="sorting" style="width: 5%;">Password</th>
                                    <th class="sorting" style="width: 5%;">Domain AB</th>
                                    <th class="sorting" style="width: 5%;">Domain Switch Completed</th>
                                    <th class="sorting" style="width: 5%;">Domain Switch Date</th>
                                </tr>

                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <?php
                                if ($result) {
                                    $i = 1;
                                    foreach ($result as $row) {
                                        $cls = ($i % 2 == 0) ? 'even' : 'odd';
                                        //print_r($row);
                                        ?>
                                        <tr class="<?php echo $cls ?>">
                                            <td class="user-id" style="text-align:center;"><?php echo $row->user_id; ?></td>
                                            <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                                            <td><?php echo $row->email; ?></td>
                                            <td><?php echo $row->domain_registrar; ?></td>
                                            <td><?php echo $row->url; ?></td>
                                            <td><?php echo $row->un; ?></td>
                                            <td><?php echo $row->pw; ?></td>
                                            <td style="text-align:center;"> <input type="checkbox" disabled="disabled" name="domain-ab" <?php echo $row->agree == '1' ? 'checked':''; ?> class="domain-ab"></td>
                                            <td style="text-align:center;"> <input type="checkbox" name="domain-switch" class="domain-switch" <?php echo $row->is_agree_shown == '1' ? 'checked':''; ?>></td>
                                            <td class="date-shown"><?php echo $row->date_shown; ?></td>
                                        </tr>
                                        <?php $i++;
                                    }
                                } else { ?>


                                    <tr class="odd">
                                        <td class=" sorting_1" colspan="10" style="text-align:center!important;">No
                                            Records Found
                                        </td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                    </form>
                </div>

            </div>


        </div>
    </div>
</div>
</div>
</div>