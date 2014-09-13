<?php
/**
 * 自定义应用异常
 * @package Exception
 * @author zhaoyan<1210965963@qq.com>
 * @version 1.0
 */
namespace Exception;

class App extends \Exception
{
    // 目录没有找到
    const NotFountDir = 1000;
    
    // 文件没有找到
    const NotFountFile = 1001;
}
