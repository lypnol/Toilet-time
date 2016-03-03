<?php
ini_set('display_errors', 1);
error_reporting(-1);

require_once 'braintree/lib/Braintree.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId('qcdrb97rq7b932g5');
Braintree_Configuration::publicKey('8tcf88kn9gp3rbgt');
Braintree_Configuration::privateKey('b3e602fa0b47b2ba3ef4r9f58013963e');

if(isset($_GET['tocken'])){
	echo($clientToken = Braintree_ClientToken::generate());
}

else if(isset($_POST["payment_method_nonce"])){
	$nonce = $_POST["payment_method_nonce"];
	$result = Braintree_Transaction::sale([
	  'amount' => '1.00',
	  'paymentMethodNonce' => $nonce
	]);
	if(get_class($result)=="Braintree_Result_Successful"){
		header("location: index.php?payment=success");
	}
	else{
		header("location: index.php?payment=failure");
	}
}
exit;
?>
