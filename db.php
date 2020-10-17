<?php
$dsn = 'mysql:dbname=funny;host=127.0.0.1';
$pdo = new PDO($dsn,'fun', '321456');
function write($pdo, $sql){
    $sth = $pdo->prepare($sql);
    return $sth->execute();
}

function read($pdo, $sql){
    $sth = $pdo->prepare($sql);
    $sth->execute();

    $rows = $sth->fetchAll();
    return $rows;
}
?>