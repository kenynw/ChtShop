<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 首页控制器
 * @autho: Leslie Deng
 */
class IndexController extends Controller
{
    /*客户登陆与权限判断*/
    public function checklogin()
    {
        $token = $_COOKIE['key'];
        $name = $_COOKIE['username'];
        $mb_token = M('mb_user_token');
        $member = $mb_token->where("token='$token'")->find();
        if ($member) {
            $memberModel = M("member");
            $result = $memberModel->where("member_id={$member['member_id']}")->find();
            return $result;
            // echo 11;
        } else {
            return false;
            //echo 00;
        }
    }

    public function chashi()
    {
        $uid = checkChashi();
        $this->assign("uid", $uid);
        $this->display();
    }

    /*选择发布类型*/
    public function fabu()
    {

        $this->display();

    }

    /*信息提交页面*/
    public function post()
    {
        $check = $this->checklogin();
        if (!$check) {
            $this->Error('您还未登陆,请您先登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        /*if($check['chashi']==0){
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/
        $this->display();

    }

    /*已登陆客户申请加入茶室*/
    public function joinin()
    {

        $this->display();

    }

    public function shenqing()
    {

        if (!isset($_POST['chashi'])) {

            //print_r($_POST);

            //die();
            $this->error("抱歉您还未同意加入茶市", "/mobile/app/b2b/index.php/Home/index/chashi");

        }

        $id = intval($_POST['uid']);

        $data['chashi'] = 2;

        $member = M("member");

        $result = $member->where("member_id='$id'")->save($data);

        //$array=array();

        if ($result) {

            $this->success("申请生成，我们会尽快为您开通", "/wap");

        } else {

            $this->error("您可能已经申请了，请耐心等待下", "/wap");

        }


    }

    /*
      *此方法用于跳转到客户端首页
    */
    public function index()
    {
        /*$check=$this->checklogin();
        if(!$check){
             $this->Error('您还未登陆,请您先登陆',"/wap/index.php/Home/Index/login?chashi=1");
            }
        if($check['chashi']==0){
            //echo $check['chashi'];
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/

        header("location:sale");

        exit();

        $post = M("ecs_post");
        /*分页*/
        $count = $post->where("recommend != -1")->count();
        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        if (isset($_GET['order']) && ($_GET['order'] == 1)) {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.recommend != '-1' order by p.id desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $all = $gets->query($sql);
        } else {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.recommend != '-1' order by p.recommend desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $all = $gets->query($sql);
        }

        $this->assign('page', $show);// 赋值分页输出
        $this->assign("all", $all);
        $this->display();
    }

    public function sale()
    {
        /*$check=$this->checklogin();
        if(!$check){
             $this->Error('您还未登陆,请您先登陆',"/wap/index.php/Home/Index/login?chashi=1");
            }
        if($check['chashi']==0){
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/
        $post = M("ecs_post");
        /*分页*/
        $count = $post->where("saleway='1' and recommend !='-1'")->count();

        $Page = new \Think\Page($count, 10);
        $show = $Page->show();
        if (isset($_GET['order']) && ($_GET['order'] == 1)) {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.saleway='1' and p.recommend != '-1'  order by p.id desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $sale = $gets->query($sql);
        } else {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.saleway='1' and p.recommend != '-1' order by p.recommend desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $sale = $gets->query($sql);
        }
        //$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
        //$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
        //$this->assign("all",$all);
        $this->assign('page', $show);
        $this->assign("all", $sale);
        //$this->assign("buy",$buy);

        $this->display();
    }

    public function buy()
    {
        /*$check=$this->checklogin();
        if(!$check){
             $this->Error('您还未登陆,请您先登陆',"/wap/index.php/Home/Index/login?chashi=1");
            }
        if($check['chashi']==0){
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/
        $post = M("ecs_post");
        $count = $post->where("saleway='2' and recommend !='-1'")->count();
        $Page = new \Think\Page($count, 10);
        if (isset($_GET['order']) && ($_GET['order'] == 1)) {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.saleway='2' and p.recommend != '-1' order by p.id desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $buy = $gets->query($sql);
        } else {
            $sql = "select p.* ,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where p.saleway='2' and p.recommend != '-1' order by p.recommend desc limit " . $Page->firstRow . ' , ' . $Page->listRows;
            $gets = M();
            $buy = $gets->query($sql);
        }
        $this->assign('page', $show);
        $this->assign("all", $buy);
        $this->display();
    }

    /*
     * 信息入库
     */
    public function post_save()
    {
        $post = M("ecs_post");
        if (empty($_POST['name']) && empty($_POST['brand'])) {
            $this->error("内容不能为空");
        }
        $content = M("ecs_post_content");
        if (isset($_POST['id'])) {
            //$file=$post->field("pic")->where("id='".$_POST['id']."'")->find();
            //$pic=$file['pic'];
            $post->where("id='" . $_POST['id'] . "'")->delete();
            //$detail=$content->field("depic")->where("pid='{$_POST['id']}'")->find();
            //$depic=$detail['depic'];
            $content->where("pid='{$_POST['id']}'")->delete();
            //die();
        }
        $result = $post->create();
        $time = time();
        //$pic='';
        $depic = '';
        if (is_uploaded_file($_FILES['img1']['tmp_name'])) {
            $name = $_FILES['img1']["name"];
            $type = $_FILES['img1']["type"];//上传文件的类型
            $size = $_FILES['img1']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img1']['name'], -3);
            $newname = $time . "_1." . $imgtype;
            $pic = $time . "_1." . $imgtype;
            $depic .= $time . "_1." . $imgtype . ',';
            $result1 = move_uploaded_file($_FILES['img1']["tmp_name"], './Public/upload/' . $newname);
        }
        if (is_uploaded_file($_FILES['img2']['tmp_name'])) {
            $name = $_FILES['img2']["name"];
            $type = $_FILES['img2']["type"];//上传文件的类型
            $size = $_FILES['img2']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img2']['name'], -3);
            $newname = $time . "_2." . $imgtype;
            $depic .= $time . "_2." . $imgtype . ',';
            $result2 = move_uploaded_file($_FILES['img2']["tmp_name"], './Public/upload/' . $newname);
        }
        if (is_uploaded_file($_FILES['img3']['tmp_name'])) {
            $name = $_FILES['img3']["name"];
            $type = $_FILES['img3']["type"];//上传文件的类型
            $size = $_FILES['img3']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img3']['name'], -3);
            $newname = $time . "_3." . $imgtype;
            $depic .= $time . "_3." . $imgtype;
            $result3 = move_uploaded_file($_FILES['img3']["tmp_name"], './Public/upload/' . $newname);
        }
        if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
            $post->user_id = $_POST['user_id'];
        } else {
            $post->user_id = $this->isLoginApi($_POST['username'], $_POST['key']);
        }
        $post->pic = $pic;
        $post->addtime = date("Y-m-d H:i");
        $post->contact = $_POST['contact'];
        $id = $post->add();
        $data['pid'] = $id;
        $data['content'] = $_POST['content'];
        $data['depic'] = $depic;
        $cid = $content->add($data);
        if ($id && $cid) {
            $this->success('新增成功');
        }

    }

    /*
     * 个人的发布产品
     */
    public function myList()
    {
        $check = $this->checklogin();
        if (!$check) {
            $this->Error('您还未登陆,请您先登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        $mypost = M("ecs_post");
        $user_id = checkChashi();
        $info = $mypost->where("user_id='" . $user_id . "'")->select();
        $this->assign("data", $info);
        $this->display();
    }

    /*java上传*/
    public function java_save()
    {
        $user_id = $this->isLoginApi($_POST['username'], $_POST['key']);
        $array = array();
        if (!$user_id) {
            $array['code'] = 200;
            $array['content'] = '还未登陆';
            echo json_encode($array);
            die();
        }
        if (isset($_POST['id'])) {
            $postModel = M("ecs_post");
            $contentModel = M("ecs_post_content");
            $postModel->where("id='" . $_POST['id'] . "'")->delete();
            $detail = $contentModel->field("depic")->where("pid='{$_POST['id']}'")->find();
            $depic = $detail['depic'];
            $contentModel->where("pid='{$_POST['id']}'")->delete();
            //die();
        }
        $post = M("ecs_post");
        $result = $post->create();
        $time = time();
        $pic = '';
        $depic = '';
        if (is_uploaded_file($_FILES['img1']['tmp_name'])) {
            $name = $_FILES['img1']["name"];
            $type = $_FILES['img1']["type"];//上传文件的类型
            $size = $_FILES['img1']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img1']['name'], -3);
            $newname = $time . "_1." . $imgtype;
            $pic = $time . "_1." . $imgtype;
            $depic .= $time . "_1." . $imgtype . ',';
            $result1 = move_uploaded_file($_FILES['img1']["tmp_name"], './Public/upload/' . $newname);
        }
        if (is_uploaded_file($_FILES['img2']['tmp_name'])) {
            $name = $_FILES['img2']["name"];
            $type = $_FILES['img2']["type"];//上传文件的类型
            $size = $_FILES['img2']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img2']['name'], -3);
            $newname = $time . "_2." . $imgtype;
            $depic .= $time . "_2." . $imgtype . ',';
            $result2 = move_uploaded_file($_FILES['img2']["tmp_name"], './Public/upload/' . $newname);
        }
        if (is_uploaded_file($_FILES['img3']['tmp_name'])) {
            $name = $_FILES['img3']["name"];
            $type = $_FILES['img3']["type"];//上传文件的类型
            $size = $_FILES['img3']["size"];//上传文件的大小
            if ($size > (8 * 1014 * 1024)) {
                $this->Error('请上传小于2M的图片', "index");
            }
            switch ($type) {
                case 'image/pjpeg':
                    $okType = true;
                    break;
                case 'image/jpg':
                    $okType = true;
                    break;
                case 'image/jpeg':
                    $okType = true;
                    break;
                case 'image/gif':
                    $okType = true;
                    break;
                case 'image/png':
                    $okType = true;
                    break;
            }
            $imgtype = substr($_FILES['img3']['name'], -3);
            $newname = $time . "_3." . $imgtype;
            $depic .= $time . "_3." . $imgtype;
            $result3 = move_uploaded_file($_FILES['img3']["tmp_name"], './Public/upload/' . $newname);
        }
        if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
            $post->user_id = $_POST['user_id'];
        } else {
            $post->user_id = $this->isLoginApi($_POST['username'], $_POST['key']);
        }
        $post->pic = isset($_POST['pic']) ? $_POST['pic'] : $pic;
        $post->contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        $content = M("ecs_post_content");
        $id = $post->add();
        $data['pid'] = $id;
        $data['depic'] = $depic;
        $cid = $content->add($data);
        if ($id && $cid) {
            $this->success('新增成功', 'Index/index');
        }
    }

    /*
     * 产品详情页
     */
    public function info()
    {

        /*$check=$this->checklogin();
        if(!$check){
             $this->Error('您还未登陆,请您先登陆',"/wap/index.php/Home/Index/login?chashi=1");
            }
        if($check['chashi']==0){
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 1;
        $post_content = M('');
        $sql = "select c.id,c.addtime,c.brand,c.name,c.year,c.address,c.price,c.weight,c.unit,c.timeout,c.phone,c.saleway,d.depic,d.content from `shopnc_ecs_post` as c left join `shopnc_ecs_post_content` as d on c.id=d.pid where c.id='$id'";
        $detail = $post_content->query($sql);
        $detail = $detail[0];
        if ($detail['depic'] != '') {
            $array = explode(',', $detail['depic']);
            if (isset($array[0]) && ($array[0] != '')) {

                $detail['img'][] = $array[0];
            }
            if (isset($array[1]) && ($array[1] != '')) {

                $detail['img'][] = $array[1];
            }
            if (isset($array[2]) && ($array[2] != '')) {

                $detail['img'][] = $array[2];
            }
        }
        $this->assign('detail', $detail);
        $this->display();
    }

    function contact()
    {
        $check = $this->checklogin();
        if (!$check) {
            $this->Error('您还未登陆,请您先登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 1;

        $post = M("ecs_post");

        $detail = $post->where("id=" . $id)->find();

        $this->assign('detail', $detail);

        $this->assign('cid', checkChashi());

        $this->assign('fid', checkChashi());

        $this->display();

    }

    /*保存客户买卖交易留言*/
    public function newssave()
    {
        $check = $this->checklogin();
        if (!$check) {
            $this->Error('您还未登陆,请您先登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        /*if($check['chashi']==0){
            $this->Error('您还未申请开通茶市',"/mobile/app/b2b/index.php/Home/index/chashi");
            }	*/
        if ($_POST['uid'] == $_POST['cid']) {
            $this->Error('抱歉这是您自己产品不需要留言', __APP__ . "/Home/index/index");

        }
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['uid'] = $_POST['uid'];
        $data['cid'] = $_POST['cid'];
        $data['pid'] = $_POST['pid'];
        $data['fid'] = $_POST['fid'];
        $data['addtime'] = date("Y-m-d H:i:s");
        $news = M("ecs_post_news");
        $result = $news->add($data);
        if ($result) {
            $this->success('提交成功', __APP__ . '/Home/index/news');
        } else {
            $this->error('提交失败', __APP__ . '/Home/index/info/id/' . '/' . $_POST['pid']);
        }
    }

    /*个人接受到的新信息*/

    public function news()
    {
        if (!checkChashi()) {
            $this->Error('您还未登陆或者申请加入茶市', "/wap/index.php/Home/Index/login?chashi=1");
        }
        $uid = checkChashi();
        $news = M('');

        $sql = "select cid,pid,sum(isRead) as readed,count(*) as total from shopnc_ecs_post_news where uid ='" . checkChashi() . "' or cid='" . checkChashi() . "' group by pid";

        $newslist = $news->query($sql);

        $this->assign('own', checkChashi());

        $this->assign('newslist', $newslist);

        $this->assign('httpinfo', $_SERVER['HTTP_USER_AGENT']);

        $this->display();

    }

    /*查看某个产品的不同客户的留言*/
    function newslist()
    {

        $cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 1;
        $pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? intval($_GET['pid']) : 1;
        $news = M("ecs_post_news");
        $uid = checkChashi();
        $newslist = $news->where("pid='$pid' and (cid='$cid' or cid='$uid') ")->order("id asc")->limit(10)->select();
        $post = M("ecs_post");

        $postinfo = $post->where("id='$pid'")->find();

        //print_r($postinfo);

        $this->assign('cid', $cid);

        $this->assign('own', checkChashi());

        $this->assign('pid', $pid);

        $this->assign('uid', $postinfo['user_id']);

        $this->assign('newslist', $newslist);

        $this->display();

    }

    /*消息页面详细内容*/

    public function newsdetail()
    {

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 1;


        $news = M("ecs_post_news");

        $data['isRead'] = 1;

        $news->where("id=$id")->save($data);

        $info = $news->where("id=$id")->find();

        $this->assign('own', checkChashi());

        $this->assign('info', $info);

        $this->display();


    }

    /*回复个人消息*/
    public function reply()
    {

        if (!checkChashi()) {
            $this->Error('您还未登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }

        $pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? $_GET['pid'] : 1;

        $fid = isset($_GET['fid']) && is_numeric($_GET['fid']) ? $_GET['fid'] : 1;

        $news = M("ecs_post_news");

        $detail = $news->where("id=" . $fid)->find();

        $this->assign('detail', $detail);

        $this->assign('pid', $pid);

        $this->assign('fid', $fid);

        $this->assign('uid', checkChashi());

        $this->display();


    }

    /*
     * 删除个人发布的产品
     */
    public function delete()
    {
        if (!checkChashi()) {
            $this->Error('您还未登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        $id = $_GET["id"];
        $post = M("ecs_post");
        $post_content = M("ecs_post_content");
        $pics = $post_content->field("depic")->where("pid='$id'")->find();
        $result = $post->where("id='$id'")->delete();
        $post_content->where("pid='$id'")->delete();
        if ($result != false) {
            //$post_content->where("pid=$id")->delete();
            $picArray = explode(',', $pics['depic']);
            foreach ($picArray as $v) {
                if (file_exists("./Public/upload/$v")) {
                    unlink("./Public/upload/$v");
                }
            }
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }


    public function search()
    {

        if (!checkChashi()) {

            $this->Error('您还未登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }

        $this->display();

    }

    public function find()
    {

        if (!checkChashi()) {

            $this->Error('您还未登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }

        $key = trim($_POST['key']);

        $search = M();

        $sql = "select c.* from `shopnc_ecs_post` as c left join `shopnc_ecs_post_content` as d on c.id=d.pid where c.name like '%$key%' or c.brand like '%$key%' or d.content like '%$key%' ";

        $result = $search->query($sql);

        $this->assign('data', $result);

        $this->display();


    }

    public function api()
    {

        $cookie = addslashes($_POST['cookie']);

        $sessid = substr($cookie, 0, 32);

        $sess = M('ecs_sessions');

        $data = $sess->where("sesskey='" . $sessid . "'")->find();

        if ($data && ($data['userid'] != 0)) {

            $session = unserialize($data['data']);
            $session['user_id'] = $data['userid'];
            $user = M('ecs_users');
            $info = $user->where("user_id='" . $session['user_id'] . "'")->find();

            echo json_encode($info);

        } else {
            echo "";
        }

    }

    public function homeapi()
    {

        $saleway = isset($_POST['saleway']) && is_numeric($_POST['saleway']) ? $_POST['saleway'] : 0;

        $page = isset($_POST['page']) && is_numeric($_POST['page']) ? $_POST['page'] : 1;

        $sort = isset($_POST['sort']) && is_numeric($_POST['sort']) ? $_POST['sort'] : 2;

        $post = M("ecs_post");

        $where = '';

        if ($saleway == 1) {
            $where = "saleway='1'";
        } elseif ($saleway == 2) {

            $where = "saleway='2'";
        } elseif ($saleway == 0) {

            $where = "saleway='2' or saleway='1'";
        }
        if ($sort == 1) {
            $order = "order by id asc ";
        } elseif ($sort == 2) {
            $order = "order by id desc ";
        }
        $count = $post->where($where)->count();

        $sql = "select p.* ,d.depic,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where $where $order  limit " . (($page - 1) * 10) . ",10";

        $m = M();

        $data = $m->query($sql);

        $array = array();

        $array['total'] = $count;
        $array['data'] = $data;

        echo json_encode($array);

    }

    //首页商品api修改版,同homeapi,为了不影响之前app导致闪退重新写个接口
    public function product_list()
    {

        $saleway = isset($_POST['saleway']) && is_numeric($_POST['saleway']) ? $_POST['saleway'] : 0;

        $page = isset($_POST['page']) && is_numeric($_POST['page']) ? $_POST['page'] : 1;

        $sort = isset($_POST['sort']) && is_numeric($_POST['sort']) ? $_POST['sort'] : 2;

        $post = M("ecs_post");

        $where = '';

        if ($saleway == 1) {
            $where = "saleway='1'";
        } elseif ($saleway == 2) {

            $where = "saleway='2'";
        } elseif ($saleway == 0) {

            $where = "saleway='2' or saleway='1'";
        }
        if ($sort == 1) {
            $order = "order by id asc ";
        } elseif ($sort == 2) {
            $order = "order by id desc ";
        }
        $count = $post->where($where)->count();

        $sql = "select p.* ,d.depic,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where $where $order  limit " . (($page - 1) * 10) . ",10";

        $m = M();

        $data = $m->query($sql);

        $result = array();
        $content = array();

        if($data) {
            $result['code'] = 200;
            $content['total'] = $count;
            $content['data'] = $data;
            $result['content'] = $content;
        } else {
            $result['code'] = 404;
            $result['msg'] = '暂无数据';
        }

        echo json_encode($result);

    }

    public function myListapi()
    {
        $uid = $this->isLoginApi($_POST['username'], $_POST['key']);
        $array = array();
        if ($uid != 0) {
            $sql = "select p.*,d.depic,d.content from shopnc_ecs_post as p left join shopnc_ecs_post_content as d on p.id=d.pid where user_id='" . $uid . "'";
            $m = M();
            $data = $m->query($sql);
            if ($data) {
                $array['code'] = 200;
                $array['content'] = $data;
                echo json_encode($data);
            } else {
                $array['code'] = 404;
                $array['content'] = "获取数据失败";
            }
        } else {
            $array['code'] = 404;
            $array['content'] = "获取用户失败";
            echo json_encode($array);
        }
    }

    /*个人信息列表api*/

    public function newapi()
    {

        //$userid=isset($_POST['userid'])&&is_numeric($_POST['userid'])?$_POST['userid']:1;

        $userid = $this->isLoginApi($_POST['username'], $_POST['key']);

        $news = M('');

        /*$sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".checkChashi()."' group by pid";*/

        $sql = "select cid,pid,sum(isRead) as readed,count(*) as total from shopnc_ecs_post_news where uid ='" . $userid . "' or cid='" . $userid . "' group by pid";

        $newslist = $news->query($sql);

        $array = array();

        $post = M("ecs_post");

        foreach ($newslist as $v) {

            $info = $post->where("id='" . $v['pid'] . "'")->find();

            $v['pic'] = $info['pic'];

            $array[] = $v;

        }


        echo json_encode($array);


    }

    public function deleteapi()
    {
        $id = isset($_POST["id"]) && is_numeric($_POST['id']) ? $_POST['id'] : 1;
        $post = M("ecs_post");
        $post_content = M("ecs_post_content");
        $result = $post->where("id='$id'")->delete();
        $pics = $post_content->field("depic")->where("pid='$id'")->find();
        $post_content->where("pid='$id'")->delete();
        if ($result != false) {
            //$post_content->where("pid=$id")->delete();
            $picArray = explode(',', $pics['depic']);
            foreach ($picArray as $v) {
                if (file_exists("./Public/upload/$v")) {
                    unlink("./Public/upload/$v");
                }
            }
            echo 1;
        } else {
            echo 0;
        }
    }

    public function editor()
    {
        $uid = $this->checklogin();
        if (!$uid) {
            $this->Error('您还未登陆', "/wap/index.php/Home/Index/login?chashi=1");
        }
        $id = $_GET['id'];
        $postModel = M("ecs_post");
        $postDetail = $postModel->where("id='$id'")->find();
        $postContent = M("ecs_post_content");
        $detailContent = $postContent->field("content")->where("pid='$id'")->find();
        if ($uid['member_id'] != $postDetail['user_id']) {
            $this->Error('抱歉您不能编辑他人产品');
        }
        $postDetail['content'] = $detailContent['content'];
        $this->assign('detail', $postDetail);
        $this->display();
    }

    function newslistapi()
    {

        $cid = isset($_POST['cid']) && is_numeric($_POST['cid']) ? intval($_POST['cid']) : 1;
        $pid = isset($_POST['id']) && is_numeric($_POST['id']) ? intval($_POST['id']) : 1;
        //$userid=isset($_POST['userid'])&& is_numeric($_POST['userid'])? intval($_POST['userid']):1;
        $userid = $this->isLoginApi($_POST['username'], $_POST['key']);

        $news = M("ecs_post_news");

        $uid = $userid;

        $newslist = $news->where("pid='$pid' and (cid='$cid' or cid='$uid') ")->order("id asc")->limit(10)->select();

        echo json_encode($newslist);


    }


    /*保存客户买卖交易留言*/
    public function newssaveapi()
    {

        /**/
        $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : 1;

        $post = M("ecs_post");

        $info = $post->where("id='$id'")->find();

        $userid = $info['user_id'];


        $data['title'] = $_POST['title'];

        $data['content'] = $_POST['content'];

        $data['uid'] = $userid;

        $data['cid'] = $_POST['userid'];

        $data['pid'] = $_POST['id'];

        $data['fid'] = $_POST['userid'];

        $data['addtime'] = date("Y-m-d H:i:s");

        $news = M("ecs_post_news");

        $result = $news->add($data);

        if ($result) {

            echo 1;

        } else {

            echo 0;

        }

    }

    public function testtest()
    {

        $id = 351;

        $post = M("ecs_post");

        $info = $post->where("id='$id'")->find();

        print_r($info);

    }

    public function uploadImage()
    {
        $filename = date("YmdHis");
        $file = fopen('./Public/upload/' . $filename . ".jpg", "w");
        $data = base64_decode($_POST['img']);
        fwrite($file, $data);
        fclose($file);

        echo $_POST['img'];

    }

    public function EditorApi()
    {

        //echo "__APP__";

        $array = array();


        if (!$uid = $this->isLoginApi($_POST['username'], $_POST['key'])) {

            $array['code'] = 404;

            $array['content'] = '还未登陆';

            echo json_encode($array);

            die();

        }

        $data = array();

        $datacontent = array();

        $content = json_decode($_POST['content'], true);

        foreach ($content as $key => $v) {

            if (($key != 'id') && ($key != 'pic') && ($key != 'content')) {

                $data[$key] = $v;

            }

            if ($key == 'content') {

                $datacontent['content'] = $v;

            }

            if ($key == 'id') {

                $cid = $v;

            }

            if ($key == 'pic') {

                $time = time();

                $pic = array();

                foreach ($v as $k => $image) {

                    $value = base64_decode($image);

                    $name = $time . $k . '.jpg';

                    $pic[] = $name;

                    file_put_contents("./Public/upload/$name", $value);

                }

            }

        }

        if ($pic) {

            $data['pic'] = $pic[0];

            unset($pic[0]);

            $string = implode(",", $pic);

            $datacontent['depic'] = $string;

        }


        $postModel = M("ecs_post");

        $content = $postModel->where("id='$cid'")->save($data);

        $postcontentModel = M("ecs_post_content");

        $postcontentModel->where("pid='$cid'")->save($datacontent);

        if (!$content) {

            $array['code'] = 404;

            $array['content'] = $data;

        } else {

            $array['code'] = 200;

            $array['content'] = $data;

        }


        echo json_encode($array);


    }


    private function isLoginApi($username, $key)
    {
        $token = M("mb_user_token");
        $result = $token->where("member_name='$username' and token='$key'")->find();
        if ($result) {
            return $result['member_id'];
        } else {
            return 0;
        }
    }

    /*产品详细页面接口*/
    public function productDetailApi()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 1;
        $productModel = M();
        $sql = "SELECT p.*,c.depic,c.content,m.member_name,m.member_mobile from shopnc_ecs_post_content as c left join (shopnc_ecs_post as p left join shopnc_member as m on p.user_id=m.member_id) on c.pid=p.id where p.id='20'";
        $result = $productModel->query($sql);
        $array = array();
        if ($result) {
            $array['code'] = 200;
            $array['content'] = $result;
        } else {
            $array['code'] = 404;
            $array['content'] = '获取失败';
        }
        echo json_encode($array);

    }

    public function brand()
    {
        $this->display();
    }

    public function quotation()
    {
        $quotationid = $_GET['quotationid'];
        $quotationModel = M("ecs_quotation");
        $goods = $quotationModel->where("brand_id='$quotationid'")->select();
        $brandModel = M("brand");
        $brand = $brandModel->field("brand_name")->where("brand_id='$quotationid'")->find();
        $this->assign("brand", $brand['brand_name']);
        $this->assign("goods", $goods);
        $this->display();
    }

    public function qutation_api()
    {
        $quotationid = $_POST['brandid'];
        $quotationModel = M("ecs_quotation");
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $goods = $quotationModel->where("brand_id='$quotationid'")->limit(($page - 1) * 15, 15)->order("'order' desc,id desc")->select();
        $brandModel = M("brand");
        $brand = $brandModel->field("brand_name")->where("brand_id='$quotationid'")->find();
        $array = array();
        if ($goods) {
            $array['brand_name'] = isset($brand['brand_name']) ? $brand['brand_name'] : '';
            $array['code'] = 200;
            $array['content'] = $goods;
        } else {
            $array['code'] = 404;
            $array['msg'] = '暂无数据';
        }
        echo json_encode($array);

    }

}
