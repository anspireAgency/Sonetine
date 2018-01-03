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


  <style>

  #notification_count

  {

  padding: 0px 3px 3px 7px;

  background: #cc0000;

  color: #ffffff;

  font-weight: bold;

  margin-left: 87px;

  border-radius: 9px;

  -moz-border-radius: 9px;

  -webkit-border-radius: 9px;

  position: absolute;

  margin-top: -1px;

  font-size: 10px;

  }

  </style>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript" charset="utf-8"></script>

  <script type="text/javascript" charset="utf-8">

  function addmsg(type, msg){

  $('#notification_count').html(msg);

  }

  function waitForMsg(){

  $.ajax({

  type: "GET",

  url: "Facebook/noti",

  async: true,

  cache: false,

  timeout:50000,

  success: function(data){

  addmsg("new", data);

  setTimeout(

  waitForMsg,

  1000

  );

  },

  error: function(XMLHttpRequest, textStatus, errorThrown){

  addmsg("error", textStatus + " (" + errorThrown + ")");

  setTimeout(

  waitForMsg,

  15000);

  }

  });

  };

  $(document).ready(function(){

  waitForMsg();

  });

  </script>
<br>
<br>
  <span id="notification_count"></span>

  <a href="#" id="notificationLink" onclick = "">New Designs</a>

  <div id="HTMLnoti" style="textalign:center"></div>






  <style>.fb-livechat,.fb-widget{display:none}.ctrlq.fb-button,.ctrlq.fb-close{position:fixed;right:24px;cursor:pointer}.ctrlq.fb-button{z-index:1;background:url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxyZWN0IGZpbGw9IiMwMDg0RkYiIGhlaWdodD0iMTI4IiB3aWR0aD0iMTI4Ii8+PC9nPjxwYXRoIGQ9Ik02NCwxNy41MzFjLTI1LjQwNSwwLTQ2LDE5LjI1OS00Niw0My4wMTVjMCwxMy41MTUsNi42NjUsMjUuNTc0LDE3LjA4OSwzMy40NnYxNi40NjIgIGwxNS42OTgtOC43MDdjNC4xODYsMS4xNzEsOC42MjEsMS44LDEzLjIxMywxLjhjMjUuNDA1LDAsNDYtMTkuMjU4LDQ2LTQzLjAxNUMxMTAsMzYuNzksODkuNDA1LDE3LjUzMSw2NCwxNy41MzF6IE02OC44NDUsNzUuMjE0ICBMNTYuOTQ3LDYyLjg1NUwzNC4wMzUsNzUuNTI0bDI1LjEyLTI2LjY1N2wxMS44OTgsMTIuMzU5bDIyLjkxLTEyLjY3TDY4Ljg0NSw3NS4yMTR6IiBmaWxsPSIjRkZGRkZGIiBpZD0iQnViYmxlX1NoYXBlIi8+PC9zdmc+) center no-repeat #0084ff;width:60px;height:60px;text-align:center;bottom:24px;border:0;outline:0;border-radius:60px;-webkit-border-radius:60px;-moz-border-radius:60px;-ms-border-radius:60px;-o-border-radius:60px;box-shadow:0 1px 6px rgba(0,0,0,.06),0 2px 32px rgba(0,0,0,.16);-webkit-transition:box-shadow .2s ease;background-size:80%;transition:all .2s ease-in-out}.ctrlq.fb-button:focus,.ctrlq.fb-button:hover{transform:scale(1.1);box-shadow:0 2px 8px rgba(0,0,0,.09),0 4px 40px rgba(0,0,0,.24)}.fb-widget{background:#fff;z-index:2;position:fixed;width:360px;height:435px;overflow:hidden;opacity:0;bottom:0;right:24px;border-radius:6px;-o-border-radius:6px;-webkit-border-radius:6px;box-shadow:0 5px 40px rgba(0,0,0,.16);-webkit-box-shadow:0 5px 40px rgba(0,0,0,.16);-moz-box-shadow:0 5px 40px rgba(0,0,0,.16);-o-box-shadow:0 5px 40px rgba(0,0,0,.16)}.fb-credit{text-align:center;margin-top:8px}.fb-credit a{transition:none;color:#bec2c9;font-family:Helvetica,Arial,sans-serif;font-size:12px;text-decoration:none;border:0;font-weight:400}.ctrlq.fb-overlay{z-index:0;position:fixed;height:100vh;width:100vw;-webkit-transition:opacity .4s,visibility .4s;transition:opacity .4s,visibility .4s;top:0;left:0;background:rgba(0,0,0,.05);display:none}.ctrlq.fb-close{z-index:4;padding:0 6px;background:#365899;font-weight:700;font-size:11px;color:#fff;margin:8px;border-radius:3px}.ctrlq.fb-close::after{content:'x';font-family:sans-serif}</style>

 <div class="fb-livechat">
   <div class="ctrlq fb-overlay"></div>
   <div class="fb-widget">
     <div class="ctrlq fb-close"></div>
     <div class="fb-page" data-href="https://www.facebook.com/154863205145891/" data-tabs="messages" data-width="360" data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false">
       <blockquote cite="https://www.facebook.com/154863205145891/" class="fb-xfbml-parse-ignore"> </blockquote>
     </div>
   </div>
   <a href="https://m.me/154863205145891" title="Send us a message on Facebook" class="ctrlq fb-button"></a>
 </div>

 <script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script>$(document).ready(function(){var t={delay:125,overlay:$(".fb-overlay"),widget:$(".fb-widget"),button:$(".fb-button")};setTimeout(function(){$("div.fb-livechat").fadeIn()},8*t.delay),$(".ctrlq").on("click",function(e){e.preventDefault(),t.overlay.is(":visible")?(t.overlay.fadeOut(t.delay),t.widget.stop().animate({bottom:0,opacity:0},2*t.delay,function(){$(this).hide("slow"),t.button.show()})):t.button.fadeOut("medium",function(){t.widget.stop().show().animate({bottom:"30px",opacity:1},2*t.delay),t.overlay.fadeIn(t.delay)})})});
 </script>





