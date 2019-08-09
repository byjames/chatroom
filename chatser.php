<?php

$server = new swoole_websocket_server('0.0.0.0', 9501);

$server->on("open", "openServer");
$server->on("message", "messageServer");
$server->on("close", "closeServer");
$server->on("workerStart", 'isOnWorkerStart');
$user_id = 0;
function isOnWorkerStart($server, $worker_id)
{
    include "autoload.php";

    log_message::info(" isOnWorkerStart ");
}

/**
 * open server
 * @param $server
 * @param $request
 */
function openServer($server, $request)
{
    log_message::info(" openServer ", $request);
    echo "server: handshake success with fd{$request->fd}";
}

function messageServer($server, $frame)
{
    //require "autoload.php";

    log_message::info("@@@@@@@@@@@@@@@client messageServer Info", " server fd", $frame->fd, " server data", $frame->data);

    $chat = new ChatModel($server, $frame->fd, $frame->data);
    log_message::info("@@@@@@@@@@@@@@@client messageServer in class chatmodel");
    echo $chat;
    // 解包

    // 处理之后返回发包开始
    // MODE 里进行处理

    // 对应用户数据
    /*foreach ($server->connections as $key => $fd) {
        $user_message = $frame->data;
        log_message::info(" messageServer ", $user_message);
        $server->push($fd, "fd1212121" . $user_message);
    }*/
}

function closeServer($ser, $fd)
{

    $data = ['pact' => 'quit'];
    $chat = new ChatModel($ser, $fd, $data);
    log_message::info(" client ", $fd, $data);
    echo "client {$fd} closed\n";
}


$server->start();