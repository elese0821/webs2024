<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "../connect/connect.php";
include "../connect/session.php";
    // $memberId = $_SESSION['memberId'];
    // $blogAuthor = $_SESSION['youName'];

    $memberId = 1;
    $blogAuthor = "원영";
    $blogCategory = $_POST['blogCategory'];
    $blogTitle = $_POST['blogTitle'];
    $blogContents = nl2br($_POST['blogContents']);

    $blogView = 1;
    $blogLike = 0;
    $blogRegTime = time();
    $blogDelete = 1;
    
    $blogFile = $_FILES['blogFile'];
    $blogImgSize = $_FILES['blogFile']['size'];
    $blogImgType = $_FILES['blogFile']['type'];
    $blogImgName = $_FILES['blogFile']['name'];
    $blogImgTmp = $_FILES['blogFile']['tmp_name'];

    // echo "<pre>";
    // var_dump($blogFile);
    // echo "</pre>";
// 이미지 파일 업로드
if($blogImgType){
    $fileTypeExtension = explode("/", $blogImgType);
    $fileType = $fileTypeExtension[0];  // img
    $fileExtension = $fileTypeExtension[1];  // jpeg

    // 이미지 타입 확인
    if($fileType === "image"){
        if($fileExtension === "jpg" || $fileExtension === "jpeg" || $fileExtension === "png" || $fileExtension === "gif" || $fileExtension === "webp"){
            $blogImgDir = "../assets/blog/";
            $blogImgName = "Img_".time().rand(1,99999)."."."{$fileExtension}";
            $sql = "INSERT INTO blog(memberId, blogTitle, blogContents, blogCategory, blogAuthor, blogRegTime, blogView, blogLike, blogImgFile, blogImgSize, blogDelete) VALUES('$memberId', '$blogTitle', '$blogContents', '$blogCategory', '$blogAuthor', '$blogRegTime', '$blogView', '$blogLike', '$blogImgName', '$blogImgSize', '$blogDelete')";
            
            $uploadResult = move_uploaded_file($blogImgTmp, $blogImgDir.$blogImgName);

            if($uploadResult){
                echo "<script>alert('이미지 업로드 및 저장이 완료되었습니다.');</script>";
            } else {
                echo "<script>alert('이미지 파일을 저장하는 동안 문제가 발생했습니다.');</script>";
            }
        } else {
            echo "<script>alert('이미지 파일 형식이 아닙니다.');</script>";
        }
    } else {
        echo "<script>alert('이미지 파일이 아닙니다.');</script>";
    }
} else {
    echo "<script>alert('이미지 파일을 첨부하지 않았습니다.');</script>";
    echo "<script>window.location.href='blog.php';</script>";
    $sql = "INSERT INTO blog(memberId, blogTitle, blogContents, blogCategory, blogAuthor, blogRegTime, blogView, blogLike, blogImgFile, blogImgSize, blogDelete) VALUES('$memberId', '$blogTitle', '$blogContents', '$blogCategory', '$blogAuthor', '$blogRegTime', '$blogView', '$blogLike', 'Img_default.jpg', '$blogImgSize', '$blogDelete')";
}

// 이미지 사이즈 확인
if($blogImgSize > 10000000){
    echo "<script>alert('이미지 파일 용량이 1MB를 초과했습니다.');</script>";
}

$result = $connect->query($sql);

if($result){
    echo "<script>alert('저장이 완료되었습니다.');</script>";
    echo "<script>window.location.href='blog.php';</script>";
}

?>
</body>
</html>