<?php 
use Model\Account\Cat;

$act = isset($_GET['act']) ? $_GET['act'] : '';
if ($act == 'data') {
    $cats = Cat::getEasyUITreeData();
    echo '[{"id": 0,"text": "根分类","children":'.json_encode($cats).'}]';
    exit(0);
}
?>
<div id="module-wrap">
    <h2>分类管理</h2>
    <ul id="category-true"></ul>
</div>
<div id="category_dialog"></div>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/app/category.js"></script>