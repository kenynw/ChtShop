<?php if(!defined('ROOT')) die('Access denied.');

class c_mymessages extends Admin{

	public function __construct($path){
		parent::__construct($path);

	}

	public function index(){

		echo '<div style="font-size:13px;width:460px; border:1px solid #acacac;background:#ddd;margin:160px auto;padding:8px;border-radius: 6px;line-height:24px;text-shadow:1px 1px 0 #efefef;">
		<ul>
		<li>1)&nbsp; 感谢您选择并使用WeLive4企业级在线客服系统!</li>
		<li>2)&nbsp; WeLive4免费版主要是针对个人用户使用, 功能受限, 如需要请选择商业版.</li>
		<li>3)&nbsp; WeLive4商业版较免费版增加三大功能: <font class=orange><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A. 保存交流记录, 管理员可查看及管理, 用户登录客服时显示历史记录;<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B. 客服可实时显示并记录客人的相关信息, 如: 姓名、电话、意向分、备注等;<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C. 客服交流区可让管理员及时通知或查看系统连接状态及客服工作状态,<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;同时方便客服之间相互交流工作经验.</font></li>
		<li>4)&nbsp; WeLive4商业版仅售 <span class=blueb>580</span> 元, 一次性付费, 永久使用.</li>
		<li>5)&nbsp; 购买商业版: QQ <span class=note>20577229</span> (加入时请注明: <span class=note>WeLive4商业版</span>) <BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;或致电 <a href="http://www.weentech.com/contact/" target="_blank">闻泰网络</a>. 感谢您的支持!</li>
		</ul></div>';

	}

} 

?>