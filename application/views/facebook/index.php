<?php
include('init.php');

$helper = $fb->getRedirectLoginHelper();

$permissions = ['manage_pages','publish_actions','publish_pages'];

$loginUrl = $helper->getLoginUrl(base_url().'Facebook/callback', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>
