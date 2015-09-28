<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>

            <h1><?php echo $heading_title; ?></h1>

            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <?php if (isset($error_warning)) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
                    <ul class="nav nav-tabs" id="tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-statuscodes" data-toggle="tab"><?php echo $tab_statuscodes; ?></a></li>
                        <li><a href="#tab-paymentmethods" data-toggle="tab"><?php echo $tab_paymentmethods; ?></a></li>
                        <li><a href="#tab-about" data-toggle="tab"><?php echo $tab_about; ?></a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_url"><?php echo $entry_url; ?></label>

                                <div class="col-sm-10">
                                    <input type="text" name="icepay_url" value="<?php echo $icepay_url; ?>" id="icepay_url" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="icepay_merchantid"><?php echo $entry_merchantid; ?></label>

                                <div class="col-sm-10">
                                    <input type="text" name="icepay_merchantid" value="<?php echo $icepay_merchantid; ?>" id="icepay_merchantid" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="icepay_secretcode"><?php echo $entry_secretcode; ?></label>

                                <div class="col-sm-10">
                                    <input type="text" name="icepay_secretcode" value="<?php echo $icepay_secretcode; ?>" id="icepay_secretcode" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_basic_status"><?php echo $entry_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_basic_status" id="icepay_basic_status" class="form-control">
                                        <?php if ($icepay_basic_status) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_basic_sort_order"><?php echo $entry_sort_order; ?></label>

                                <div class="col-sm-10">
                                    <input type="text" name="icepay_basic_sort_order" value="<?php echo $icepay_basic_sort_order; ?>" id="icepay_basic_sort_order" class="form-control" size="3"/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-statuscodes">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_open_status_id"><?php echo $entry_open_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_open_status_id" id="icepay_open_status_id" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $icepay_open_status_id) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_ok_status_id"><?php echo $entry_ok_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_ok_status_id" id="icepay_ok_status_id" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $icepay_ok_status_id) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_err_status_id"><?php echo $entry_err_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_err_status_id" id="icepay_err_status_id" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $icepay_err_status_id) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_cback_status_id"><?php echo $entry_cback_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_cback_status_id" id="icepay_cback_status_id" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $icepay_cback_status_id) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="icepay_refund_status_id"><?php echo $entry_refund_status; ?></label>

                                <div class="col-sm-10">
                                    <select name="icepay_refund_status_id" id="icepay_refund_status_id" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $icepay_refund_status_id) { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-paymentmethods">
                            <div class="attention" style="display: none;" id="error-box"></div>
                            <div class="success" style="display: none;" id="info-box"></div>

                            <br/><a href="icepay-getpaymentmethods" id="getMyPaymentMethods" class="button">Get My Paymentmethods</a><br/><br/>

                            <table class="form" id="icepay-payment-methods">
                                <tr style="text-align: left; <?php if ($storedPaymentMethods->num_rows == 0) { echo 'display: none'; } ?>"
                                    id="payment-table">
                                    <th style="width: 200px; padding: 5px;">Paymentmethod</th>
                                    <th style="width: 100px; padding: 5px;">Active</th>
                                    <th style="width: 250px; padding: 5px;">Displayname</th>
                                    <th style="width: 250px; padding: 5px;">Store</th>
                                    <th style="padding: 5px;">Geo Zone</th>
                                </tr>
                                <?php foreach ($storedPaymentMethods->rows as $paymentMethod) { ?>
                                <tr>
                                    <td>
                                        <input type='hidden' name="paymentMethodCode[<?php echo $paymentMethod['id']; ?>]" value="<?php echo $paymentMethod['pm_code']; ?>"/>
                                        <input type='hidden' name="paymentDisplayName[<?php echo $paymentMethod['id']; ?>]" value="<?php echo $paymentMethod['displayname']; ?>"/>
                                        <?php echo $paymentMethod['readablename']; ?>
                                    </td>
                                    <td>
                                        <input name="paymentMethodActive[<?php echo $paymentMethod['id']; ?>]" type='checkbox' <?php if($paymentMethod['active'] == '1') { echo "checked=checked"; } ?> />
                                    </td>
                                    <td>
                                        <input name="paymentMethodDisplayName[<?php echo $paymentMethod['id']; ?>]" type='text' style='padding: 5px; width: 200px;' value="<?php echo $paymentMethod['displayname']; ?>"/>
                                    </td>
                                    <td>
                                        <select name="paymentMethodStore[<?php echo $paymentMethod['id']; ?>]" style='padding: 5px; width: 200px;'>
                                            <option value='-1' <?php if($paymentMethod['store_id'] == '-1') { echo "selected"; } ?>>All Stores</option>
                                            <option value='0' <?php if($paymentMethod['store_id'] == '0') { echo "selected"; } ?>>Default</option>
                                            <?php foreach ($stores as $store) { ?>
                                                <option value="<?php echo $store['store_id']; ?>"<?php if($paymentMethod['store_id'] == $store['store_id']) { echo "selected"; } ?>><?php echo $store['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="paymentMethodGeoZone[<?php echo $paymentMethod['id']; ?>];?> "style='padding: 5px; width: 150px;'>
                                            <option value="-1">All Zones</option>
                                                <?php foreach ($geo_zones as $geoZone) { ?>
                                                <option value="<?php echo $geoZone['geo_zone_id']; ?>" <?php if($paymentMethod['geo_zone_id'] == $geoZone['geo_zone_id']) { echo "selected"; } ?>><?php echo $geoZone['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                            <br/>

                            <table class="form" width="100%">
                                <tr>
                                    <td style="border: 0;">
                                        <a href="icepay-savepaymentmethods" id="saveMyPaymentMethods" class="button" <?php if ($storedPaymentMethods->num_rows == 0) { echo 'style="display: none;"';} ?>>Save Paymentmethods</a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="tab-pane" id="tab-about">
                            <table class="form">
                                <tr>
                                    <td><?php echo $text_about_logo; ?></td>
                                </tr>
                                <tr>
                                    <td>Module version</td>
                                    <td><?php echo $text_version; ?></td>
                                </tr>
                                <tr>
                                    <td>Website</td>
                                    <td><?php echo $text_about_link; ?></td>
                                </tr>
                                <tr>
                                    <td>Support</td>
                                    <td><?php echo $text_about_support_link; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery('#getMyPaymentMethods').click(function (e) {
        e.preventDefault();

        jQuery.ajax({
            type: 'post', url: '<?php echo $icepay_ajax_get; ?>', data: {},
            beforeSend: function () {
                jQuery('#error-box').hide();
                jQuery('#payment-table').hide();
                jQuery('#getMyPaymentMethods').hide();
                jQuery('#saveMyPaymentMethods').hide();
                jQuery('#payment-table').nextAll('tr').remove();
                jQuery('#info-box').html('Loading paymentmethods, please wait...').fadeIn();
            },

            success: function (html) {
                jQuery('#info-box').html('Paymentmethods retrieved.').hide()

                if (html.indexOf("Error") >= 0) {
                    jQuery('#error-box').html(html).fadeIn();
                } else {
                    jQuery('#payment-table').fadeIn();
                    jQuery('#icepay-payment-methods').append(html);
                    jQuery('#saveMyPaymentMethods').fadeIn();
                    jQuery('#info-box').html('Paymentmethods retrieved successfully!').fadeIn();
                }

                jQuery('#getMyPaymentMethods').fadeIn();
            }
        });
    });

    jQuery('#saveMyPaymentMethods').click(function (e) {
        e.preventDefault();

        var formData = jQuery('#form').serialize();

        jQuery.ajax({
            type: 'post', url: '<?php echo $icepay_ajax_save; ?>', data: {content: formData},
            beforeSend: function () {
                jQuery('#error-box').hide();
                jQuery('#getMyPaymentMethods').hide();
                jQuery('#saveMyPaymentMethods').hide();
                jQuery('#info-box').html('Loading paymentmethods, please wait...').fadeIn();
                jQuery('#info-box').html('Saving paymentmethods, please wait...');
            },
            success: function (html) {
                jQuery('#icepay-payment-methods').append(html);
                jQuery('#saveMyPaymentMethods').fadeIn();
                jQuery('#getMyPaymentMethods').fadeIn();
                jQuery('#info-box').html('Loading paymentmethods, please wait...').fadeIn();
                jQuery('#info-box').html('Paymentmethods saved successfully!');
            }
        });
    });

    jQuery('#icepay_url').click(function (e) {
        jQuery(this).select();
    });
</script>

<?php echo $footer; ?>
