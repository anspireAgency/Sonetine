

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Sonetine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <script src="https://www.paypalobjects.com/api/checkout.js"></script>-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>dist/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/e3ee78ded9.js"></script>
      <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css">
      <style type="text/css">
      /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
      </style>
</head>

<body>
  <!-- <?php echo $_SESSION['email'];?>-->
  <?php if(isset($error)){ echo $error;} ?></div>

  <div class="sonetine-container">
    <section id="first-section">
      <div class="container">
        <div class="row justify-content-center align-items-end">
          <div class="col-md-10 col-lg-7">
            <div class="sonetine-form sonetine-content">
              <h1 class="title-cal text-center">Sonetine Calculator</h1>
              <p class="info text-center">Build your agreement with us based on your business needs</p>
              <div class="cards-container">


              <div class="row">
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <label class="switch">
                        <input id="page"  type="checkbox">
                        <span class="slider"></span>
                      </label>
                      <!--<input type="button" name="page" id="page_price" value="0"  class="card-title">-->
                      <p class="card-text">Page cover</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <label class="switch">
                        <input id="post"  type="checkbox">
                        <span class="slider"></span>
                      </label>
                      <!--<input type="button" name="page" id="page_price" value="0"  class="card-title">-->
                      <p class="card-text">post</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <label class="switch">
                        <input id="gif"  type="checkbox">
                        <span class="slider"></span>
                      </label>
                      <!--<input type="button" name="page" id="page_price" value="0"  class="card-title">-->
                      <p class="card-text">GIF</p>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="payment-container">
                <div class="row align-items-center text-center text-md-left">
                  <form id="request" action="request" method="post">
                <label>caption</label><input type="text" name="caption" value="<?php echo set_value('caption'); ?>" ></input><br>
                <label>time of post</label><input name="time" type="text" value="<?php echo set_value('time'); ?>" ></input><br>
                <label>Notes</label><input name="notes" type="text" value="<?php echo set_value('notes'); ?>" ></input><br>
                <input type="submit" value="submit"/>
                <input hidden="True" type="text" name="type" id="type" value=""/>
                <input hidden="true" name="page_id" id="page_id" type="text" value="<?php echo $pageid;?>" />
                <input hidden="true" name="page_name" id="page_name" type="text" value="<?php echo $pagename;?>"/>
                  </form>

                </div>
              </div>

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

                <img src="<?php echo base_url(); ?>dist/images/pay-pal.png" alt="" class="pay-pal">
                <p class="d-inline-block paypal-text">All Payments are securely done through Paypal if you face any problems, feel free to send us an email support@sonetine.com</p>
              </div>
              <div class="col-md-4 col-lg-3">
              <img src="<?php echo base_url(); ?>dist/images/sonetine-logo.png" alt="" class="w-100">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<script>
$(function() {

  // Get the form fields and hidden div
  var page = $("#page");
  var post = $("#post");
  var gif = $("#gif");
  var form = $("#request");


  // Hide the fields.
  // Use JS to do this in case the user doesn't have JS
  // enabled.
  form.hide();



  gif.change(function() {
    // Check to see if the checkbox is checked.
    // If it is, show the fields and populate the input.
    // If not, hide the fields.
    if (gif.is(':checked')) {
      post.prop('checked', false);
      page.prop('checked', false);
      $("#type").val('GIF');
      // Show the hidden fields.
      form.show();
      // Populate the input.
      //populate.val("Dude, this input got populated!");
    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      form.hide();

      // You may also want to clear the value of the
      // hidden fields here. Just in case somebody
      // shows the fields, enters data to them and then
      // unticks the checkbox.
      //
      // This would do the job:
      //
      // $("#hidden_field").val("");
    }
  });

  // Setup an event listener for when the state of the
  // checkbox changes.
  post.change(function() {
    // Check to see if the checkbox is checked.
    // If it is, show the fields and populate the input.
    // If not, hide the fields.
    if (post.is(':checked')) {
      page.prop('checked', false);
      gif.prop('checked', false);
      $("#type").val('post');
      // Show the hidden fields.
      form.show();
      // Populate the input.
      //populate.val("Dude, this input got populated!");
    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      form.hide();

      // You may also want to clear the value of the
      // hidden fields here. Just in case somebody
      // shows the fields, enters data to them and then
      // unticks the checkbox.
      //
      // This would do the job:
      //
      // $("#hidden_field").val("");
    }
  });



  page.change(function() {
    // Check to see if the checkbox is checked.
    // If it is, show the fields and populate the input.
    // If not, hide the fields.
    if (page.is(':checked')) {
      post.prop('checked', false);
      gif.prop('checked', false);
      $("#type").val('page');
      // Show the hidden fields.
      form.show();
      // Populate the input.
      //populate.val("Dude, this input got populated!");
    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      form.hide();

      // You may also want to clear the value of the
      // hidden fields here. Just in case somebody
      // shows the fields, enters data to them and then
      // unticks the checkbox.
      //
      // This would do the job:
      //
      // $("#hidden_field").val("");
    }
  });
});
</script>

</body>
</html>
