<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

function encrypt_e($input, $ky) {
    $key = html_entity_decode($ky);
    $iv = "@@@@&&&&####$$$$";
    $data = openssl_encrypt($input, "AES-128-CBC", $key, 0, $iv);
    return $data;
}

function decrypt_e($crypt, $ky) {
    $key = html_entity_decode($ky);
    $iv = "@@@@&&&&####$$$$";
    $data = openssl_decrypt($crypt, "AES-128-CBC", $key, 0, $iv);
    return $data;
}

function generateSalt_e($length) {
    $random = "";
    srand((double) microtime() * 1000000);

    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";

    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }

    return $random;
}

function checkString_e($value) {
    if ($value == 'null')
        $value = '';
    return $value;
}

function getChecksumFromArray($arrayList, $key, $sort = 1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}

function getChecksumFromString($str, $key) {

    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}

function verifychecksum_e($arrayList, $key, $checksumvalue) {
    $arrayList = removeCheckSumParam($arrayList);
    ksort($arrayList);
    $str = getArray2StrForVerify($arrayList);
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);

    $finalString = $str . "|" . $salt;

    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;

    $validFlag = "FALSE";
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}

function verifychecksum_eFromStr($str, $key, $checksumvalue) {
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);

    $finalString = $str . "|" . $salt;

    $website_hash = hash("sha256", $finalString);
    $website_hash .= $salt;

    $validFlag = "FALSE";
    if ($website_hash == $paytm_hash) {
        $validFlag = "TRUE";
    } else {
        $validFlag = "FALSE";
    }
    return $validFlag;
}

function getArray2Str($arrayList) {
    $findme = 'REFUND';
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        $pos = strpos($value, $findme);
        $pospipe = strpos($value, $findmepipe);
        if ($pos !== false || $pospipe !== false) {
            continue;
        }

        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function getArray2StrForVerify($arrayList) {
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function redirect2PG($paramList, $key) {
    $hashString = getchecksumFromArray($paramList);
    $checksum = encrypt_e($hashString, $key);
}

function removeCheckSumParam($arrayList) {
    if (isset($arrayList["CHECKSUMHASH"])) {
        unset($arrayList["CHECKSUMHASH"]);
    }
    return $arrayList;
}

function getTxnStatus($requestParamList) {
    return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
}

function getTxnStatusNew($requestParamList) {
    return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
}

function initiateTxnRefund($requestParamList) {
    $CHECKSUM = getRefundChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
    $requestParamList["CHECKSUM"] = $CHECKSUM;
    return callAPI(PAYTM_REFUND_URL, $requestParamList);
}

function callAPI($apiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData = json_encode($requestParamList);
    $postData = 'JsonData=' . urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ));
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse, true);
    return $responseParamList;
}

function callNewAPI($apiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData = json_encode($requestParamList);
    $postData = 'JsonData=' . urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ));
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse, true);
    return $responseParamList;
}

function getRefundChecksumFromArray($arrayList, $key, $sort = 1) {
    if ($sort != 0) {
        ksort($arrayList);
    }
    $str = getRefundArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}

function getRefundArray2Str($arrayList) {
    $findmepipe = '|';
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        $pospipe = strpos($value, $findmepipe);
        if ($pospipe !== false) {
            continue;
        }

        if ($flag) {
            $paramStr .= checkString_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkString_e($value);
        }
    }
    return $paramStr;
}

function callRefundAPI($refundApiURL, $requestParamList) {
    $jsonResponse = "";
    $responseParamList = array();
    $JsonData = json_encode($requestParamList);
    $postData = 'JsonData=' . urlencode($JsonData);
    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $refundApiURL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $jsonResponse = curl_exec($ch);
    $responseParamList = json_decode($jsonResponse, true);
    return $responseParamList;
}

class PaytmController extends CartController {

    private $amount = 0;
    private $isFromWallet = true;

