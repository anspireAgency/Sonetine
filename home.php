<?php // #Execute Agreement
// This is the second part of CreateAgreement Sample.
// Use this call to execute an agreement after the buyer approves it
require __DIR__  . '\vendor\autoload.php';
require __DIR__ . '\bootstrap.php';
// ## Approval Status
// Determine if the user accepted or denied the request
if (isset($_GET['success']) && $_GET['success'] == 'true') {

    $token = $_GET['token'];

    $agreement = new \PayPal\Api\Agreement();
    try {
        // ## Execute Agreement
        // Execute the agreement by passing in the token
        $agreement->execute($token, $apiContext);
    } catch (Exception $ex) {
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        echo '<script type="text/javascript">alert("'.$ex.'");</script>';
        //ResultPrinter::printError("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $ex);
        exit(1);
    }
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    //ResultPrinter::printResult("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $agreement);
    echo '<script type="text/javascript">alert("success");</script>';
    // ## Get Agreement
    // Make a get call to retrieve the executed agreement details
    try {
        $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);
    } catch (Exception $ex) {
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //ResultPrinter::printError("Get Agreement", "Agreement", null, null, $ex);
        echo '<script type="text/javascript">alert("'.$ex.'");</script>';
        exit(1);
    }
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    //ResultPrinter::printResult("Get Agreement", "Agreement", $agreement->getId(), null, $agreement);
    echo '<script type="text/javascript">alert("'.$agreement.'");</script>';
} else {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    //ResultPrinter::printResult("User Cancelled the Approval", null);
    //echo '<script type="text/javascript">alert("User Cancelled the Approval");</script>';
}
 ?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>

<body>
  <!-- <form action="first.php" method="POST"> -->
  <form action="CreatePlan.php" method="POST">
  <input  name="mySubmit" type="submit" value="Submit!" />
  <label>Agreement Name</label>
  <input name="agreement" id="agreement_name" type="text" value="test "/></br>
  <label for="Number of Post Design">Number of Posts Design</label>
  <input name="post" id="post_price" type="text" value="1"/></br>
  <label for="Number of Page Design">Number of Page Design</label>
  <input name="page" id="page_price" type="text" value="1"/><br>
  <label for="Number of GIF">Number of GIFs </label>
  <input name="gif" id="gif_price" type="text" value="1"/><br>
  <input type="button" onclick="update()" value="calculate"/>
  <label for="total"/>total</label><input name="total_price" id="total" type="text"  /><br>
  </form>
    <div id="paypal-button-container"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
    function update(){
        document.getElementById('total').value=(parseInt(document.getElementById('post_price').value)*10+parseInt(document.getElementById('page_price').value)*10+parseInt(document.getElementById('gif_price').value)*10)*1.04;
    }
        paypal.Button.render({
            env: 'sandbox', // sandbox | production
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AY2SsojPsynvm-BrQRDB8ZAs47ryDpobAmBIMck1CfRtcDocBWx1MG_lSuWOOORuyK0ztUB78gJzU8sU',
                production: '<insert production client id>'
            },

 <!-- -u "AY2SsojPsynvm-BrQRDB8ZAs47ryDpobAmBIMck1CfRtcDocBWx1MG_lSuWOOORuyK0ztUB78gJzU8sU:EDqp1sHC9NRk7-KAtHIesL9-XUOR95bskxMxCA7sLAjG59nwarcQn8rX4KZkaqbsB7YB87f0rCGytO-H" \ -->
            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                var total= $("#total").val()

                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: total , currency: 'USD' }
                            }
                        ]
                    }
                });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                    window.alert('Payment Complete!');
                });
            }

        }, '#paypal-button-container');

    </script>
</body>
