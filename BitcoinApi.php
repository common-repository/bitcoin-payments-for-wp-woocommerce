<?php
/**
  * @copyright (c) 2014, Webplanex Infotech PVT. LTD. All Rights Reserved.
  * Disclaimer: This is the free product copyis provided as is without any guarantees or warranty. In association with the product, webplanex makes no warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, of title, or of noninfringement of third party rights. Use of the product by a user is at the user’s risk..
*/

class BitcoinApi {

    var $apikey;
    var $regapikey;
    var $getNPECountryUrl;
    var $PaymentAuthorizationUrl;
    var $getCountryUrl;
    var $saveSplitDonationUrl;
    var $saveRecurringSplitDonationUrl;
    var $saveMembershipUrl;
    var $GetDonationsByContactUrl;
    var $GetContactMembershipUrl;
    var $renewMembershipUrl;
    var $GetContactByContactId;
    var $UpdateContactUrl;
    var $changeMembershipUrl;
    var $PaymentVoidUrl;
    var $PaymentCaptureUrl;
    var $getRelationshipListUrl;

    function getSocialUserAuthentication($arrDataset,$url) {

        $jsondataset = json_encode($arrDataset);
        
        $res = $this->getRestfulResponce($url, $jsondataset, 'POST');

        $arrResultCheck = json_decode($res, true);

        if (is_array($arrResultCheck))
            $arrResult = json_decode($res, true);
        else
            $arrResult = $res;



        return $arrResult;
    }

    function getRestfulHeader() {

        return array('Accept: application/json; charset=utf-8', 'Content-Type: application/json; charset=utf-8');
    }

    function getRestfulResponce($url, $soap_request = '', $custom_request = 'GET') {

        global $callindex;

        $callindex = 1;



        $soap_do = curl_init();

        curl_setopt($soap_do, CURLOPT_URL, $url);

        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 0);

        curl_setopt($soap_do, CURLOPT_TIMEOUT, 0);

        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($soap_do, CURLOPT_CUSTOMREQUEST, $custom_request);

        curl_setopt($soap_do, CURLOPT_POST, true);

        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $soap_request);

        //curl_setopt($soap_do, CURLOPT_USERAGENT, 'NPE');

        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $this->getRestfulHeader());

        $output = curl_exec($soap_do);


        if ($output === false) {
        
            $err = 'Curl error: ' . curl_error($soap_do);

            curl_close($soap_do);

            //print $err;

            return false;
        } else {

            return ($output);
            
        }
        
         
    }

}

?>
