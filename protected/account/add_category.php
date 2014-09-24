<?php
use Model\Account\Cat;
use Form\Response;

$act = isset($_GET['act']) ? $_GET['act'] : '';
$catId = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
$parentId = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0;
$catInfo = array(
    'cat_id' => 0,
    'cat_title' => '根分类'
);
$catData = array('cat_id'=>'','cat_title'=>'');

if ($act == 'add') {
    if ($parentId != 0) {
        $catInfo = Cat::getCatsDataById($parentId, 'cat_id,cat_title');
    }
} elseif ($act == 'edit') {
    $catData = Cat::getCatsDataById($catId, 'cat_id,cat_title,cat_parent');
    if ($catData['cat_parent'] != 0) {
        $catInfo = Cat::getCatsDataById($catData['cat_parent'], 'cat_id,cat_title');
    }
} elseif ($act == 'save') {
    $data = isset($_POST['category']) && is_array($_POST['category']) ? $_POST['category'] : array();
    $saveData = array(
        'cat_title' => isset($data['title']) ? $data['title'] : '',
        'cat_parent' => isset($data['parent_id']) ? $data['parent_id'] : ''
    );

    $saveData = array_map('trim', $saveData);
    if (Cat::isCatTitle($saveData['cat_title']) == false) {
        Response::json(array('msg' => '分类名称填写有误,请重新填写'), 1);
    }

    if ($catId > 0) {
        $catData = Cat::getCatsDataById($catId, 'cat_id,cat_title');
        unset($saveData['cat_parent']);
        if ($catData['cat_title'] == $saveData['cat_title']) {
            Response::json(array('msg' => '数据未更改'), 1);
        }

        Cat::update($saveData, $catId);
    } else {
        Cat::insert($saveData);
    }
    Response::json(array('msg' => '数据录入成功'), 0);
} elseif ($act == 'delete') {
    Cat::delete($catId);
    Response::json(array('msg' => '数据删除成功'), 0);
}

?>
<form id="category_form" method="post" action="<?php echo WEB_URL . '/index.php?d=account&f=add_category&act=save&cat_id='.$catId?>">
<div id="form_wrap">
    <div class="field_line">
        <label>上级分类</label>
        <input style="width:50px;text-align:center;" name="category[parent_id]" type="text" value="<?php echo $catInfo['cat_id']?>" readonly="readonly" />
        <input style="width:135px;text-align:center;" type="text" value="<?php echo $catInfo['cat_title']?>" disabled="disabled" />
    </div>
    <div class="field_line">
        <label>分类名称</label>
        <input name="category[title]" type="text" value="<?php echo $catData['cat_title']?>" />
    </div>
    <div class="field_line">
		<a href="#" onclick="category_form_submit();" class="easyui-linkbutton"><?php if ($catId < 1):?>添加<?php else:?>编辑<?php endif;?></a>
		&nbsp;&nbsp;
		<a href="#" onclick="category_dialog('close');" class="easyui-linkbutton">关闭</a>
    </div>
</div>
</form>