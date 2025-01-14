<?php
$cache_life = 60; //caching time, in seconds
$download = false;
if (!isset($_REQUEST['url'])) {
    exit();
}
$url = $_REQUEST['url'];

$url = trim(urldecode($url));
if ($url == '') {
    exit();
}

if (!stristr($url, 'http://') and !stristr($url, 'https://')) {
   $url = 'http://' . $url;

}

$url_segs = parse_url($url);
if (!isset($url_segs['host'])) {
    exit();
}


$here = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$bin_files = $here . 'bin' . DIRECTORY_SEPARATOR;
$jobs = $here . 'jobs' . DIRECTORY_SEPARATOR;
$cache = $here . 'cache' . DIRECTORY_SEPARATOR;

if (!is_dir($jobs)) {
    mkdir($jobs);
    file_put_contents($jobs . 'index.php', '<?php exit(); ?>');

}
if (!is_dir($cache)) {
    mkdir($cache);
    file_put_contents($cache . 'index.php', '<?php exit(); ?>');

}


$w = 1024;
$h = 768;
$quality = 80;
if (isset($_REQUEST['w'])) {
    $w = intval($_REQUEST['w']);
}

if (isset($_REQUEST['h'])) {
    $h = intval($_REQUEST['h']);
}

if (isset($_REQUEST['clipw'])) {
    $clipw = intval($_REQUEST['clipw']);
}

if (isset($_REQUEST['cliph'])) {
    $cliph = intval($_REQUEST['cliph']);
}
if(isset($_REQUEST['resolution'])){
  list($width,$height) = explode('x',$_REQUEST['resolution']);
  $w = $width;
  $h = $height;
  $cliph = $height;
  $clipw = $width;
}
if(isset($_REQUEST['quality'])){
  $quality = intval($_REQUEST['quality']);
}
if (isset($_REQUEST['download'])) {
    $download = $_REQUEST['download'];
}

$url = strip_tags($url);
$url = str_replace(';', '', $url);
$url = str_replace('"', '', $url);
$url = str_replace('\'', '/', $url);
$url = str_replace('<?', '', $url);
$url = str_replace('<?', '', $url);
$url = str_replace('\077', ' ', $url);
$url = str_replace("^?", "?", $url);

$screen_file = $url_segs['host'] . crc32($url) . '_' . $w . '_' . $h . '_'. $quality .'.jpg';
$cache_job = $cache . $screen_file;


$refresh = false;
if (is_file($cache_job)) {
    $filemtime = @filemtime($cache_job); // returns FALSE if file does not exist
    if (!$filemtime or (time() - $filemtime >= $cache_life)) {
        $refresh = true;
    }
}


$url = escapeshellcmd($url);

if (!is_file($cache_job) or $refresh == true) {
    $src = "

    var page = require('webpage').create();

    page.viewportSize = { width: {$w}, height: {$h} };

    ";

    if (isset($clipw) && isset($cliph)) {
        $src .= "page.clipRect = { top: 0, left: 0, width: {$clipw}, height: {$cliph} };";
    }

    $src .= "

    page.open('{$url}', function () {
        page.render('{$screen_file}',{format: 'JPG', quality: '{$quality}'});
        phantom.exit();
    });


    ";

    $job_file = $jobs . $url_segs['host'] . crc32($src) . '.js';
    file_put_contents($job_file, $src);

    $exec = $bin_files . 'phantomjs --ignore-ssl-errors=yes ' . $job_file;

    $escaped_command = escapeshellcmd($exec);

    exec($escaped_command);

    if (is_file($here . $screen_file)) {
        rename($here . $screen_file, $cache_job);
    }
}


if (is_file($cache_job)) {
    if ($download != false) {
        $file = $cache_job;
        $file_name=basename($file);
        $type = 'image/jpeg';
        header("Content-disposition: attachment; filename={$file_name}");
        header("Content-type: {$type}");
        readfile($file);
    } else {
        $file = $cache_job;
        $type = 'image/jpeg';
        header('Content-Type:' . $type);
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }


}





 
