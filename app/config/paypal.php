<?php
return array(
// set your paypal credential
'client_id' => 'ARFIcxBKBzHfxYNvJB5b0B12DIoqRA7C_CBLlNXpWiDrhiucovjovhonhArb',
'secret' => 'EOhecBBKf4bqzmMqLup4wz_F8Ktinlms_QN6RoTajDbV-2iLAfEB0oSPwSDn',
/**
* SDK configuration 
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'sandbox',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 30,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
);