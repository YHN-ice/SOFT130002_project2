<?php
function getDropDown(){
    return "<div class=\"dropdown\">

            <div class=\"menu\">个人中心</div>

            <div class=\"drop-content\">
                <a href=\"upload.php\"><img src=\"../../images/icons/upload.png\"/>上传</a>
                <a href=\"my-pics.php\"><img src=\"../../images/icons/my-pics.png\"/>我的照片</a>
                <a href=\"my-collection.php\"><img src=\"../../images/icons/my-collection.png\"/>我的收藏</a>
                <a href=\"logout.php\"><img src=\"../../images/icons/log-in.png\"/>登出</a>
            </div>

        </div>";
}

if (isset($_COOKIE['Username'])){
    echo getDropDown();
}
else
    echo "<div><a href=\"login.php\">登陆</a></div>";