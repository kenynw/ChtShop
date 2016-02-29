<?php
//创建对象并打开连接，最后一个参数是选择的数据库名称
$mysqli = new mysqli('localhost','root','Chaxinkeji2015');
//检查连接是否成功
if (mysqli_connect_errno()){
    //注意mysqli_connect_error()新特性
    die('Unable to connect!'). mysqli_connect_error();
}
$serv = new swoole_websocket_server("0.0.0.1", 9501);

$serv->on('Open', function($server, $req) {
    echo "connection open: ".$req->fd;
});

$serv->on('Message', function($server, $frame) {
    echo "message: ".$frame->data;
    $server->push($frame->fd, json_encode(["hello", "world"]));
});

$serv->on('Close', function($server, $fd) {
    echo "connection close: ".$fd;
});

$serv->start();

?>