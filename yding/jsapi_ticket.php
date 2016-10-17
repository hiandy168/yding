<?php
/**
 * 该文件用于定时刷新dingding的js api ticket；可配合ydtimer.yidianhulian.com或者其他定时器执行
 * 刷新成功后会回调YDingHook::REFRESH_JS_API_TICKET
 * 
 * 企业在使用微应用中的JS API时，需要先从钉钉开放平台接口获取jsapi_ticket生成签名数据，并将最终签名用的部分字段及签名结果返回到H5中，JS API底层将通过这些数据判断H5是否有权限使用JS API。
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';

try{
	$access_token = YDingHook::do_hook(YDingHook::GET_ACCESS_TOKEN);
	if ( ! $access_token){
		$access_token = yding_get_access_token();
		YDingHook::do_hook(YDingHook::REFRESH_ACCESS_TOKEN, $access_token);
	}
	
	$jsapi_ticket = yding_get_js_ticket($access_token);
	YDingHook::do_hook(YDingHook::REFRESH_JS_API_TICKET, $jsapi_ticket);
}catch (YDing_Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
}