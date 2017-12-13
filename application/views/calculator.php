

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
  <?php echo form_open("Calculators/create_plan");?>
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

                      <input type="text" onkeyup="calculate()"  name="page" id="page_price" value="0" onfocus="if (this.value=='0') this.value='';" class="card-title">
                      <p class="card-text">Cover & Profile</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <input type="text" onkeyup="calculate()" name="post" id="post_price" value="0"  onfocus="if (this.value=='0') this.value='';"class="card-title">
                      <p class="card-text">Post Designs</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-center">
                    <div class="card-body">
                      <input type="text" onkeyup="calculate()" name="gif" id="gif_price" value="0"  onfocus="if (this.value=='0' ) this.value='';"class="card-title">
                      <p class="card-text">GIF Designs</p>
                      <a href="#" class="btn btn-primary w-100">View Example</a>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="payment-container">
                <div class="row align-items-center text-center text-md-left">
                  <div class="col-md-4">
                    <h3 class="disc-title">Monthly Payment</h3>
                    <div id="visible_total" class="disc">
                      $0/Month
                    </div>
                  </div>
                  <div id="visible_desc" class="col-md-4 mb-2 mb-md-0">
                  </div>
                  <div class="col-md-4">
                  <input type="submit" class="btn" value="Get Started Today!">
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <input hidden="true" name="total_price" id="total" type="text" value="0" />
    <input hidden="true" name="agreement" id="agreement_name" type="text" value="Sonetine"/>
    <input hidden="true" name="remaining_days" id="remaining_days" type="text" value=""/>
    <input hidden="true" name="total_this_month" id="total_this_month" type="text" value=""/>
      <?php echo form_close();?>
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
  function calculate(){
    var total=Math.ceil((parseInt(document.getElementById('post_price').value)*10+parseInt(document.getElementById('page_price').value)*10+parseInt(document.getElementById('gif_price').value)*10)*1.04);
    document.getElementById('total').value=total;
    document.getElementById('visible_total').innerHTML='$'+total+'/Month';

    var now = new Date();
    var next;
    if (now.getMonth() == 11) {
      //alert(now);
       next = new Date(now.getFullYear() + 1, 0, 1);
    } else {
       next = new Date(now.getFullYear(), now.getMonth() + 1, 1);
    }

    var remaining_days=Math.ceil((next-now)/(24 * 60 * 60 * 1000));
    var total_this_month=Math.ceil(remaining_days*(total/30));
    document.getElementById('remaining_days').value=remaining_days;
    document.getElementById('total_this_month').value=total_this_month;
    var month=new Array();
    month[0]="Jan";
    month[1]="Feb";
    month[2]="Mar";
    month[3]="Apr";
    month[4]="May";
    month[5]="Jun";
    month[6]="Jul";
    month[7]="Aug";
    month[8]="Sep";
    month[9]="Oct";
    month[10]="Nov";
    month[11]="Dec";
    var now_month =month[now.getMonth()]+'-'+now.getDate()+'-'+now.getFullYear();
    var next_month =month[next.getMonth()]+'-'+next.getDate()+'-'+next.getFullYear();
    document.getElementById('visible_desc').innerHTML='Since today is '+ now_month +', you’ll only pay $'+total_this_month +' till End of the Month. Your next billing date is '+next_month+' for $'+total;
  }
  </script>
</body>
</html>
