# video2gif
使用开源的ffmpeg for php sdk，实现视频转gif动图。

思路借鉴 https://github.com/xtyxtyx/sorry

### 字幕制作

1. 工具：aegisub
2. 教程 https://tieba.baidu.com/p/1360405931

### 环境要求

1. ffmpeg：win有专门编译好的二进制程序；linux请自行yum或者手动编译。
2. php

### 食用方法

必须安装好ffmpeg，素材和例子都在demo文件夹

```php
<?php
    // composer 入口文件自行更改
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
```