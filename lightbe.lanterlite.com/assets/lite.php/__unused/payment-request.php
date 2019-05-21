<?php

// URL Payment IPAYMU
$url = 'https://my.ipaymu.com/payment.htm';

// Prepare Parameters
$params = array(
            'key'      => 'api_key_merchant', // API Key Merchant / Penjual
            'action'   => 'payment',
            'product'  => 'Nama Produk',
            'price'    => '101000', // Total Harga
            'quantity' => 1,
            'comments' => 'Keterangan Produk', // Optional           
            'ureturn'  => 'http://websiteanda.com/return.php',
            'unotify'  => 'http://websiteanda.com/notify.php',
            'ucancel'  => 'http://websiteanda.com/cancel.php',

            /* Parameter untuk pembayaran lain menggunakan PayPal 
             * ----------------------------------------------- */
            'paypal_email'   => 'email_paypal_merchant',
            'paypal_price'   => 1, // Total harga dalam kurs USD
            'invoice_number' => uniqid('INV-'), // Optional
            /* ----------------------------------------------- */
            
            'format'   => 'json' // Format: xml / json. Default: xml 
        );

$params_string = http_build_query($params);

//open connection
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($params));
curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

//execute post
$request = curl_exec($ch);

if ( $request === false ) {
    echo 'Curl Error: ' . curl_error($ch);
} else {
    
    $result = json_decode($request, true);

    if( isset($result['url']) )
        header('location: '. $result['url']);
    else {
        echo "Request Error ". $result['Status'] .": ". $result['Keterangan'];
    }
}

//close connection
curl_close($ch);

?>