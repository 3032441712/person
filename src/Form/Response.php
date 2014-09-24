<?php
/**
 * 页面进行表单数据传输,返回操作结果的字符串
 * 1.响应的数据格式为JSON
 * 2.当返回错误提示的时候,重新生成表单的令牌.
 *
 * PHP version 5.3
 *
 * @category Form
 * @package  Form
 * @author   zhaoyan <1210965963@qq.com>
 * @license  https://github.com/3032441712/person/blob/master/LICENSE GNU License
 * @version  GIT: $Id$
 * @link     http://www.168helps.com/blog
 */
namespace Form;

use Util\Token;

/**
 * Response 类
 *
 * @category Form
 * @package  Form
 * @author   zhaoyan <1210965963@qq.com>
 * @license  http://www.168helps.com/blog/license.txt 168heps License
 * @link     http://www.168helps.com/blog
 */
class Response
{
    /**
     * 表单提交返回相应的信息
     * 
     * @param array $array  数据数组
     * @param int   $status 相应的状态(0=>成功, 1=>失败)
     * 
     * @return void
     */
    public static function json($array, $status = 0)
    {
        $array['code'] = $status;
        $array['token'] = Token::create();
        echo json_encode($array);
        exit(0);
    }
}
