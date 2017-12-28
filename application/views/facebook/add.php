

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
</head>

<body>

  <!-- <?php echo $_SESSION['email'];?>-->
  <div id="infoMessage"><?php if(isset($error)){echo $error;}?></div>

  <form enctype="multipart/form-data"  method="post" action="<?php echo base_url();?>Facebook/upload">
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

                <input hidden="true" id='page_id' name='page_id' value="<?php echo $pageid;?>"/>
                <input hidden="true" id='page_name' name='page_name' value="<?php echo $pagename;?>"/>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">

                      <input type="file" size='20' name="images[]" id="img" class="card-title">
                      <p class="card-text">Insert Logo File</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <input type="file" name="images[]" id="img" class="card-title">
                      <p class="card-text">Insert Fonts</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <input type="color" name="color_code" id="color_code"  class="card-title">
                      <p class="card-text">Add Color code</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="payment-container">
                <div class="row align-items-center text-center text-md-left">
                  <div class="col-md-4">

                  <div id="visible_desc" class="col-md-4 mb-2 mb-md-0">
                  </div>
                  <div class="col-md-4">
                  <input type="submit" id="upload"class="btn" value="Proceed!">
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>
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
  $(document).ready(function(){
      $('#upload').on('click', function(){
          var fileInputs = $('.card-title');
          var formData = new FormData();
          $.each(fileInputs, function(i,fileInput){
              if( fileInput.files.length > 0 ){
                  $.each(fileInput.files, function(k,file){
                      formData.append('images[]', file);
                  });
              }
          });
          $.ajax({
              method: 'post',
              url:"/Facebook/upload",
              data: {formData,
                pageid:$('#page_id'),
                pagename: $('#page_name'),
                colorcode: $('#color_code')}
              dataType: 'json',
              contentType: false,
              processData: false,
              success: function(response){
                  console.log(response);
              }
          });
      });
  });

  </script>
</body>
</html>
