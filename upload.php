<?php

error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include('src/class.upload.php');

// set variables
$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : 'tmp');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

$handle = new upload($_FILES['image_field'], 'ru_RU');
if ($handle->uploaded) {
  $handle->file_new_name_body   = 'pit_'.$id;
  $handle->image_convert        = 'jpg';
  $handle->image_resize         = true;
  $handle->image_x              = 800;
  $handle->image_ratio_y        = true;
  $handle->process('image/');
  if ($handle->processed) {
    //echo 'image resized';
    $handle->clean();
  } else {
    echo 'error : ' . $handle->error;
  }
}
