<?php
/**
 * @copyright (c) 2014, Webplanex Infotech PVT. LTD. All Rights Reserved.
 * Disclaimer: This is the free product copyis provided as is without any guarantees or warranty. In association with the product, webplanex makes no warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, of title, or of noninfringement of third party rights. Use of the product by a user is at the user�s risk..
 */
include("BitcoinApi.php");
include("global.php");
include("QRCode.class.php");
$oQRC = new QRCode;
$order = new WC_Order( $_REQUEST['order'] );
//$order->update_status('on-hold', __( 'Your order wont be shipped until the funds have cleared in our account.', 'woocommerce' ));
//$order->reduce_order_stock();

$order_id = $_REQUEST['order'];
$page = get_page_by_title( 'checkout' );
$redirecturl = add_query_arg('key', $order->order_key, add_query_arg('order', $order_id, get_permalink($page->ID)));

$cartorderid = $_REQUEST['order'];
$price = $order->get_total();
$currency = $order->get_order_currency();

$api = new BitcoinApi;
$post_array = array();
$post_array["username"] = get_option('btc_username');
$post_array["password"] = get_option('btc_password');
$post_array["cartorderid"] = $cartorderid;
$post_array["currency"] = $currency;
$post_array["price"] = $price;

$apicallpath = get_option('btc_apipath') . ORDER;
$returndata = $api->getSocialUserAuthentication($post_array, $apicallpath);
 // echo "<pre>";print_r($returndata);

if(isset($returndata['status']) && $returndata['status'] == 'success')
{
    
?><form method="post" name="f1">

    <table style="width: 100%">
        <tr><td colspan="3"><h5>Order Received</h5></td></tr>
        <tr><td colspan="3">Thank You. Your order has been received.</td></tr>
        <tr>
            <td style="width: 33%">Order : <br> <b><?php echo "#".$returndata['data'][0]['cartorderid']; ?></b></td>
            <td style="width: 33%">Date : <br> <b><?php echo $returndata['data'][0]['curdate']; ?></b></td>
            <td style="width: 34%">Total (<?php echo $returndata['data'][0]['currency']; ?>) : <br> <b><?php echo $returndata['data'][0]['amount']; ?></b></td>
        </tr>
        <tr><td colspan="4">Please send your bitcoin payment as follows.</td></tr> 
        <tr><td>Payment Method</td><td colspan="2" style="font-weight: bold;">Bitcoin Payment</td></tr>
        <tr><td>Amount (BTC)</td><td colspan="2" style="font-weight: bold; color: red"><?php echo $returndata['data'][0]['amount_bitcoin']; ?></td></tr>
        <tr><td >Address </td><td colspan="2" style="font-weight: bold; "><?php echo $returndata['data'][0]['bitcoin_address']; ?></td></tr>
        <tr><td style=" vertical-align: top" >QR Code</td><td colspan="2"><?php
                $oQRC->fullName($returndata['data'][0]['bitcoin_address'])->finish();
                $oQRC->display();
                ?></td></tr>
        <tr><td colspan="3">
                <input type="hidden" name="orderid" id="orderid" value="<?php echo $returndata['data'][0]['orderid']; ?>">
                <input type="hidden" name="cartorderid" id="cartorderid" value="<?php echo $returndata['data'][0]['cartorderid']; ?>">
                <input type="hidden" name="bitcoin_address" id="bitcoin_address" value="<?php echo $returndata['data'][0]['bitcoin_address']; ?>">
                <input type="hidden" name="price" id="price" value="<?php echo $returndata['data'][0]['price']; ?>">
                <input type="hidden" name="currency" id="currency" value="<?php echo $returndata['data'][0]['currency']; ?>">
                
                 <input type="hidden" name="redirecturl" id="redirecturl" value="<?php echo $redirecturl; ?>">

                <div id="sumylatebutton"><input type="button" name="simulate" id="simulate" value="Simulate"></div>
                <div id="processing" style="display: none">Processing...</div>

            </td></tr>

    </table>
</form>

<?php
}
else
{
echo "invalid user";
}
?>