<!--
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
  <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(["init", {
          appId: "ce433acd-96ac-4ef3-a6c4-c96c6d247058",
          welcomeNotification: {
                  disable: true
              },
          autoRegister: true,
          promptOptions: {
              /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
              /* actionMessage limited to 90 characters */
              actionMessage: "We'd like to show you notifications for the latest news.",
              /* acceptButtonText limited to 15 characters */
              acceptButtonText: "ALLOW",
              /* cancelButtonText limited to 15 characters */
              cancelButtonText: "NO THANKS"
          }
      }]);
  </script>
  <script>
      function subscribe() {
          // OneSignal.push(["registerForPushNotifications"]);
          OneSignal.push(["registerForPushNotifications"]);
          event.preventDefault();
      }
      function unsubscribe(){
          OneSignal.setSubscription(true);
      }

      var OneSignal = OneSignal || [];
      OneSignal.push(function() {
          /* These examples are all valid */
          // Occurs when the user's subscription changes to a new value.
          OneSignal.on('subscriptionChange', function (isSubscribed) {
              console.log("The user's subscription state is now:", isSubscribed);
              OneSignal.sendTag("user_id","4444", function(tagsSent)
              {
                  // Callback called when tags have finished sending
                  console.log("Tags have finished sending!");
              });
          });

          var isPushSupported = OneSignal.isPushNotificationsSupported();
          if (isPushSupported)
          {
              // Push notifications are supported
              OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
              {
                  if (isEnabled)
                  {
                      console.log("Push notifications are enabled!");

                  } else {
                      OneSignal.showHttpPrompt();
                      console.log("Push notifications are not enabled yet.");
                  }
              });

          } else {
              console.log("Push notifications are not supported.");
          }
      });


  </script>-->
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
            <img src="<?php echo get_image_path($notification->design_path);?>" alt="Smiley face" height="250" width="250">
            <a title="Click to download" id="download" href="<?php echo base_url(); ?>Facebook/download_design/<?php echo $notification -> design_path;?>" >Download</a>
          </td>
          <td><input typname="file_path" value="<?php echo $notification -> notes;?>"readonly>   </input></td>
          <td><input name="caption" value="<?php echo $notification -> caption;?>"readonly>  </input></td>
          <td><input name="type" value="<?php echo $notification -> type;?>"readonly>    </input> </td>
          <td><input name="time_of_post"  value="<?php echo $notification -> time_of_post;?>"readonly>  </input> </td>
          <td><input name="page_name"  value="<?php echo $notification -> page_name;?>"readonly>  </input> </td>
          <td>
            <input hidden="true" name="rej_req_id"  value="<?php echo $notification -> id;?>"/>
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

  <div class="fb-messengermessageus"
          messenger_app_id="255764971238848"
          page_id="154863205145891"
          color="blue"
          size="large">
     </div>

</body>
</html>
