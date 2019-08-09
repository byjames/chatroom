<?php
ini_set("display_errors", "On");

error_reporting(E_ALL | E_STRICT);
require "autoload.php";

$name = $_REQUEST['account'];
$pas = $_REQUEST['paw'];
$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : ZERO; // 1 注册 2 登录
log_message::info(1);
$ChatModel = new  ChatModel($type);
log_message::info(2);
log_message::info(json_encode($_REQUEST, JSON_UNESCAPED_UNICODE));
log_message::info($name . "--" . $pas);

if (isBlank($name) || isBlank($pas)) {

    $rs = [
        'msg' => '用户名密码不能为空',
    ];
    echo json_encode($rs, JSON_UNESCAPED_UNICODE);
}
if (!isBlank($name) && !isBlank($pas)) {
    log_message::info(3);
    $data = $ChatModel->userVerif();
    $data = is_string($data) ? json_decode($data, true) : $data;
    $rs = [
        'msg' => '用户名密码ok',
        'data' => $data
    ];
    log_message::info(4);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    // 校验用户名
}