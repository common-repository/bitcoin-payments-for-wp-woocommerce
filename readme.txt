=== Bitcoin Payments for WP WooCommerce ===
Contributors: webplanex, bitcoin.org
Donate link: 
Tags: bitcoin, bitcoin wordpress plugin, bitcoin plugin, bitcoin payments, accept bitcoin, bitcoins
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Bitcoin Payments for WooCommerce is a Wordpress plugin that allows to accept bitcoins at WooCommerce-powered online stores.

== Description ==

Your online store must use WooCommerce platform (free wordpress plugin).
Once you installed and activated WooCommerce, you may install and activate Bitcoin Payments for WooCommerce.

= Benefits =

* Fully automatic operation
* Accept payments in bitcoins directly into your personal QT wallet.
* Electrum wallet payment option completely removes dependency on any third party service and middlemen.
* Accept payment in bitcoins for physical and digital downloadable products.
* Add bitcoin payments option to your existing online store with alternative main currency.
* Support for many currencies.
* Set main currency of your store in any currency or bitcoin.
* Automatic conversion to bitcoin via realtime exchange rate feed and calculations.
* Ability to set exchange rate calculation multiplier to compensate for any possible losses due to bank conversions and funds transfer fees.


== Installation ==

We maintain 2 setup one is wordpress plugin and second is for server where your QT bitcoin installed. Below we define the steps to install both set up files.
Need to follow below steps for dedicated remote/local  server.

1. Your server must be a dedicated server you need to install QT bitcoin, PHP and MYSQL, Download bitcoin-setup.zip (http://www.webplanex.co.in/Plugins/BitcoinPayment/bitcoin-setup.zip) file and install it on your server, server require to install PHP(> 5.1.0) and MYSQL(> 5.0.1),  please check http://www.wampserver.com/en/  for details.

2. Download and install on your computer QT bitcoin wallet program from here:  https://bitcoin.org/en/download.

3. Run and setup your wallet, wait till it’s sync  successfully. Now you have to create a bitcoin.conf file on specified path and it’s depends on the operation system of your server.
For windows it on: C:\Users\<username>\AppData\Roaming\Bitcoin
For Ubunthu or linux: /home/<username>/.bitcoin/
You need to add below line in bitcoin.conf.

rpcuser=<bitcoin username>
rpcpassword=<bitcoin password>
rpcport=<bitcoin port>  //default port is 8333.
testnet=1  //To run it test mode.
server=1  //To make it server.

4. Need to setup bitcoin-setup.zip,  suppose you setup folder on your root of your virtual directory then the URL like http://machineipaddress/bitcoin-setup/ and one you got message “Your setup done successfully” means you have setup all things perfectly.


5. You need to set up the cron file (cron_orderbalance.php) that run by every  5 minutes.  Cron job will take care of all regular bitcoin payment processing tasks, like checking if payments are made and automatically completing the orders.

Reference link for apache and linux server that how to setup cron file. http://v1.corenominal.org/howto-setup-a-crontab-file/ 

Reference link for windows server that how to setup cron file.
http://technet.microsoft.com/en-us/library/cc725745.aspx 


Need to follow below steps for wordpress public site. 
1. Install WooCommerce plugin and configure your store (if you haven't done so already - http://wordpress.org/plugins/woocommerce/).

2. Install "Bitcoin Payments for WP WooCommerce" wordpress plugin just like any other WordPress plugin.

3. Activate.

4. Once you install this plugin you can see bitcoin payment gateway tab in woocommerce payment gateway setting, you just need to enable it and update the required details.

5. Press [Save changes]

6. If you do not see any errors - your store is ready for operation and to access payments in bitcoins!


== Screenshots ==

1. Bitcoin Settings
2. Checkout with option for bitcoin payment.
3. Order received screen, including QR code of bitcoin address and payment amount.
4. Bitcoin Gateway settings screen for API.
5. Bitcoin Order List.

screenshot-1.png
screenshot-2.png
screenshot-3.png
screenshot-4.png
screenshot-5.png

== Remove plugin ==

1. Deactivate plugin through the 'Plugins' menu in WordPress
2. Delete plugin through the 'Plugins' menu in WordPress


== Changelog ==

No 

== Upgrade Notice ==

soon

== Frequently Asked Questions ==

Can I use this plug-in on more than one sites?
Absolutely

Where is the central repository from where the plug-in synchronizes bit-coin operations?
We have created a special 3rd party web-api bundle that can be installed on the server where you have QT client installed. You can download this bundle from http://www.webplanex.com

I have my own hosting server, where I have my web-site hosted. Can I install the sync web-api on the same server? Can I have the whole solution on one box?
Absolutely yes.
