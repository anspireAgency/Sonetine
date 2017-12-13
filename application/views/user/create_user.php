<?php // #Execute Agreement
// This is the second part of CreateAgreement Sample.
// Use this call to execute an agreement after the buyer approves it
/*
require __DIR__ . '\..\bootstrap.php';
require __DIR__  . '\..\vendor\autoload.php';
*/

// ## Approval Status
// Determine if the user accepted or denied the request

if (isset($_GET['success']) && $_GET['success'] == 'true') {

//  require __DIR__ . '\..\bootstrap.php';
    $token = $_GET['token'];
    $temp=getApiContext('AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS','EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL');
    $agreement = new \PayPal\Api\Agreement();
    try {
        // ## Execute Agreement
        // Execute the agreement by passing in the token
        $agreement->execute($token, $temp);
    } catch (Exception $ex) {
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        echo '<script type="text/javascript">alert("'.$ex.'");</script>';
        //ResultPrinter::printError("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $ex);
        exit(1);
    }
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    //ResultPrinter::printResult("Executed an Agreement", "Agreement", $agreement->getId(), $_GET['token'], $agreement);
    //echo '<script type="text/javascript">alert("success");</script>';
    $this->data['message']='Billing Agreement Created successfully';
    //die( $this->data['message']);
    // ## Get Agreement
    // Make a get call to retrieve the executed agreement details
    try {
        $agreement = \PayPal\Api\Agreement::get($agreement->getId(), $temp);
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
 <html lang="en">

 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Create Profile</title>
   <link rel="stylesheet" href="<?php echo base_url();?>dist/css/style.css">
 </head>

 <body>
   <div id="infoMessage">
     <?php echo $message;?>
   </div>
   <div class="sonetine-container">
     <section id="first-section">
       <div class="container">
         <div class="row justify-content-center align-items-end">
           <div class="col-md-10 col-lg-7">
             <div class="sonetine-form">
               <h2 class="title">Get Started Today!</h2>
               <p>Why hire 1 graphic designer in-house? With Sonetine you’ll enjoy a variety of designs by all our creative graphic design team. Tons of money & time to save + Quality that you will rarely find.</p>
              <?php echo form_open("Calculators/create_user");?>
                 <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_fname_label', 'first_name');?>
                       <input type="text" name="first_name" class="form-control" id="first_name">
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_lname_label', 'last_name');?>
                       <input type="text" name="last_name" class="form-control" id="last_name">
                     </div>
                   </div>
                 </div>
                 <?php
                 if($identity_column!=='email') {
                     echo '<p>';
                     echo lang('create_user_identity_label', 'identity');
                     echo '<br />';
                     echo form_error('identity');
                     echo form_input($identity);
                     echo '</p>';
                 }
                 ?>
                 <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_email_label', 'email');?>
                       <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">

                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_phone_label', 'phone');?>
                       <input type="text" name="phone" class="form-control" id="phone">

                     </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_password_label', 'password');?>
                       <input type="password" name="password" class="form-control" id="password">

                     </div>
                   </div>


                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
                       <input type="password" name="password_confirm" class="form-control" id="password_confirm">

                     </div>
                   </div>

                 </div>
                 <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                       <?php echo lang('create_user_company_label', 'company');?>
                       <input type="text" name="company" class="form-control" id="company">
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                      <?php echo lang('create_user_industry_label', 'industry');?>
                       <input type="text" name="industry" class="form-control" id="industry">

                     </div>
                   </div>
                 </div>
                 <div class="text-center">
                   <button type="submit" class="btn btn-sub">Create Account</button>
                   <!-- <?php echo form_submit('submit', lang('create_user_submit_btn'));?>-->
                 </div>
                <?php echo form_close();?>
             </div>
           </div>
         </div>
       </div>
     </section>
     <section id="last-section">
       <div class="container">
         <div class="row justify-content-center">
           <div class="col-md-8 col-lg-7">
             <div class="row justify-content-center justify-content-md-start">
               <div class="col-md-8 col-lg-9">

                 <img src="<?php echo base_url();?>dist/images/pay-pal.png" alt="" class="pay-pal">
                 <p class="d-inline-block paypal-text">All Payments are securely done through Paypal if you face any problems, feel free to send us an email support@sonetine.com</p>
               </div>
               <div class="col-md-4 col-lg-3">
               <img src="<?php echo base_url();?>dist/images/sonetine-logo.png" alt="" class="w-100">
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>
   </div>


   <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
   <script src="<?php echo base_url();?>dist/js/popper.min.js"></script>
   <script src="<?php echo base_url();?>dist/js/bootstrap.min.js"></script>
   <script src="https://use.fontawesome.com/e3ee78ded9.js"></script>
 </body>

 </html>
