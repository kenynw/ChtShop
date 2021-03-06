<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/6/20
 * Time: 下午3:45
 */
defined('InShopNC') or exit('Access Invalid!');
class articleControl extends mobileCMSControl {

    public function __construct() {
        parent::__construct();
    }

    public function article_listOp() {
        $model_article = Model('cms_article');

        $field = 'article_id, article_title, article_class_id, article_origin, article_origin_address, article_author, article_image, article_publish_time, article_click, article_sort, article_commend_flag, article_state, article_publisher_name, article_publisher_id, article_attachment_path, article_comment_count';

        $condition = array();
        $condition['article_state'] = self::ARTICLE_STATE_PUBLISHED;

        if (!empty($_GET['class_id'])) {
            $condition['article_class_id'] = intval($_GET['class_id']);
        }

        if(!empty($_GET['tag_id'])) {
            $condition['relation_tag_id'] = intval($_GET['tag_id']);
            $article_list = $model_article->getListByTagID($condition, $this->page, 'article_sort asc, article_id desc');
        } else {
            $article_list = $model_article->getList($condition, $this->page, 'article_sort asc, article_id desc', $field);
        }

        if (!empty($article_list)) {
            foreach ($article_list as $k=>$v) {
                $article_list[$k]['article_url'] = getMbCMSArticleUrl($v['article_id']);
                $article_list[$k]['article_image'] = getCMSArticleImageUrl($v['article_attachment_path'], $v['article_image'], 'list');
                $article_list[$k]['article_publisher_avatar'] = getMemberAvatarForID($v['article_publisher_id']);
            }
        }
        
        $page_count = $model_article->gettotalpage();

        output_json(1, array('list' => $article_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 文章详情
     */
    public function article_detailOp() {
        $article_id = intval($_GET['article_id']);
        if($article_id <= 0) {
            output_json(0, '参数出错');
        }

        $model_article = Model('cms_article');
        $article_detail = $model_article->getOne(array('article_id'=>$article_id));
        if(empty($article_detail) || intval($article_detail['article_state']) !== self::ARTICLE_STATE_PUBLISHED) {
            output_json(0, '文章不存在');
        }

        // 计数加1
        $model_article->modify(array('article_click'=>array('exp','article_click+1')),array('article_id'=>$article_id));

        // 获取评论
        $model_cms_comment = Model('cms_comment');
        $condition = array();
        $condition["comment_object_id"] = $article_id;
        $condition["comment_type"] = self::ARTICLE;
        $order = 'comment_up desc, comment_id desc';
        $comment_list = $model_cms_comment->getListWithUserInfo($condition, $this->page, $order);
        Tpl::output('comment_list', $comment_list);

        //seo
        Tpl::output('seo_title', $article_detail['article_title']);
        Tpl::output('article_keyword', $article_detail['article_keyword']);
        Tpl::output('article_description', $article_detail['article_abstract']);

        Tpl::output('article_detail', $article_detail);
        Tpl::showpage('article_detail');
    }

    /**
     * 赞文章评论
     */
    public function comment_upOp() {

        $data = array();
        $data['result'] = 'true';

        $comment_id = intval($_POST['comment_id']);
        if($comment_id > 0) {
            $model_comment_up = Model('cms_comment_up');
            $param = array();
            $param['comment_id'] = $comment_id;
            $param['up_member_id'] = $_SESSION['member_id'];
            $is_exist = $model_comment_up->isExist($param);
            if(!$is_exist) {
                $param['up_time'] = time();
                $model_comment_up->save($param);

                $model_comment = Model('cms_comment');
                $model_comment->modify(array('comment_up'=>array('exp', 'comment_up+1')), array('comment_id'=>$comment_id));
            } else {
                $data['result'] = 'false';
                $data['message'] = '顶过了';
            }
        } else {
            $data['result'] = 'false';
            $data['message'] = Language::get('wrong_argument');
        }
        self::echo_json($data);
    }

}