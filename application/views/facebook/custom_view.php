<html>
<head>
    <title>File Upload In Codeigniter</title>
</head>
<body>
<?php if(isset($error)){
  echo $error;
};?>
<?php echo form_open_multipart('Uploads/do_upload');?>
<label>choose file</label><?php echo "<input type='file' name='userfile' size='20' />"; ?>
<br>
<label>choose color</label><input type="color" onclick="detect()" name="color_code" id="color_code" class="card-title"/>
<br><label> insert font</label><input type="text" onkeyup="" name="font" id="font" class="card-title"/>
<br>
<input type='submit' name='submit' value='upload' />
<?php echo "</form>"?>
</body>
</html>
