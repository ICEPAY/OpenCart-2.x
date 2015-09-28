<form action="<?php echo $action; ?>" method="post" id="payment">
    <?php if (count($issuers) > 1) { ?>
        <h2><?php echo $displayname; ?></h2>

        <div class="content" id="payment">
            <table class="form">
                <tr>
                    <td>Please select your issuer</td>
                </tr>
                <tr>
                    <td>Issuer</td>
                    <td><select name="ic_issuer" style="padding: 5px;">
                            <?php foreach ($issuers as $issuer) { ?>
                                <option value="<?php echo $issuer['IssuerKeyword']; ?>"><?php echo $issuer['Description']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    <?php } else { ?>
        <input type="hidden" name="ic_issuer" value="<?php echo $issuers[0]['IssuerKeyword']; ?>"/>
    <?php } ?>

    <div class="buttons">
        <div class="pull-right">
            <a id="button-confirm" onclick="$('#payment').submit();" class="btn btn-primary"><span><?php echo $button_confirm; ?></span></a>
        </div>
    </div>
</form>
