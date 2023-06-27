<?php

require_once 'UnFile.php';

$url = 'https://reactmvc.ir/public/images/about.png';
$path = 'image.jpg';
$downloader = new UnFile($url, $path);
$downloader->download();