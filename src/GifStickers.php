<?php

namespace video2gif;

use video2gif\CapFilter;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;

class GifStickers
{
    public static $instance = null;
    protected     $error    = '';
    protected     $FFMpeg   = null;

    public function __construct($option = [])
    {
        $option       = array_merge([
            // 如果是win环境请务必添加ffmpeg的环境路径
            'ffmpeg.binaries'  => @$option['ffmpeg.binaries'] ?: 'ffmpeg',
            'ffprobe.binaries' => @$option['ffprobe.binaries'] ?: 'ffprobe',
        ], $option);
        $this->FFMpeg = \FFMpeg\FFMpeg::create($option);
    }

    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }

    /**
     * @param $i 视频文件
     * @param $ass 字幕文件
     * @param $o 输出的文件名
     * @param array $d 图片尺寸 win 无效果 linux 有效果
     * @return bool
     */
    public function generate($i, $ass, $o, $d = [200, 1])
    {
        // 打开视频模版
        $video = $this->FFMpeg->open($i);
        // 创建像素 不知道为什么不起作用 win无效果 linux有效果
        if (is_numeric($d)) {
            $d = [$d, 1];
        }
        //if (false !== strpos($ass, chr(10))) {
        //    $tmpfile = tmpfile();
        //    $meta    = stream_get_meta_data($tmpfile); // eg: /tmp/phpFx0513a
        //    fwrite($tmpfile, $ass);
        //    $ass = $meta['uri'];
        //}
        $dimension = new Dimension($d[0], $d[1]);
        // 生成gif对象 让视频转gif
        $gif    = $video->gif(TimeCode::fromSeconds(0), $dimension);
        $result = true;
        try {
            // 由于保存失败会抛出异常 所以需要捕获异常进一步处理
            // 创建字幕滤器 其实就是命令行参数构造器
            $filter = new CapFilter($ass);
            // 传入滤器 保存
            $gif->addFilter($filter)->save($o);
            if (isset($tmpfile)) fclose($tmpfile);
        } catch (\Exception $exception) {
            $result      = false;
            $this->error = $exception->getMessage();
        }
        return $result;
    }

    public function getError()
    {
        return $this->error;
    }
}