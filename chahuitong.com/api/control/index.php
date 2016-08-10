<?php
/**
 * 首页
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class indexControl extends mobileHomeControl{

	public function __construct() {
        parent::__construct();
    }

    /**
     * 首页
     */
	public function indexOp() {
        //进入此版主页时，跳转到wap目录下的手机站点
        //redirect('/wap');
        //以下为原本的代码
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialIndex();
        $this->_output_special($data, $_GET['type']);
	}

    /**
     * 专题
     */
	public function specialOp() {
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialItemUsableListByID($_GET['special_id']);
        $this->_output_special($data, $_GET['type'], $_GET['special_id']);
	}

    /**
     * 输出专题
     */
    private function _output_special($data, $type = 'json', $special_id = 0) {
        $model_special = Model('mb_special');
        if($type == 'html') {
            $html_path = $model_special->getMbSpecialHtmlPath($special_id);
            if(!is_file($html_path)) {
                ob_start();
                Tpl::output('list', $data);
                Tpl::showpage('mb_special');
                file_put_contents($html_path, ob_get_clean());
            }
            header('Location: ' . $model_special->getMbSpecialHtmlUrl($special_id));
            die;
        } else {
            output_data($data);
        }
    }

    /**
     * android客户端版本号
     */
    public function apk_versionOp() {
        $model_setting = Model('setting');
		$mobile_apk = $model_setting->getRowSetting('mobile_apk');
        $mobile_apk_version = $model_setting->getRowSetting('mobile_apk_version');
        $mobile_version_info = $model_setting->getRowSetting('mobile_version_info');

        $data = array(
            'url' => $mobile_apk['value'],
            'info' => $mobile_version_info['value'],
            'version' => $mobile_apk_version['value']
        );
        $data['if_update'] = $mobile_apk_version['value'] !== $_GET['version'];

        output_json(1, $data);
    }
}
