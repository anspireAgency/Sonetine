

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>

<body>
  <!-- <form action="first.php" method="POST"> -->

<?php echo form_open("Calculators/create_plan");?>
  <input hidden="true" name="agreement" id="agreement_name" type="text" value="Sonetine"/></br>
  <label for="Number of Post Design">Number of Posts Design</label>
  <input name="post" id="post_price" type="text" value="1"/></br>
  <label for="Number of Page Design">Number of Page Design</label>
  <input name="page" id="page_price" type="text" value="1"/><br>
  <label for="Number of GIF">Number of GIFs </label>
  <input name="gif" id="gif_price" type="text" value="1"/><br>
  <input type="button" onclick="update()" value="calculate"/>
  <label for="total"/>total</label><input name="total_price" id="total" type="text"  /><br><br>
  <input  name="mySubmit" type="submit" value="Submit!" />

  <?php echo form_close();?>
    <div hidden="true" id="paypal-button-container"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
    function update(){
        document.getElementById('total').value=(parseInt(document.getElementById('post_price').value)*10+parseInt(document.getElementById('page_price').value)*10+parseInt(document.getElementById('gif_price').value)*10)*1.04;
    }
    </script>
</body>
