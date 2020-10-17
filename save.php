<?php
include('db.php');
$dsn = 'mysql:dbname=funny;host=127.0.0.1';
$pdo = new PDO($dsn,'fun', '321456');
$content = $_POST['content'];
$username = $_POST['username'];
if( trim($content) == '' or trim($username)=='' ){
    echo '用户名、留言内容不能为空';
    exit;
}
if( $username == 'admin' || $username=='root' || $username=='领导人' ){
    echo '用户名不能为敏感字';
    exit;
}
$sql = "insert into pig(username,content) values ('{$username}', '{$content}')";
write($pdo, $sql);

//跳转回首页
header('location: index.php');
?>
