<?php

/**
 * Plugin Name: Bitcoin Payments for WP WooCommerce
 * Plugin URI:  http://www.webplanex.co.in/Plugins/BitcoinPayment/
 * Description: Bitcoin Payment for wordpress woocommerce
 * Version:  1.0
 * Author:  Webplanex
 * Author URI: http://www.webplanex.com
 * License: A "Slug" license name e.g. GPL2
 */
register_activation_hook(__FILE__, 'bitcoinpayment_activate');
register_deactivation_hook(__FILE__, 'bitcoinpayment_deactivate');
register_uninstall_hook(__FILE__, 'bitcoinpayment_uninstall');

function bitcoinpayment_activate() {
    global $wpdb;

    add_option('btc_apipath', '', '', 'yes');
    add_option('btc_bitcoinaddress', '', '', 'yes');
    add_option('btc_domainname', '', '', 'yes');
    add_option('btc_username', '', '', 'yes');
    add_option('btc_password', '', '', 'yes');
    if (get_page_by_title('bitcoinorder', page) == NULL) {
        $post = array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => 1,
            'post_date' => date('Y-m-d H:i:s'),
            'post_name' => 'bitcoinorder',
            'post_status' => 'publish',
            'post_title' => 'bitcoinorder',
            'post_type' => 'page',
            'post_content' => '[bitcoinpayment]'
        );
        //insert page and save the id
        $newvalue = wp_insert_post($post, false);
    }
}

function bitcoinpayment_deactivate() {
    global $wpdb;
}

function bitcoinpayment_uninstall() {
    global $wpdb;
    delete_option('btc_apipath');
    delete_option('btc_bitcoinaddress');
    delete_option('btc_domainname');
    delete_option('btc_username');
    delete_option('btc_password');
}

add_action('admin_menu', 'userdemo');

function userdemo() {

    add_menu_page('Bitcoin Payment', 'Bitcoin Payment', 'administrator', 'managebitcoin', 'managebitcoin', plugins_url('bitcoin-payments-for-wp-woocommerce/images/bitcoin_wp.png'));
    add_submenu_page("managebitcoin", "Manage Orders", "Bitcoin Order", 0, "manageorder", "manageorder");
    add_submenu_page("managebitcoin", "Withdraw", "Withdraw", 0, "withdraw", "withdrawfromorder");
    add_submenu_page("managebitcoin", "Receive Transaction", "Receive Transaction", 0, "receivetransaction", "receivetransaction");
    add_submenu_page("managebitcoin", "Send Transaction", "Send Transaction", 0, "sendtransaction", "sendtransaction");
}

function manageorder() {
    include("manageorder.php");
}

function managebitcoin() {
    include("adduserdetail.php");
}

function Withdrawfromorder() {
    include("withdrawfromorder.php");
}

function sendtransaction() {
    include("sendtransaction.php");
}

function receivetransaction() {
    include("receivetransaction.php");
}

//checkorder code start
wp_enqueue_script('mainfunction', plugins_url('/js/functions.js', __FILE__), array('jquery'));

wp_enqueue_script('function', plugins_url('/js/bitcoinfunction.js', __FILE__), array('jquery'));

// including ajax script in the plugin Myajax.ajaxurl
wp_localize_script('function', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

function checkorder() {
    include("BitcoinApi.php");
    include("global.php");
    if ($_POST['orderid'] == "" || $_POST['bitcoin_address'] == "") {
        die("unsuccess");
        return true;
    } else {
        $api = new BitcoinApi;
        $post_array = array();
        $post_array["username"] = get_option('btc_username');
        $post_array["password"] = get_option('btc_password');
        $post_array["orderid"] = $_POST['orderid'];
        $post_array["cartorderid"] = $_POST['cartorderid'];
        $post_array["bitcoin_address"] = $_POST['bitcoin_address'];
        $apicallpath = get_option('btc_apipath') . SIMULATE;
        $returndata = $api->getSocialUserAuthentication($post_array, $apicallpath);
        //print_r($post_array);
        if ($returndata['status'] == 'success') {
            $order = new WC_Order($_POST['cartorderid']);
            $order->update_status('on-hold', __('Your order wont be shipped until the funds have cleared in our account.', 'woocommerce'));
            $order->reduce_order_stock();
            die("success");
            return true;
        } else {

            die("unsuccess");
            return true;
        }
    }
}

add_action('wp_ajax_checkorder', 'checkorder'); // Call when user logged in
add_action('wp_ajax_nopriv_checkorder', 'checkorder'); // Call when user in not logged in
//checkorder code  end

function Bitcoin_Payment() {
    include("getpaymentbutton.php");
}

add_shortcode('bitcoinpayment', 'Bitcoin_Payment');

//Wocommerse code start
//Additional links on the plugin page
add_filter('plugin_row_meta', 'wcCpg_register_plugin_links', 10, 2);

function wcCpg_register_plugin_links($links, $file) {
    $base = plugin_basename(__FILE__);
    /* if ($file == $base) {
      $links[] = '<a href="http://royaltechbd.com/" target="_blank">' . __( 'Royal Technologies', 'rsb' ) . '</a>';
      $links[] = '<a href="http://shamokaldarpon.com/" target="_blank">' . __( 'Shamokal Darpon', 'rsb' ) . '</a>';
      } */
    return $links;
}

/* WooCommerce fallback notice. */

function woocommerce_cpg_fallback_notice() {
    echo '<div class="error"><p>' . sprintf(__('WooCommerce Custom Payment Gateways depends on the last version of %s to work!', 'wcCpg'), '<a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a>') . '</p></div>';
}

/* Load functions. */

function custom_payment_gateway_load() {
    if (!class_exists('WC_Payment_Gateway')) {
        add_action('admin_notices', 'woocommerce_cpg_fallback_notice');
        return;
    }

    function wc_Custom_add_gateway($methods) {
        $methods[] = 'WC_Custom_Payment_Gateway_1';

        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'wc_Custom_add_gateway');


    // Include the WooCommerce Custom Payment Gateways classes.
    require_once plugin_dir_path(__FILE__) . 'bitcoin_payment.php';
}

add_action('plugins_loaded', 'custom_payment_gateway_load', 0);



/* Adds custom settings url in plugins page. */

function wcCpg_action_links($links) {
    $settings = array();
    /* $settings = array(
      'settings' => sprintf(
      '<a href="%s">%s</a>',
      admin_url( 'admin.php?page=woocommerce_settings&tab=payment_gateways' ),
      __( 'Payment Gateways', 'wcCpg' )
      )
      ); */

    return array_merge($settings, $links);
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wcCpg_action_links');

//woocommere code end
?>
