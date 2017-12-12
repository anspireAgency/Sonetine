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
    echo '<script type="text/javascript">alert("success");</script>';
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
<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>
<div id="Billing"><?php echo $this->data['message'];?></div>

<?php echo form_open("Calculators/create_user");?>

      <p>
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

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

      <p>
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo lang('create_user_industry_label', 'industry');?> <br />
            <?php echo form_input($industry);?>
      </p>

      <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />
            <?php echo form_input($email);?>
      </p>

      <p>
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

<?php echo form_close();?>
