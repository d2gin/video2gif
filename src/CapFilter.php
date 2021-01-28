<?php

namespace video2gif;

use FFMpeg\Filters\Gif\GifFilterInterface;
use FFMpeg\Media\Gif;

class CapFilter implements GifFilterInterface
{

    private $priority;
    private $cap_path;

    function __construct($cap_path)
    {
        if (!is_file($cap_path)) {
            throw new \Exception('糟糕!字幕文件不存在');
        }
        $this->cap_path = $cap_path;
    }


    public function apply(Gif $gif)
    {
        return ['-vf', "ass={$this->cap_path}"];
    }

    public function getPriority()
    {
    }
}