    public function index() {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        $tmp = session()->get('tmp_paytm');
        $paymentMethods = Cache::get('payment_methods');
        $loggedInUser = session()->get('user');
        $this->amount = session()->get('wallet_topup_amount', 0);
        
        if (floatval($this->amount) == 0) {
            $this->isFromWallet = false;
            $this->amount = floatval($tmp['final_total']);
        }

        $amount = $this->amount;
        if (request()->has('status') && request()->status == 'failed') {

            if ($this->isFromWallet == false) {
                return redirect()->route('checkout-payment')->with('err', 'Failed To Make Payment With PayUMoney. Kindly Select Another Option');
            } else {
                return redirect()->route('wallet-history')->with('err', 'Failed To Make Payment With PayUMoney. Kindly Select Another Option');
            }
        }
        if (isset($paymentMethods->paytm_payment_method) && $paymentMethods->paytm_payment_method == 1) {
            $mode = $paymentMethods->paytm_mode;
            $paytm_merchant_id = $paymentMethods->paytm_merchant_id;
            $paytm_merchant_key = $paymentMethods->paytm_merchant_key;
            $callback_url = env('APP_URL', 'default_value') . "paytm/success";
            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = $paytm_merchant_id;
            $paramList["ORDER_ID"] = "ORDS" . rand(10000, 99999999);
            $paramList["CUST_ID"] = $loggedInUser['user_id'];
            $paramList["INDUSTRY_TYPE_ID"] = "Retail";
            $paramList["CHANNEL_ID"] = "WEB";
            $paramList["TXN_AMOUNT"] = $amount;
            $paramList["WEBSITE"] = "WEBSTAGING";
            $paramList["CALLBACK_URL"] = $callback_url;
        }
        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList, $paytm_merchant_key);
        return view("payment-gateways.paytm")->with('paramList', $paramList)->with('checkSum', $checkSum);
    }

    public function complete(Request $request, $type = "cancel") {
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        $paymentMethods = Cache::get('payment_methods');
        $paytm_merchant_key = $paymentMethods->paytm_merchant_key;
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $isValidChecksum = verifychecksum_e($paramList, $paytm_merchant_key, $paytmChecksum); //will return TRUE or FALSE string.

        $this->TXN_AMOUNT = session()->get('wallet_topup_amount', 0);

        if (floatval($this->TXN_AMOUNT) == 0) {
            $this->isFromWallet = false;
        }

        $error = "Payment either cancelled / failed to initialize. Try again or try some other payment method. Thank you";
        $amount = 0;

        if ($isValidChecksum == "TRUE") {
            echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";

            if ($_POST["STATUS"] == "TXN_SUCCESS") {

                $amount = $_POST["TXNAMOUNT"] ?? 0;

                //dd($amount);
                echo "<b>Transaction status is success</b>" . "<br/>";
                $transaction_id = $_POST['TXNID'];
                $loggedInUser = $request->session()
                        ->get('user');
                $data = $request->session()
                        ->get('tmp_paytm');

                $msg =  __('msg.payment_completed_successfully');
                $orderId = "";
                if ($this->isFromWallet == false) {
                    $response = $this->order_placed($request->session()
                                    ->get('tmp_paytm'));
                    $orderId = $response['data']['order_id'] ?? "";
                    if (intval($orderId)) {
                        $this->add_transaction($response['data']['order_id'], __('msg.paytm'), $transaction_id, true, $msg, $amount);
                        return redirect()->route('my-orders')
                                        ->with('suc', __('msg.order_success'));
                    }

                    $this->add_transaction($orderId, __('msg.paytm'), $transaction_id, false, $msg, $amount);
                    return redirect()->route('checkout-payment')
                                    ->with('err', $response['message'] ?? $msg);
                } else {
                    $this->message = session()->get('wallet_topup_message', 0);
                    $response = $this->topup_wallet($amount, __('msg.paytm'). $this->message);

                    if ($response['error'] == false) {

                        return redirect()->route('wallet-history')->with('suc', __('msg.wallet_recharge_successfully'));
                    } else {

                        $error = $response['message'];
                    }
                }
            } else {
                echo "<b>Transaction status is failure</b>" . "<br/>";
            }
            if (isset($_POST) && count($_POST) > 0) {
                foreach ($_POST as $paramName => $paramValue) {
                    echo "<br/>" . $paramName . " = " . $paramValue;
                }
            } else {
                echo "<b>Checksum mismatched.</b>";
            }
            if ($this->isFromWallet) {
                return redirect()->route('wallet-history')->with('err', $error);
            } else {
                return redirect()->route('checkout-payment')->with('err', $error);
            }
        }
    }

}
