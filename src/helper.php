<?php
if (!function_exists('ffmpeg')) {
    function ffmpeg($opt = [])
    {
        $opt = array_merge([
            // 如果是win环境请务必添加ffmpeg的环境路径
            'ffmpeg.binaries'  => @$opt['ffmpeg.binaries'] ?: 'ffmpeg',
            'ffprobe.binaries' => @$opt['ffprobe.binaries'] ?: 'ffprobe',
        ], $opt);
        return \FFMpeg\FFMpeg::create($opt);
    }
}