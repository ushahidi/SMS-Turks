<?php
$commands = array(
	'preview' => 'ls_200',
	'preview2' => 'ls_160'
);

$curdir = getcwd();

//print_r($path_parts);


$path_parts = explode("/", $_GET['img']);
$filename = array_pop($path_parts);
$dir = implode("/", $path_parts);
if(!is_dir($dir)) {
  if(!mkdir($dir)) {
    notFound();
  }
}

$command = array_pop($path_parts);
$command = $commands[$command];

array_push($path_parts, $filename);
$real_path = implode("/", $path_parts);

if(!file_exists($real_path)) {
  notFound(1, $real_path);
}

if(!preg_match("/(.*)(jpeg|jpg|gif|png|JPEG|JPG|GIF|PNG)$/", $real_path, $ext)) { // works with: jpg, gif, png
  notFound(2);
}

$type = (strtolower($ext[2]) == 'jpg') ? 'jpeg' : strtolower($ext[2]);
$outputfunc = 'image' . $type;
$createfunc = 'imagecreatefrom' . $type;
$mime = 'image/' . $type;

if(!function_exists($outputfunc) || !function_exists($createfunc)) { // check for the existence of our preferred functions
  notFound(3);
}

$quality = 100;
global $force;
$force = 1;
$commands = explode(".", $command);
$im = $createfunc($real_path);
foreach($commands as $cm) {
  $params = explode("_", $cm);
  $command = array_shift($params);
  switch($command) {
    case 'c':
      $im = crop($im, $params[0], $params[1]);
      break;
    case 'ls':
      $im = scale_longside($im, $params[0]);
      break;
    case 'q':
      $quality = $params[0];
      break;
    case 'gs':
      imagefilter($im, IMG_FILTER_GRAYSCALE);
      break;
    case 'h':
      $im = scale_height($im, $params[0]);
      break;
    case 'w':
      $im = scale_width($im, $params[0]);
      break;
    case 'f':
      $force = $params[0]; // should be 1 or 0
      break;
    default:
      notFound(4);
  }
}

if($type == 'png') {
  $quality = $quality / 11.11; // translate 0-100 quality scale to 0-9, which is what imagepng() expects.
}

// quality parameter will be ignored for imagegif().
$outputfunc($im, $dir . '/' . $filename, $quality);
header("Content-type: $mime");
echo file_get_contents($dir . '/' . $filename);

function scale_longside($im, $longside) {
  global $force;
	$width = imagesx($im);
	$height = imagesy($im);
	$wfactor = $longside / $width;
	$hfactor = $longside / $height;
	if($width > $height) { // scale based on width
		$new_height = floor($height * ($longside / $width));
		$new_width = $longside;
		if(!$force && $new_width >= $width) {
		  // return image unchanged if "force" is off and the existing width is smaller than the new width
		  return $im;
		}
	} 
	else { // scale based on height
		$new_width = floor($width * ($longside / $height));
		$new_height = $longside; 
		if(!$force && $new_height >= $height) {
		  // return image unchanged if "force" is off and the existing width is smaller than the new width
		  return $im;
		}
	}
	return resize($im, $new_width, $new_height, $width, $height);
}

function crop($im, $new_width, $new_height) {
  $im = scale_width($im, $new_width);
  $width = $new_width;
  $height = imagesy($im);
	if ($height < $new_height) {
	  $im = scale_height($im, $new_height);
	}
	$new_im = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new_im, $im, 0, 0, 0, 0, $new_width, $new_height, $new_width, $new_height);
	return $new_im;
}

function scale_width($im, $req_width) {
  global $force;
	$width = imagesx($im);
	$height = imagesy($im);
	$new_height = floor($height * ($req_width / $width));
	$new_width = $req_width;
	if(!$force && $new_width >= $width) {
	  // return image unchanged if "force" is off and the existing width is smaller than the new width
	  return $im;
	}
	return resize($im, $new_width, $new_height, $width, $height);
}

function scale_height($im, $req_height) {
  global $force;
	$width = imagesx($im);
	$height = imagesy($im);
	$new_width = floor($width * ($req_height / $height));
	$new_height = $req_height;
	if(!$force && $new_height >= $height) {
	  // return image unchanged if "force" is off and the existing width is smaller than the new width
	  return $im;
	}
	return resize($im, $new_width, $new_height, $width, $height);
}

function resize($im, $new_width, $new_height, $width = FALSE, $height = FALSE) {
  if($width === FALSE) {
    $width = imagesx($im);
  }
  if($height === FALSE) {
    $height = imagesy($im);
  }
	$new_im = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new_im, $im, 0,0,0,0, $new_width, $new_height, $width, $height);
	return $new_im;
}

function notFound($err = 0, $text = '') {
  header("HTTP/1.0 404 Not Found");
  echo "File not found ($err: $text)";
  exit;
}
