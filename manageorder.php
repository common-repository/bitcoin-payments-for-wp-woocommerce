<?php
/**
  * @copyright (c) 2014, Webplanex Infotech PVT. LTD. All Rights Reserved.
  * Disclaimer: This is the free product copyis provided as is without any guarantees or warranty. In association with the product, webplanex makes no warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, of title, or of noninfringement of third party rights. Use of the product by a user is at the user’s risk..
*/
 
include("BitcoinApi.php");
include("global.php");
global $wpdb;

$pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
$limit = 10; // number of rows in page
$offset = ( $pagenum - 1 ) * $limit;

$api=new BitcoinApi; 
$post_array=array();
$post_array["username"]=  get_option('btc_username');
$post_array["password"]=get_option('btc_password');
$post_array["offset"]=$offset;
$post_array["limit"]=$limit;
$post_array["search"]=$_REQUEST['s'];

 $apicallpath=  get_option('btc_apipath').ORDERLIST;
$returndata = $api->getSocialUserAuthentication($post_array,$apicallpath);
//echo "<pre>";
//print_r($returndata);
$total = $returndata['data'][0]['totalorder'];
$num_of_pages = ceil($total / $limit);
$entries = $returndata['data'][0]['orderlist'];

//print_r($entries );
$page_links = paginate_links( array(
    'base' => add_query_arg( 'pagenum', '%#%' ),
    'format' => '',
    'prev_text' => __( '&laquo;', 'text-domain' ),
    'next_text' => __( '&raquo;', 'text-domain' ),
    'total' => $num_of_pages,
    'current' => $pagenum
) );

?>
<div class="wrap">
    <form id="f1" name="f1" action="" method="post">
    <h2>Merchant Orders 
       
    </h2>
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
   
        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Search Address:</label>
            <input type="search" id="s" name="s" value="<?php $_REQUEST['s']; ?>" />
            <input type="submit" name="search" id="search" class="button" value="Search Pages"  /></p>
        
        <?php 
        if ( $page_links ) {
    echo '<div class="tablenav top"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}   
        ?>
        <table class="wp-list-table widefat fixed pages">
            <thead>
                <tr>
                    <th style="width: 30%">Order Address</th>
                    <th>Cart Order Id</th>
                    <th>Currency</th>
                    <th>Amount</th>
                    <th>Bitcoin</th>
                    <th>Payment Status</th>
                    <th style="text-align: right; padding-right: 20px">Date</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th style="width: 30%">Order Address</th>
                    <th>Cart Order Id</th>
                    <th>Currency</th>
                    <th>Amount</th>
                    <th>Bitcoin</th>
                    <th>Payment Status</th>
                    <th style="text-align: right;padding-right: 20px">Date</th>
                </tr>
            </tfoot>

            <tbody id="the-list">
                
            <?php
            if($num_of_pages > 0)
            {
                $i=1;                    
                foreach($entries as $result)
                {
                    
                ?>
                <tr <?php if($i%2!=0){?>class="alternate"<?php }?>>

                    <td style="color: #0074a2 !important; font-weight: bold"><?php echo $result['bitcoin_address']; ?></td>	
                    <td style="color: #0074a2 !important;"><?php echo "#".$result['cartorderid']; ?></td>
                    <td style="color: #0074a2 !important;"><?php echo $result['currency']; ?></td>
                    <td style="color: #0074a2 !important;"><?php echo $result['amount']; ?></td>
                    <td style="color: #0074a2 !important;"><?php echo $result['amount_bitcoin']; ?></td>
                    <td style="color: #0074a2 !important;">
                        <?php 
                        if($result['payment_status']=='0'){echo "<span style='color:red'>Unpaid</span>";}
                        else if($result['payment_status']=='1'){echo "<span style='color:green'>Paid</span>";}
                        else if($result['payment_status']=='2'){echo "<span style='color:red'>Partial Paid</span>";}
                        ?>
                        
                    </td>
                    
                    <td style="color: #0074a2 !important;text-align: right; padding-right: 20px" ><?php echo date('Y/m/d',strtotime($result['created_at'])); ?></td>
                </tr>
                <?php
                    $i++;
                }
            
            }
            else {?>
                <tr id="post-7" class="post-7 type-page status-publish hentry  iedit author-self level-0">
                
                    <td colspan="3">No item found</td>
            
            </tr>
                <?php }?>
            
            </tbody>
        </table>
        <?php 
        if ( $page_links ) {
    echo '<div class="tablenav bottom"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
}
        ?>
        

    </form>


    

    <div id="ajax-response"></div>
    <br class="clear" />
</div>



