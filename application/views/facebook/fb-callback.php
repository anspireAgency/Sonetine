
<!DOCTYPE html>
<html>
<head>


  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CodeIgniter User Registration Form Demo</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet" type="text/css" />

</head>
<body>
  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="test">
    <thead>
      <tr>
        <th>page ID</th>
        <th>page name</th>
        <th>category</th>
        <th>token</th>

      </tr>
    </thead>
    <tbody>

      <?php foreach ($pages as $page):?>
        <?php echo form_open("Facebook/add_page") ?>
        <tr>
          <td><input name="page_id" value="<?php echo $page['id']?>"readonly>   </input></td>
          <td><input name="page_name" value="<?php echo $page['name']?>"readonly>  </input></td>
          <td><input name="page_category" value="<?php echo $page['category']?>"readonly>    </input> </td>
          <td><input hidden="true" name="access_token"  value="<?php echo $page['access_token']?>"readonly>  </input>
              <input  name="user_id" value="<?php echo $user->id;?>"readonly>  </input>
          </td>
            <td><input type='submit' value='pick me' onclick="return confirm('Do you want to add this page?');"></td>
        </tr>
        <?php echo form_close()?>
      <?php endforeach;?>



    </tbody>
  </table>

</body>
</html>
