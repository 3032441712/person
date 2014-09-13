<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo APP_NAME . ' ' . APP_VERSION?></title>
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/static/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/static/themes/icon.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/static/themes/color.css">
<link rel="stylesheet" type="text/css" href="<?php echo WEB_URL?>/static/styles.css">
<script type="text/javascript" src="<?php echo WEB_URL?>/static/prettify.js"></script>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_URL?>/static/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript">
var WEB_URL = '<?php echo WEB_URL?>';

function open_tab(title, href){
	if ($('#tt').tabs('exists',title)){
		$('#tt').tabs('select',title);
	} else {
		$('#tt').tabs('add',{
			title:title,
			href:WEB_URL+'/'+href,
			closable:true,
			extractor:function(data){
				return data;
			}
		});
	}
}

function logout_system()
{
	window.location.href = 'index.php?d=login&f=logout';
}
</script>
</head>
<body class="easyui-layout" style="text-align:left">
    <div region="north" style="height:30px;" border="false" style="background:#fff;text-align:center">
        <div id="header-inner">
            <div style="line-height: 30px; text-align: right; margin-right: 45px;">
                <span>当前登录用户:</span>
                <span><?php echo $_SESSION['user_name']?></span>
                <span style="margin-left: 5px;"><a href="javascript:void(0);" onclick="logout_system();">退出系统</a></span>
            </div>
        </div>
    </div>
    <div region="west" split="true" title="系统菜单" style="width:250px;padding:5px;">
        <ul class="easyui-tree">
            <li iconCls="icon-base">
                <span>基本数据</span>
                <ul>
                    <li iconCls="icon-gears">
                        <a class="e-link" href="#" onclick="javascript:void(0);">区域管理</a>
                    </li>
                </ul>
            </li>
            <li iconCls="icon-base">
                <span>用户管理</span>
                <ul>
                    <li iconCls="icon-gears">
                        <a class="e-link" href="#" onclick="open_tab('用户管理', 'index.php?d=user')">用户管理</a>
                    </li>
                </ul>
            </li>
            <li iconCls="icon-base">
                <span>帐号管理</span>
                <ul>
                    <li iconCls="icon-gears">
                        <a class="e-link" href="#" onclick="open_tab('帐号分类', 'index.php?d=account&f=category')">帐号分类</a>
                    </li>
                    <li iconCls="icon-gears">
                        <a class="e-link" href="#" onclick="open_tab('帐号管理', 'index.php?d=account')">帐号管理</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div region="center">
        <div id="tt" class="easyui-tabs" fit="true" border="false" plain="true">
            <div title="欢迎页面" href="<?php echo WEB_URL?>/index.php?d=welcome"></div>
        </div>
    </div>
</body>
</html>