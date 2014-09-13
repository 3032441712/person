<div id="module-wrap">
    <h2>欢迎页面</h2>
    <div class="line" style="margin: 0px 5px 5px; border: 1px solid darkslategrey;">
        <h3 style="margin: 0px 0px 5px; background-color: wheat; line-height: 20px; height: 21px;">服务器相关</h3>
        <ul style="list-style: decimal outside none;">
            <li><label style="display: inline-block; width: 80px; text-align: left;">PHP版本</label> <?php echo PHP_VERSION?></li>
            <li><label style="display: inline-block; width: 80px; text-align: left;">OS版本</label> <?php echo PHP_OS?></li>
        </ul>
    </div>
    <div class="line" style="margin: 0px 5px; border: 1px solid darkslategrey; height: 230px;">
        <h3 style="margin: 0px 0px 5px; background-color: wheat; line-height: 20px; height: 21px;">PHP扩展</h3>
        <ul style="list-style: decimal outside none;">
            <?php 
            $exts = get_loaded_extensions();
            foreach ($exts as $v):
            ?>
            <li style="width: 130px; float: left; height: 20px; line-height: 20px;"><?php echo $v;?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>