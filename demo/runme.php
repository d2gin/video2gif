<?php
include dirname(__FILE__).'/../../../autoload.php';
use video2gif\GifStickers;

$handle = new GifStickers([
    'ffmpeg.binaries'  => 'D:\ffmpeg\bin\ffmpeg.exe',
    'ffprobe.binaries' => 'D:\ffmpeg\bin\ffprobe.exe',
]);
if ($handle->generate('template.mp4', 'template.ass', '1.gif')) {
    echo "finished";
} else {
    var_dump($handle->getError());
}