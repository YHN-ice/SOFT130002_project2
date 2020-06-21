<?php
require_once('config.php');
if (!isset($_COOKIE['Username']))
    exit('请先登录');
$image = $_FILES['file'];
if ($image['error'] > 0) {
    $error = "上传失败了,原因是";

    switch ($image['error']) {
        case 1:
            $error .= "大小超过了服务器设置的限制！";
            break;
        case 2:
            $error .= "文件大小超过了表单的限制！";
            break;
        case 3:
            $error .= "文件只有部分被上传！";
            break;
        case 4:
            $error .= "没有文件被上传!";
            break;
        case 6:
            $error .= "上传文件的临时目录不存在！";
            break;
        case 7:
            $error .= "写入失败!";
            break;
        default:
            $error .= "未知的错误！";
            break;
    }
    //输出错误
    exit($error);
} else {
    //截取文件后缀名
    $type = strrchr($image['name'], ".");
    $imgName = time() . $type;

    //设置上传路径，我把它放在了upload下的interview目录下（需要在linux中给interview设置文件夹权限）
    $path = "../../travel-images/large/" . $imgName;

    //判断上传的文件是否为图片格式
    if (strtolower($type) == '.png' || strtolower($type) == '.jpg' || strtolower($type) == '.bmp' || strtolower($type) == '.gif') {
        //将图片文件移到该目录下
        move_uploaded_file($image['tmp_name'], $path);

        $title = $_POST['title'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $PATH = $imgName;


        $country = $_POST['countries'];
        $city = $_POST['cities'];
        $user = $_COOKIE['Username'];


        try {
            $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $CityCode = '';
            $UID = '';
            $Latitude = '';
            $Longitude = '';

            $sqlForCityCode = "SELECT GeoNameID,Latitude,Longitude,AsciiName FROM geocities WHERE GeoNameID = '{$city}'";
            $sqlForUID = "SELECT UID,UserName FROM traveluser WHERE UserName = '{$user}'";
            $sqlForImageID = "SELECT ImageID FROM travelimage ORDER BY ImageID";

            $resultForImageID = $conn->query($sqlForImageID);
            $maxImageID = 0;
            while ($row = $resultForImageID->fetch()) {
                $maxImageID++;
            }

            //$newImageID = $maxImageID + 2;
            //$newImageID = null;


            $resultCityCode = $conn->query($sqlForCityCode);
            while ($row = $resultCityCode->fetch()) {
                $CityCode = $row['GeoNameID'];
                $Latitude = $row['Latitude'];
                $Longitude = $row['Longitude'];
            }

            $resultForUID = $conn->query($sqlForUID);
            while ($row = $resultForUID->fetch()) {
                $UID = $row['UID'];
            }

            if (isset($_POST['upload'])){
                $sql = "INSERT INTO travelimage (Title, Description, Content, PATH, Latitude,Longitude,CityCode,Country_RegionCodeISO,UID)  VALUES ('{$title}', '{$description}', '{$content}','{$PATH}','{$Latitude}','{$Longitude}','{$CityCode}','{$country}','{$UID}')";
                echo "New record created ";
            }
            else if (isset($_POST['modify'])){
                $sql = "UPDATE travelimage  SET Title = '{$title}', Description = '{$description}', Content = '{$content}', PATH = '{$PATH}',Latitude='{$Latitude}',Longitude = '{$Longitude}',CityCode='{$CityCode}',Country_RegionCodeISO = '{$country}',UID='{$UID}' WHERE ImageID = '{$_GET['ImageID']}'";
                echo "Modified ";
            }

            // use exec() because no results are returned
            $conn->exec($sql);
            echo "successfully";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    } else
        exit('请上传图片');
}