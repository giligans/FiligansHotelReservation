<?php
use Payum\Core\Storage\FilesystemStorage;

$detailsClass = 'Payum\Core\Model\ArrayObject';
$tokenClass = 'Payum\Core\Model\Token';

$paypalExpressCheckoutPaymentFactory = new \Payum\Paypal\ExpressCheckout\Nvp\PaymentFactory();

return array(
    
    'token_storage' => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $tokenClass, 'hash'),
  // $tokenStorage = new FilesystemStorage('/home/vagrant/tmp', 'Paypal\Model\PaymentSecurityToken', 'hash');
    'payments' => array(
        'paypal_ec' => $paypalExpressCheckoutPaymentFactory->create(array(
            'username' => 'tan_0300-facilitator_api1.yahoo.com',
            'password' => 'RSQPLL88PJKSLUA8',
            'signature' => 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AGSTvgJSlWjj9gR-Hvi-fFjR-Fhz',
            'sandbox' => true
        )),
    ),
    'storages' => array(
        $detailsClass => new FilesystemStorage(__DIR__.'/../../../../storage/payments', $detailsClass),
    )
);
