
<!DOCTYPE html>
<html>
<head>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeIgniter User Registration Form Demo</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
  <script src="<?php echo base_url(); ?>dist/js/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/e3ee78ded9.js"></script>
</head>
<body>
  <?php if(!empty( $this->session->flashdata('error')))
  {
    echo  $this->session->flashdata('error');
  };?>
  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="test">
    <thead>
      <tr>
        <th></th>
        <th>Notes</th>
        <th>Caption</th>
        <th>type</th>
        <th>time of post</th>
        <th> Page Name</th>
        <th> Client name</th>

      </tr>
    </thead>
    <tbody>

      <?php foreach ($requests as $request):?>

        <tr>
          <td><input type='submit' value='pick me' onclick="<?php $temp="'".$request->page_name."'";echo 'respondToQuery('.$request -> page_id.','.$temp.','.$request -> id.')';?>"/></td>
          <td><input name="notes" value="<?php echo $request -> notes;?>"readonly>   </input></td>
          <td><input name="caption" value="<?php echo $request -> caption;?>"readonly>  </input></td>
          <td><input name="type" value="<?php echo $request -> type;?>"readonly>    </input> </td>
          <td><input name="time_of_post"  value="<?php echo $request -> time_of_post;?>"readonly>  </input> </td>
          <td><input name="page_name"  value="<?php echo $request -> page_name;?>"readonly>  </input> </td>
          <td>

            <input name="client_name"  value="<?php echo $request -> first_name;?>"readonly>  </input>
          </td>

        </tr>
      <?php endforeach;?>

    </tbody>
  </table>
  <?php echo form_open_multipart('Dashboard/manage_request',array('id'=> 'request','hidden'=>'true')) ?>
  <input type='file' name='userfile' size='20'/><br>
  <input hidden="true" id="page_id" name="page_id" value=""/>
  <input hidden="true" id="page_name" name="page_name" value=""/>
  <input hidden="true" id="request_id" name="request_id" value=""/>

  <input type='submit' value="send to client"/>
  <?php echo form_close()?>
  <script>
  function respondToQuery(pageid,pagename,requestid){

      // Get the form fields and hidden div
      var form = $("#request");
      $("#page_id").val(pageid);
      $("#page_name").val(pagename);
      $("#request_id").val(requestid);
      // Hide the fields.
      // Use JS to do this in case the user doesn't have JS
      // enabled.
      form.show();


  }

  </script>
</body>
</html>
