<?php
header('Content-type: text/css');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.3                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../config.php')) die('[index.php] config.php not exist');
require_once '../config.php';

if (isset($_SESSION['widgetid'])) {
    $cachewidget = APP_PATH.JAK_CACHE_DIRECTORY.'/widget'.$_SESSION['widgetid'].'.php';
    if (file_exists($cachewidget)) include_once $cachewidget;
    $styleconfig = APP_PATH.'package/'.$jakwidget['template'].'/config.php';
    if (file_exists($styleconfig)) include_once $styleconfig;
} else {
    die("Cannot load the cached file");
}

if (isset($jakgraphix) && is_array($jakgraphix)) {

    if ($jakgraphix["cssbs4"] && $jakgraphix["cssfa"] && $jakgraphix["cssanim"] && $jakgraphix["cssemoj"] && $jakgraphix["cssdz"]) {
        include('stylesheet.css');
    } else {
        if ($jakgraphix["cssbs4"]) {
            include('bootstrap.css');
        }
        if ($jakgraphix["cssfa"]) {
            include('fontawesome.css');
        }
        if ($jakgraphix["cssanim"]) {
            include('animate.css');
        }
        if ($jakgraphix["cssemoj"]) {
            include('emoji.css');
        }
        if ($jakgraphix["cssdz"]) {
            include('dropzone.css');
        }
    }

    // Package Styles
    include('../package/'.$jakwidget['template'].'/'.$jakgraphix["cssgeneral"]);

} else {
    return false;
}
?>