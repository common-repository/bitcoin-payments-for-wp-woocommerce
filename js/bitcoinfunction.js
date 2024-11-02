jQuery(document).ready(function () {
    jQuery("#simulate").click(function () {
        jQuery("#sumylatebutton").hide();
        jQuery("#processing").show();

        var bitcoin_address = jQuery("#bitcoin_address").val();
        var orderid = jQuery("#orderid").val();
        var cartorderid = jQuery("#cartorderid").val();
        var price = jQuery("#price").val();
        var redirecturl = jQuery("#redirecturl").val();
     //   alert(MyAjax.ajaxurl)
        jQuery.ajax({
            type: 'POST',
            url: MyAjax.ajaxurl,
            data: {"action": "checkorder", "bitcoin_address": bitcoin_address, "orderid": orderid, "cartorderid": cartorderid, "price": price},
            success: function (data) {
                if (data.trim() == 'success')
                {
                    jQuery("#sumylatebutton").hide();
                    jQuery("#processing").html("Payment Done Successfully");
                        window.location.href = redirecturl;
                }
                else
                {
                    jQuery("#processing").html("Payment Not Completed");
                    setTimeout(function () {
                        jQuery("#sumylatebutton").show();
                        jQuery("#processing").hide();
                    }, 3000);
                }
            }
        });
    });
});