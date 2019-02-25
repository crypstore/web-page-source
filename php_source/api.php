<?php

function CallAPI($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

function CallAPI_BCRA($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: BEARER eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE1ODI2NjI4ODYsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJmcGVsbGljY2lvbmlAZ21haWwuY29tIn0.10IC2BvZUPtWhwoakUbt9IQb-PT-HsaIWOLslcjQZB1-w7oEGIZableVMPlTBYYKHKRzr0sHf0m0Q_jcqm17bQ'
    ));


    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}



// $response = CallAPI("GET", "https://bitex.la/api/tickers/btc_usd");
// $response = json_decode($response, true);

// echo $response["data"]["attributes"]["last"];

// http://api.estadisticasbcra.com/usd : cotización del USD
// http://api.estadisticasbcra.com/usd_of : cotización del USD Oficial

// $response = CallAPI_BCRA("GET", "http://api.estadisticasbcra.com/usd");
// $response = CallAPI_BCRA("GET", "http://api.estadisticasbcra.com/usd_of");

// $response = json_decode($response, true);

// // echo $response["data"]["attributes"]["last"];

// // print_r($response);


// $cant = count($response);

// echo $cant;

// print_r($response[0]);
// print_r($response[$cant - 1]);


function CotizacionDolar() {

$response = CallAPI("GET", "https://www.bna.com.ar/Cotizador/MonedasHistorico");
// echo $response;
// print($response);


$mystring = 'abc';
$findme   = '<td class="dest">';
$findme2   = '</td>';
$pos = strpos($response, $findme);

if ($pos === false) {
    return 0;
}

$pos = strpos($response, $findme, $pos + 1);
if ($pos === false) {
    return 0;
}

$pos2 = strpos($response, $findme2, $pos);
if ($pos2 === false) {
    return 0;
}

$from = $pos + strlen($findme);
$len = $pos2 - $from;
$cot = substr($response, $from, $len);    // devuelve "f"

// echo "*" . $cot . "*" . '<br>';

$cot = $cot * 1.0;
return floatval($cot);

}

function CotizacionBitex() {
$response = CallAPI("GET", "https://bitex.la/api/tickers/btc_usd");
$response = json_decode($response, true);
$ret = $response["data"]["attributes"]["last"];

$ret = $ret * 1.0;
return $ret;

}

// $locale_info = localeconv();
// echo 'decimal_point=', $locale_info['decimal_point'], '<br/>';

$comision = 1.2;
$dolar = CotizacionDolar();
$bitex = CotizacionBitex();

$crypstore = $dolar * $bitex;
// $crypstore = $crypstore * $comision;

// echo $dolar . '<br>';
// echo $bitex . '<br>';

echo $crypstore . '<br>';

?>