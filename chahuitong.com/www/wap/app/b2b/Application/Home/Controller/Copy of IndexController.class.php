<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	/*
	  *此方法用于跳转到客户端首页
	*/
	public function index(){
		$this->display();
	}
	
	/*
	 *此方法用于跳转到详情页
	*/
	public function detail(){
		$this->display();
	}
	
	/*
	 *登陆页
	*/
	public function login(){
		$this->display();
	}
	
	/*
	 *消息
	*/
	public function news(){
		$this->display();
	}
	
	/*
	 *发布
	*/
	public function post(){
		$this->display();
	}
	
	/*
	 *此方法用于跳转到个人发布列表
	*/
	public function myList(){
		$this->display();
	}
}
