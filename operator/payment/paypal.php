<?php

/**
 * Paypal Class
 *
 * Integrate the Paypal payment gateway in your site using this easy
 * to use library. Just see the example code to know how you should
 * proceed. Btw, this library does not support the recurring payment
 * system. If you need that, drop me a note and I will send to you.
 *
 * @package		Payment Gateway
 * @category	Library
 * @author      Md Emran Hasan <phpfour@gmail.com>
 * @link        http://www.phpfour.com
 */

include_once ('PaymentGateway.php');

class Paypal extends PaymentGateway
{

    /**
	 * Initialize the Paypal gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
        parent::__construct();

        // Some default values of the class
		$this->gatewayUrl = 'https://www.paypal.com/cgi-bin/webscr';
		$this->gatewayUrlIPN = 'https://ipnpb.paypal.com/cgi-bin/webscr';
		$this->ipnLogFile = 'paypal.ipn_results.log';

		// Populate $fields array with a few default
		$this->addField('rm', '2');           // Return method = POST
		$this->addField('cmd', '_xclick');
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode()
    {
        $this->testMode = TRUE;
        $this->gatewayUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->gatewayUrlIPN = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    }

    /**
	 * Validate the IPN notification
	 *
	 * @param none
	 * @return boolean
	 */
	public function validateIpn() {

		if (!count($_POST)) {
			file_put_contents($this->ipnLogFile, "Missing POST Data", FILE_APPEND);
            return false;
        }

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
        	$this->ipnData["$key"] = $value;
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

		// Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->gatewayUrlIPN);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        // curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");

        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if (!($res = curl_exec($ch))) {
            file_put_contents($this->ipnLogFile, "Got " . curl_error($ch) . " when processing IPN data", FILE_APPEND);
            curl_close($ch);
            return false;
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        if ($http_code != 200) {
        	file_put_contents($this->ipnLogFile, "PayPal responded with http code $http_code", FILE_APPEND);
    		return false;
        }
        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if (strcmp ($res, "VERIFIED") == 0) {
		  	// The IPN is verified, process it
        	return true;
		} else if (strcmp ($res, "INVALID") == 0) {
		  	// IPN invalid, log for manual investigation
			$this->lastError = "IPN Validation Failed . $urlParsed[path] : $urlParsed[host] : $this->ipnResponse";
			file_put_contents($this->ipnLogFile, $this->lastError, FILE_APPEND);
            return false;
		}

	}
}
?>