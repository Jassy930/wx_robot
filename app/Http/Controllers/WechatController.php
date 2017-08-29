<?php

namespace App\Http\Controllers;

use Log;
use App\Model\dialogue_log;
use App\Model\filter_word;

class WechatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        //Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
        $wechat = app('wechat');
		//Log::info('openid:' . $_GET['openid']);
        $wechat->server->setMessageHandler(function($message){
			switch ($message -> MsgType){
				case 'text':
					$text = filter_word::getFilterRes($message->Content);
					#$text = '';
					Log::info('testFilterRes_restext:' . $text);
					if ($text){
					}
					else if (strpos($message->Content, '么么哒') !== false){
						$text = '么么哒~~~';
					}
					else if (strpos($message->Content, '查询id') !== false){
						$text = $_GET['openid'];
					}
					else if (strpos($message->Content, '海爷是谁') !== false){
						$text = '海爷是世界上最漂亮可爱的小姐姐~~';
					}
					else {
						$text = self::send_post($message->Content, $_GET['openid']);
					}
					$dialogue_log = array(
						'open_id' => $_GET['openid'],
						'in_type' => 'text',
						'in_word' => $message->Content,
						'out_type' => 'text',
						'out_word' => $text,
					);
					dialogue_log::insertlog($dialogue_log);
					Log::info('openid:' . $_GET['openid'] . '|message:' . $message->Content . '|res:' . $text);
					return $text;
					break;
				default:
					return "然后呢？";
			}
            return "然后呢？";
        });

        //Log::info('return response.');

        return $wechat->server->serve();
    }

	public function send_post($text,$userid = 12345){
		$url = "http://www.tuling123.com/openapi/api";	
		$arr = array('key' => '786f9b0f3c924117848fbbef4b46af9f', 'info' => $text, 'userid' => $userid);
		$postdata = http_build_query($arr);
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-type:application/x-www-form-urlencoded',
				'content' => $postdata,
				'timeout' => 15 * 60
			)
		);
		$content = stream_context_create($options);
		$result = file_get_contents($url, false, $content);
	//	Log::info(json_decode($result)->text);
		$result = json_decode($result)->text;
//		Log::info('openid:' . $userid . '|message:' . $text . '|res:' . $result);
		return $result;
	}
}
