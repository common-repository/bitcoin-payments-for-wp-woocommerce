<?php
/**
  * @copyright (c) 2014, Webplanex Infotech PVT. LTD. All Rights Reserved.
  * Disclaimer: This is the free product copyis provided as is without any guarantees or warranty. In association with the product, webplanex makes no warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, of title, or of noninfringement of third party rights. Use of the product by a user is at the user’s risk..
*/
 
include("BitcoinApi.php");
include("global.php");
 $api = new BitcoinApi;

//echo $userdata['remaining_withdraw_amount'];
if(isset($_REQUEST['submit']))    
{
    $post_array = array();
    $post_array["username"]=  get_option('btc_username');
    $post_array["password"]=get_option('btc_password');
    $post_array["amount"] = $_REQUEST['amount'];
    $post_array["total_amount"] = $_REQUEST['total_amount'];
    $post_array["bitcoin_address"] = $_REQUEST['bitcoin_address'];
   
    $apicallpath = get_option('btc_apipath') . WITHDRAW;
    $returndata = $api->getSocialUserAuthentication($post_array, $apicallpath);
 //   print_r($returndata);
}
$postarray = array();
$postarray["username"]= get_option('btc_username');
$postarray["password"]= get_option('btc_password');

$apicallpathdata = get_option('btc_apipath') . WITHDRAWDATA;

$userreturndata = $api->getSocialUserAuthentication($postarray, $apicallpathdata);
$userdata=$userreturndata['data'][0]['userdata'][0];
?>

<div class="wrap">
<h2>Withdraw Fund From Order</h2>
<?php
if (isset($returndata['status']) && $returndata['status'] == 'success') {
    ?>
        <div class="updated"><p><?php echo $returndata['message']; ?></p></div>
    <?php
} else if (isset($returndata['status']) &&  $returndata['status'] == 'failed') {
    ?>
        <div class="error"><p><?php echo $returndata['message']; ?></p></div>
    <?php
}
?>
 <?php
        if($success=='yes')
        {
            ?>
            <div class="updated"><p><?php echo $successmsg; ?></p></div>
            <?php
        }else if($error=='yes')
        {
            ?>
            <div class="error"><p><?php echo $errormsg; ?></p></div>
            <?php
        }
        ?>
<form method="post" action="" name="f1">
<input type='hidden' name='option_page' value='general' /><input type="hidden" name="action" value="update" /><input type="hidden" id="_wpnonce" name="_wpnonce" value="605eb1cb96" /><input type="hidden" name="_wp_http_referer" value="/wordpress_bitcoin/wp-admin/options-general.php" />
<table class="form-table">
<tr>
<th scope="row"><label for="amount">Total Ramaining Balance</label></th>
<td><?php echo $userdata['total_amount']; ?></td>
</tr>
<tr>
<th scope="row"><label for="amount">Withdraw Amount</label></th>
<td><?php echo $userdata['withdraw_amount']; ?></td>
</tr>
<tr>
<th scope="row"><label for="amount">Amount</label></th>
<td><input name="amount" type="text" id="amount" value="" class="regular-text" /></td>
</tr>
<tr>
<th scope="row"><label for="Bitcoin Address">Bitcoin Address</label></th>
<td>
    <input name="bitcoin_address" type="text" id="bitcoin_address" value="<?php echo get_option('btc_bitcoinaddress'); ?>"  class="regular-text" />
</td>
</tr>
</table>
<p class="submit">
    <input type="hidden" name="withdraw_amount" value="<?php echo $userdata['withdraw_amount']; ?>" id="withdraw_amount">
    <input type="hidden" name="total_amount" value="<?php echo $userdata['total_amount']; ?>" id="total_amount">
    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  /></p>
</form>

</div>




