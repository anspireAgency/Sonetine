<?php // job_helper.php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function get_page($page_id)
{
  $CI =& get_instance();

  $query = $CI->db->query("SELECT *
    FROM user_pages
    where page_id=$page_id");
    return $query;
  }
  function notifications_num($user_id){
    $CI =& get_instance();
    $query = $CI->db->query("SELECT *
      FROM users u join user_pages up on u.id=up.user_id
      join requests r on r.user_pages_id = up.id
      join notifications n on r.id=n.request_id
      where u.id=$user_id AND is_read=1");
      return $query->num_rows();
    }
    //C:/xampp/htdocs/sonetine/uploads/Test for sonetine/incoming/bg.png
    function get_image_path($path){
      $p='http://localhost/sonetine/uploads/noimage.png';
      if(!empty($path)){
        $p=base_url().preg_split('[\/]', $path,5)[4];
      }
      return $p;

    }


    function get_image_name($link){
      return end(preg_split('[\/]',$link));
    }
    function get_download_link($path){
      $p='http://localhost/sonetine/uploads/noimage.png';
      if(!empty($path)){
        $p=base_url().preg_split('[\/]', $path,5)[4];
      }
      return $p;
    }

    ?>
