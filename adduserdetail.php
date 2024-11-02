<?php
/**
  * @copyright (c) 2014, Webplanex Infotech PVT. LTD. All Rights Reserved.
  * Disclaimer: This is the free product copyis provided as is without any guarantees or warranty. In association with the product, webplanex makes no warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, of title, or of noninfringement of third party rights. Use of the product by a user is at the user’s risk..
*/

include("BitcoinApi.php");
include("global.php");
if (isset($_REQUEST['submit'])) {
    $api = new BitcoinApi;
    $post_array = array();
    $post_array["apipath"] = $_REQUEST['apipath'];
    $post_array["domainname"] = $_REQUEST['domainname'];
    $post_array["username"] = $_REQUEST['username'];
    $post_array["password"] = $_REQUEST['password'];

    $apicallpath = $_REQUEST['apipath'] . REGISTRATION;
    $returndata = $api->getSocialUserAuthentication($post_array, $apicallpath);

    if ($returndata['status'] == 'success') {
        update_option("btc_bitcoinaddress", $returndata['data'][0]['bitcoinaddress']);
        update_option("btc_apipath", $returndata['data'][0]['apipath']);
        update_option("btc_domainname", $returndata['data'][0]['domainname']);
        update_option("btc_username", $returndata['data'][0]['username']);
        update_option("btc_password", $returndata['data'][0]['password']);
    }
}
if (isset($_REQUEST['update'])) {

    $api = new BitcoinApi;
    $post_array = array();
    $post_array["apipath"] = $_REQUEST['apipath'];
    $post_array["domainname"] = $_REQUEST['domainname'];
    $post_array["username"] = $_REQUEST['username'];
    $post_array["password"] = $_REQUEST['password'];
    $apicallpath = $_REQUEST['apipath'] . UPDATEDETAIL;
    $returndata = $api->getSocialUserAuthentication($post_array, $apicallpath);

    //  print_r($returndata);
    if ($returndata['status'] == 'success') {
        //update_option("btc_bitcoinaddress",$returndata['data']['bitcoinaddress']);
        update_option("btc_apipath", $returndata['data'][0]['apipath']);
        update_option("btc_domainname", $returndata['data'][0]['domainname']);
        // update_option("btc_username",$returndata['data']['username']);
        update_option("btc_password", $returndata['data'][0]['password']);
    }
}
?>

<div class="wrap">
    <h2>Bitcoin Configuration</h2>
<?php
if ($returndata['status'] == 'success') {
    ?>
        <div class="updated"><p><?php echo $returndata['message']; ?></p></div>
    <?php
} else if ($returndata['status'] == 'failed') {
    ?>
        <div class="error"><p><?php echo $returndata['message']; ?></p></div>
    <?php
}
?>


    <form method="post" action="" name="f1" onsubmit="return submitform(this)">
        <table class="form-table">
    <?php
    if (get_option('btc_username') != "") {
        ?>
                <tr>
                    <th scope="row"><label for="bitcoin_address">Bitcoin Address</label></th>
                    <td><b><?php echo get_option('btc_bitcoinaddress'); ?></b></td>
                </tr>
    <?php } ?>
            <tr>
                <th scope="row"><label for="apipath">API Path</label></th>
                <td><input name="apipath" type="text" id="apipath" value="<?php if (get_option('btc_username') != "") {
        echo get_option('btc_apipath');
    } else {
        echo $_REQUEST['apipath'];
    } ?>" class="regular-text" /><?php echo "(i.e http://&lt; server ip or domain name&gt;/)"; ?></td>
            </tr>
            <tr>
                <th scope="row"><label for="domainname">Domain name</label></th>
                <td><input name="domainname" type="text" id="domainname" value="<?php if (get_option('btc_username') != "") {
                echo get_option('btc_domainname');
            } else {
                echo $_REQUEST['domainname'];
            } ?>" class="regular-text" /></td>
            </tr>
            <tr>
                <th scope="row"><label for="username">Username</label></th>
                <td><input name="username" type="text" id="username" value="<?php if (get_option('btc_username') != "") {
                echo get_option('btc_username');
            } else {
                echo $_REQUEST['username'];
            } ?>" class="regular-text" <?php if (get_option('btc_username') != "") {
                echo "readonly";
            } ?> /></td>
            </tr>
            <tr>
                <th scope="row"><label for="password">Password</label></th>
                <td><input name="password" type="password" id="password" value="<?php if (get_option('btc_username') != "") {
                echo get_option('btc_password');
            } else {
                echo $_REQUEST['password'];
            } ?>" class="regular-text" /></td>
            </tr>
        </table>
        <p class="submit">
<?php if (get_option('btc_username') == "") { ?>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save"  />
<?php } else { ?>
                <input type="submit" name="update" id="update" class="button button-primary" value="Update"  />
<?php } ?>
        </p>    
    </form>

</div>




