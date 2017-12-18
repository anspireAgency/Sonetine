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
          <th>ID</th>
          <th>is_verified</th>
          <th>username</th>
          <th>email</th>
          <th>first name</th>
          <th>last name</th>
          <th>company</th>

      </tr>
      </thead>
      <tbody>



          <tr>
              <td><?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->is_verified, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($user->company, ENT_QUOTES, 'UTF-8'); ?></td>
          </tr>



      </tbody>
  </table>

</body>
</html>
