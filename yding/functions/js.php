<?php
/**
 * 输出移动端dingtalk.js
 * @author leeboo
 */
function yding_jsapi_init(){
?>
<script type="text/javascript" src="https://g.alicdn.com/ilw/ding/0.9.2/scripts/dingtalk.js"></script>
<?php 
}
/**
 * 输出PC端dingtalk.js
 * @author leeboo
 */
function yding_pc_jsapi_init(){
	?>
<script type="text/javascript" src="http://g.alicdn.com/dingding/dingtalk-pc-api/2.3.1/index.js"></script>
<?php 
}

/**
 * 获取js api ticket
 * 企业在使用微应用及服务窗中的JS API时，需要先从钉钉开放平台接口获取jsapi_ticket生成签名数据，并将最终签名用的部分字段及签名结果返回到H5中，JS API底层将通过这些数据判断H5是否有权限使用JS API。
 * 
 * @param unknown $access_token
 * @return string
 * @throws YDing_Exception
 */
function yding_get_jsapi_ticket($access_token){
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST.'get_jsapi_ticket', array('type' => 'jsapi', 'access_token' => $access_token));
	$response = json_decode($response);
	if ($response->ticket) return $response->ticket;
	throw new YDing_Exception($response->errmsg, $response->errcode);
}


/**
 * ISV获取企业服务窗JSAPI鉴权ticket，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问channel_jsapi_ticket.php来定时刷新
 *
 * @param unknown $accessToken 企业服务窗接口访问凭证 即yding_get_channel_isv_token返回的内容，见channel_jsapi_ticket.php文件说明
 * @throws YDing_Exception
 * @return unknown
 */
function yding_get_channel_jsapi_ticket($accessToken){
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'channel/get_channel_jsapi_ticket', array (
			'access_token' 		=> $accessToken
	) );

	$response = json_decode ( $response );
	if ($response->ticket)
		return $response->ticket;

		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

?>