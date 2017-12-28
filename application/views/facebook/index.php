<?php
include('init.php');

$helper = $fb->getRedirectLoginHelper();

$permissions = ['manage_pages','publish_actions','publish_pages'];

$loginUrl = $helper->getLoginUrl(base_url().'Facebook/callback', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Add new Entity!</a>';
?>

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

  <?php if(!empty($error) && isset($error) )
          echo $error;?>
</head>
<body>
  <?php if(!empty( $this->session->flashdata('error')))
  {
    echo  $this->session->flashdata('error');
  };?>
  <?php echo '<br>'.$notifications_num.' new notifications <br>';?>
  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="test">
    <thead>
      <tr>
        <th></th>
        <th>image</th>
        <th>Notes</th>
        <th>Caption</th>
        <th>type</th>
        <th>time of post</th>
        <th> Page Name</th>
        <th> Client name</th>

      </tr>
    </thead>
    <tbody>

      <?php foreach ($notifications as $notification):
        echo form_open("Facebook/reject");?>
        <tr>
          <td>
            <input type='button' value='Edit' onclick="<?php
             $note="'".$notification -> notes."'";
              $cap="'".$notification -> caption."'";
              $time="'".$notification -> time_of_post."'";
              echo 'respondToQuery('.$notification -> id.','.$note.','.$cap.','.$time.')';?>"/>
            <input type='button' value='Approve' onclick="show_autoPost_form(<?php echo $notification -> id;?>,'<?php echo $notification -> design_path;?>')"/>
            <input type='submit' value='Reject'/>
          </td>
          <td>
            <img src="<?php echo $notification->design_path;?>" alt="Smiley face" height="250" width="250">
            <a title="Click to download" id="download" href="<?php echo base_url(); ?>Facebook/download_design/<?php echo $notification -> design_path;?>" >Download</a>
          </td>
          <td><input typname="file_path" value="<?php echo $notification -> notes;?>"readonly>   </input></td>
          <td><input name="caption" value="<?php echo $notification -> caption;?>"readonly>  </input></td>
          <td><input name="type" value="<?php echo $notification -> type;?>"readonly>    </input> </td>
          <td><input name="time_of_post"  value="<?php echo $notification -> time_of_post;?>"readonly>  </input> </td>
          <td><input name="page_name"  value="<?php echo $notification -> page_name;?>"readonly>  </input> </td>
          <td>
            <input name="rej_req_id"  value="<?php echo $notification -> id;?>"/>
            <input name="client_name"  value="<?php echo $notification -> first_name;?>"readonly>  </input>
          </td>
        </tr>

      <?php echo form_close();endforeach;?>

    </tbody>
  </table>
<?php echo form_open('Facebook/edit_request',array('id'=> 'request','hidden'=>'true'));?>
  <label>caption</label><input type="text" id="caption" name="caption" value="" ></input><br>
  <label>time of post</label><input name="time" id="time" type="text" value="" ></input><br>
  <label>Notes</label><input name="notes" id="notes" type="text" value="" ></input><br>
  <input type="submit" value="submit"/>
  <input hidden="true" name="request_id" id="request_id" type="text" value="" />
<?php echo form_close();?>



<?php echo form_open('Facebook/approve_request',array('id'=> 'checkbox_form','hidden'=>'true','method'=>'post'));?>

  <label>Auto post to FB page </label><input type="checkbox" name="auto_post" value=""></input><br>

  <input type="submit" id="submit" value="submit"/>
  <input hidden="true" name="req" id="req" type="text" value="" />
  <input hidden="true" name="design" id="design" type="text" value="" />
<?php echo form_close();?>
  <script>
  function show_autoPost_form(request_id,design){

      // Get the form fields and hidden div

      var form = $("#checkbox_form");
      $("#req").val(request_id);
      $("#design").val(design);

      // Hide the fields.
      // Use JS to do this in case the user doesn't have JS
      // enabled.
      form.show();
  }


  function respondToQuery(id,note,cap,time){

      // Get the form fields and hidden div
      var form = $("#request");
      $("#caption").val(cap);
      $("#time").val(time);
      $("#notes").val(note);
      $("#request_id").val(id);
      // Hide the fields.
      // Use JS to do this in case the user doesn't have JS
      // enabled.
      form.show();
  }

  </script>
</body>
</html>
