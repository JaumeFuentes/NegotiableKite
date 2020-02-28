<?php
/**
 * Example Usage of the BTCe API PHP Class
 *
 * @author marinu666
 * @license MIT License - https://github.com/marinu666/PHP-btce-api
 */
 
function envio_mail(){
	$email_origen = "no_reply@negotiablekite.com";
	$nombre_origen = " [Negotiable Kite]";
	
	//*****************************************************************//
	$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
	$headers .= "Return-Path: <$email_origen> \r\n"; 
	$headers .= "Reply-To: $email_origen \r\n"; 
	$headers .= "X-Sender: $email_origen \r\n"; 
	$headers .= "X-Priority: 3 \r\n"; 
	$headers .= "MIME-Version: 1.0 \r\n"; 
	$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
	$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
	//*****************************************************************//
	
		
	$asunto="operacion realizada";
	$mensaje="La operacion se ha realizado"; 		
	mail("superchauen@hotmail.com", $asunto, $mensaje, $headers);
}

require_once('btce-api.php');
$BTCeAPI = new BTCeAPI(
                    /*API KEY:    */    'TK35TY4K-RTTUXSLT-4PIR7OB0-27CJ6MWG-FBRZIX7G', 
                    /*API SECRET: */    '48bcdbd5db202d2992c1712fe5d36679f9ebd4efdfbcc63e8a663d1f7b5be415'
                      );

// Example getInfo
try {
    // Perform the API Call
    $getInfo = $BTCeAPI->apiQuery('getInfo');
    // Print so we can see the output
    //print_r($getInfo);
	//echo $getInfo['return']['funds']['btc'];
	//foreach($getInfo['return']['funds'] as $clave => $funds){
		//echo $clave.' = '.$funds.'</br>';
		
	//}
} catch(BTCeAPIException $e) {
    echo $e->getMessage();
}

// Example Custom query
/*try {
    // Input Parameters as an array (see: https://btc-e.com/api/documentation for list of parameters per call)
    $params = array('pair' => 'btc_usd'); // Show info for the btc_usd pair
    // Perform the API Query
    print_r($BTCeAPI->apiQuery('ActiveOrders', $params));
} catch(BTCeAPIException $e) {
    echo $e->getMessage();
}*/


// Making an order
//try {
    /*
     * CAUTION: THIS IS COMMENTED OUT SO YOU CAN READ HOW TO DO IT!
     */
    // $BTCeAPI->makeOrder(---AMOUNT---, ---PAIR---, BTCeAPI::DIRECTION_BUY/BTCeAPI::DIRECTION_SELL, ---PRICE---);
    // Example: to buy a bitcoin for $100
    // $BTCeAPI->makeOrder(1, 'btc_usd', BTCeAPI::DIRECTION_BUY, 100);
	
//} catch(BTCeAPIInvalidParameterException $e) {
//    echo $e->getMessage();
//} catch(BTCeAPIException $e) {
//    echo $e->getMessage();
//}

// Example Public API JSON Request (Such as Fee / BTC_USD Tickers etc) - The result you get back is JSON RESTed to PHP
// Fee Call
$ltc_btc = array();
//$ltc_btc['fee'] = $BTCeAPI->getPairFee('ltc_btc');
// Ticker Call
$ltc_btc['ticker'] = $BTCeAPI->getPairTicker('ltc_btc');
// Trades Call
//$ltc_btc['trades'] = $BTCeAPI->getPairTrades('ltc_btc');
// Depth Call
//$ltc_btc['depth'] = $BTCeAPI->getPairDepth('ltc_btcd');
// Show all information
//print_r($ltc_btc);
echo 'LTC ='.$getInfo['return']['funds']['ltc'];
echo '</br>';
echo 'SELL = '.$ltc_btc['ticker']['ticker']['sell'];
echo '</br>';
echo 'BUY = '.$ltc_btc['ticker']['ticker']['buy'];
echo '</br>';
echo 'SELL TARGET = 0.0206';
echo '</br>';
if( $ltc_btc['ticker']['ticker']['sell'] >= 0.0206 and $getInfo['return']['funds']['ltc'] >= 0.998){
	echo "GO!!";
	// Making an order
	try {		
		
		$BTCeAPI->makeOrder(0.998, 'ltc_btc', BTCeAPI::DIRECTION_SELL, 0.0206);
		envio_mail();
		
	} catch(BTCeAPIInvalidParameterException $e) {
	    echo $e->getMessage();
	} catch(BTCeAPIException $e) {
	    echo $e->getMessage();
	}
}
else
	echo "wait...";
			

?>
