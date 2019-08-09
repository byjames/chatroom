<?php

require "autoload.php";

$name = $_REQUEST['account'];
$pas = $_REQUEST['paw'];
$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : ZERO; // 1 注册 2 登录
if (!empty($name) && !empty($pas) && isset($_REQUEST['login2'])) {
    $_SESSION['account'] = $name;
    $_SESSION['password'] = $pas;
    $account = $_SESSION['account'];
    $password = $_SESSION['password'];
    $data = [
        'account' => $account,
        'password' => $password
    ];
    $pactdata = Utils::senFormatData('login', $data);
} else {

    echo "<script>alert('账号密码不能为空！');
window.location.href='login.php';</script>";
}
/*$ChatModel = new  ChatModel($type);
$ChatModel->userLogin();
if (!empty($name) && !empty($pas)) {
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
}*/
$time = null;
$weekarray = array("日", "一", "二", "三", "四", "五", "六"); //先定义一个数组
$time = date('Y-m-d') . " 星期" . $weekarray[date("w")] . ' ' . date("H:i:s");
//$pactdata = Utils::senFormatData('Intopic', $data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="http://localhost:8055/chatroom/res/js/jquery.cookie.js"></script>
<script>

    $(function () {
        $("#quit").click(function () {
            window.history.back(-1);
        });

    });
</script>
<body>
<div id="user_id"></div>
<div id="roole_id" style="display: none"></div>
<input type="button" name="quit" id='quit' value="退出"/>
<input type="button" name="close" value="清理记录" onclick="close_session('userinfo_data')">
<div>
    <marquee onMouseOut="this.start()" onMouseOver="this.stop()" id="bulletin">

    </marquee>

</div>
<div id="friend" style="border:1px solid;width: 600px;height: 100px;">
    <table id="friendtables">

    </table>
</div>
<div style="margin-left:400px">
    <p id="byfriend"></p>
    <div style="border:1px solid;width: 600px;height: 500px;">

        <div id="msgArea"
             style="width:100%;height: 100%;text-align:start;resize: none;font-family: 微软雅黑;font-size: 20px;overflow-y: scroll"></div>
    </div>
    <div style="border:1px solid;width: 600px;height: 200px;">
        <div style="width:100%;height: 100%;">
            <textarea id="userMsg"
                      style="width:100%;height: 100%;text-align:start;resize: none;font-family: 微软雅黑;font-size: 20px;"></textarea>
        </div>
    </div>
    <div style="border:1px solid;width: 600px;height: 25px;">
        <button style="float: right;" onclick="sendMsg()">发送</button>
    </div>

</div>
</body>
<p></p>
<form id="ByFrom">
    <input type="hidden" id="userid" name="userid"/>
    <input type="hidden" id="nickname" name="nickname"/>
</form>
</html>

<script>
    //修改备注


    var ws;
    var userinfo = {};
    var friends_info = {};
    var strings = <?php echo $pactdata; ?>;
    var time = "<?php echo $time;?>";
    var timestamp = (new Date()).getTime();
    var friend_realtime = {};
    var storage = window.sessionStorage;
    var Interval = {};
    $(document).on("click", "#friendtables tr td", function () {
        $('#byfriend').html('');
        var _this = $(this);
        var userinfo = _this.text();
        var id = $(this).attr("data-name");
        $('#byfriend').append(userinfo + "(" + id + ")");
        $('#ByFrom #userid').text(id);
        // 展示消息
        var in_data_json = getJson();
        setinfo(in_data_json, id);
        if (Interval.id) {
            clearInterval(Interval.id);
        }

    });
    $(document).on("reload", "#friendtables tr td", function () {
        $("#friendtables").each(function () {

            var _this = $(this);
            var text = null;
            var userinfo = _this.text();
            var value = $(_this).parent().parent().find('[data-name=' + roole + ']').text();

        });

    });

    $("#friendtables tr").each(function () {
        var _this = $(this);
        var text = null;
        var userinfo = _this.text();
        if (userinfo) {
            // 设置
        }

    });

    function client_info(roole) {
        $("#friendtables").each(function () {
            //alert(2222);
            var _this = $(this);
            var text = null;
            var userinfo = _this.text();
            var value = $(_this).parent().parent().find('[data-name=' + roole + ']').text();
            //var itemName = $("table tr").attr("data-name");
            //console.log("clicen_info"+itemName);
            //var v1 = _this.getAttribute('data-name');

            /* if (userinfo == roole) {
                 // 设置
                 alert(roole);
             }
             else {
                 alert('and info:' + userinfo);
             }*/

        });

    }

    $(function () {
        link();


    })

    function link(accountid) {
        ws = new WebSocket("ws://192.168.0.183:9501");//连接服务器

        ws.onopen = function (event) {
            console.log(event);
            // login

            var data_message = JSON.stringify(strings);
            // login
            ws.send(data_message);
            // get userInfo
            alert('连接了');
        };

        ws.onmessage = function (event) {

            // 这里去处理解析服务api的相关接口
            var obj = JSON.parse(event.data);
            var serdat = obj.msg;
            var status = obj.status;
            var pact = obj.pact;

            // 回调成功
            if (status == 1) {
                //login

                switch (pact) {
                    case 'login':
                        // 获取用户信息
                        var nick_name = obj.msg.nick_name;
                        $('#ByFrom #nickname').text(nick_name);
                        var id = obj.msg.id;
                        // 获取用户好友信息bulletin
                        $("#bulletin").append("Welcome back " + nick_name + "!!");
                        $("#user_id").append("ID :: " + id);
                        $("#roole_id").append(id);
                        var friendinfo = obj.msg.friendinfo
                        // 展示好好友信息列表
                        //$("#friend").append("<table id='friendtables'>");
                        var html = '';

                        for (var p in friendinfo) {//遍历json数组时，这么写p为索引，0,1
                            var nickname = friendinfo[p].nick_name;
                            var id = friendinfo[p].id;
                            var status = friendinfo[p].status;
                            status = (nickname != "" && status == 1
                            )
                                ? '在线' : '离线'
                            html += "<tr><td data-name=" + id + ">" + nickname + status + "</td></tr>";
                        }
                        // data = {"pact": "sende_message","data": {"time": time, "msg": msg, "friendid": friendid, "user_id": userid}};
                        //var data = JSON.stringify(data);
                        $('#friendtables').append(html);
                        //$("#friend").append("</table>");
                        break;
                    case 'sende_message':

                        var friend_nickname = obj.msg.friend_info.nick_name;
                        var friend_id = parseInt(obj.msg.friend_info.id);
                        var friend_msg = obj.msg.info;
                        var timestamp = (new Date()).getTime();
                        friend_realtime.friend_id = friend_id;
                        var info = "<p style='color: #0a789b'>" + "(" + friend_nickname + ")" + time + "</p>" + "<p>" + obj.msg.info + "</p>";
                        /*var info = "<p>" + "(" + friend_nickname + ")" + obj.msg.info + "</p>";*/
                        // 这里设置更改为提示在用户列表中闪烁灯 吧接收的消息存放缓存里
                        // 后面当点击的时候 获取缓存的消息数据并且展现到列表上面
                        $("#friendtables tr td").each(function (obj) {
                            //alert("friend_id:" + friend_id);
                            var _this = $(this);
                            var userinfo = _this.text();
                            // alert(userinfo);

                            var dataname = $(_this).attr("data-name");
                            //alert(dataname);

                            // exportRaw('userinfo.txt', friend_nickname + ":" + friend_msg);//
                            //localStorage
                            //var data =
                            // 如果列表有用户
                            if (dataname == friend_id) {
                                $.cookie("roolestatus", friend_id);
                                // 根据消息的用户id存放到数组追加最后 当用户不在线的时候存放到服务端吧消息
                                // 如果在线的时候直接发过来存放session data
                                // 后面当用户点击消息闪动的时候读取状态未能读取的内容 并且设置session 的状态
                                var data = {
                                    "friend_msg": friend_msg,
                                    "friendid": friend_id,
                                    "friend_nickname": friend_nickname,
                                    'create_at': time,
                                    'status': 1
                                };
                                //var data = JSON.stringify(datad);
                                var dd = $('#byfriend').text();
                                // 并且已经非存在的对话框泽
                                Interval.id = setInterval("changeColor()", 200);//每0.2秒变换一种颜色
                                // 展示消息
                                var in_data_json = setJson(data);


                            }
                        });
                        //$("#msgArea").append(info);
                        break;
                    case 'intopic':
                        // set json
                        //  set info

                        var in_data_json = serdat;
                        if (in_data_json != false) {

                            setinfo(in_data_json, friend_realtime.friend_id);
                        }

                        break;
                    default:
                        alert('无效的协议');
                        break;

                }

            } else {

                alert(obj.msg);

                window.history.back(-1);

            }
            //var msg = "<p>" + event.data + "</p>";
            //$("#msgArea").append(obj.status);
            //$("#msgArea").append(msg);
        }
        ws.onclose = function (event) {
            alert("已经与服务器断开连接\r\n当前连接状态：" + this.readyState);
        };

        ws.onerror = function (event) {
            alert("WebSocket异常！");
        };
    }


    var data = [];
    data = undefined;


    /***
     * 客户端发消息
     */
    function sendMsg() {
        var msg = $("#userMsg").val();
        var friendid = $('#ByFrom #userid').text();
        if (friendid == "" || friendid == null || friendid == false || friendid == "undefined") {
            alert("请选择用户在进行发消息");
            return false;
        }
        var username = $('#ByFrom #nickname').text();
        var userid = $("#roole_id").text();
        data = {"pact": "sende_message", "data": {"msg": msg, "friendid": friendid, "user_id": userid}};
        var data = JSON.stringify(data);


        var info = "<p>" + "(" + username + ")" + time + "</p>" + "<p>" + msg + "</p>";

        $("#msgArea").append(info);

        ws.send(data);
    }

    function changeColor() {
        // 目前是单个 后期改为多个 通过设置cookie来进行设置
        var roolestatus = $.cookie("roolestatus");

        if (roolestatus != "undefined" && roolestatus != null && roolestatus != null) {

            $("#friendtables tr td").each(function () {

                var _this = $(this);
                var userinfo = _this.text();
                // alert(userinfo);
                var dataname = $(_this).attr("data-name");

                if (dataname == roolestatus) {

                    var color = "#f00|#0f0|#00f|#880|#808|#088|yellow|green|blue|gray";
                    color = color.split("|");
                    var rand_color = color[parseInt(Math.random() * color.length)];
                    $(_this).parent().css("color", rand_color);
                }
            });

        }

        //$(obj).parent().css("color", rand_color);
    }


    function fakeClick(obj) {
        var ev = document.createEvent("MouseEvents");
        ev.initMouseEvent("click", true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        obj.dispatchEvent(ev);
    }

    function exportRaw(name, data) {
        var urlObject = window.URL || window.webkitURL || window;
        var export_blob = new Blob([data]);
        var save_link = document.createElementNS("http://www.w3.org/1999/xhtml", "a")
        save_link.href = urlObject.createObjectURL(export_blob);
        save_link.download = name;
        fakeClick(save_link);
    }

    function extend(des, src, override) {
        if (src instanceof Array) {
            for (var i = 0, len = src.length; i < len; i++)
                extend(des, src[i], override);
        }
        for (var i in src) {
            if (override || !(i in des)) {
                des[i] = src[i];
            }
        }
        return des;
    }

    function setinfo(data, uid) {

        uid = uid ? parseInt(uid) : '';
        var dat = [];
        var indata = JSON.parse(data);
        var usertitle = $('#byfriend').text();
        //var clien_uid = $('#ByFrom #userid').text();
        var i = 0;
        if (uid != '') {
            $.each(indata, function (infoIndex, info) {
                var msg = info["friend_msg"];
                if (msg != undefined) {
                    var msg = info["friend_msg"];
                    var friendid = parseInt(info["friendid"]);
                    var friend_nickname = info["friend_nickname"];
                    var status = info["status"];
                    var userinfo = null;
                    // 如果用户打开对话框口 并且状态没有获取 直接显示
                    if (friendid === uid && status == 1 && usertitle != "") {
                        info["status"] = 0;
                        // 设置data的status 为1
                        // userinfo = "(" + friend_nickname + ")" + time + "<br>" + "\n" + msg;
                        userinfo = "<p>" + "(" + friend_nickname + ")" + time + "</p>" + "<p>" + msg + "</p>";

                        $("#msgArea").append(userinfo);
                    }
                }
                indata[infoIndex] = info;
            });
            var stringdat = JSON.stringify(indata);
            storage.setItem('userinfo_data', stringdat);
            // set session
        }
    }

    /**
     * @param data 要录入的json str
     * @returns {*} bool and obj
     */
    function setJson(data = null, uid = null) {

        var sum_obj = null;
        var obj_str = null;


        var userinfo_data = storage.getItem('userinfo_data');
        var dacc = data;

        // 如果存在准备录入合并
        if (data != null && userinfo_data !== "" && userinfo_data != "null" && userinfo_data != null && userinfo_data != {} && userinfo_data != "[object JSON]") {
            //storage.setItem('userinfo_data', null);

            var receive_info = JSON.parse(userinfo_data);
            var send_dat = {'pact': 'intopic', 'data': {"history_receive_info": receive_info, "receive_info": data}};
            var indata = JSON.stringify(send_dat);
            ws.send(indata);
            /* //var sum_obj = extend({}, [userinfo_obj, data]);

             var sum_obj = extend({}, [userinfo_obj, data]);
             var in_sum_data = JSON.stringify(sum_obj);

             storage.setItem('userinfo_data', in_sum_data);
             return storage.getItem('userinfo_data');*/

        } else if (data != null && (userinfo_data === "" || userinfo_data === null || userinfo_data === {} || userinfo_data == "[object JSON]")) {

            var in_str_data = JSON.stringify(data);
            storage.setItem('userinfo_data', in_str_data);
            return data;
        }
        return false;
    }

    /****
     *
     * @param data 要录入的json str
     * @returns {*}
     */
    function getJson() {

        var userinfo_data = storage.getItem('userinfo_data');
        if (userinfo_data !== "" && userinfo_data != null && userinfo_data != {} && userinfo_data != "[object JSON]") {
            return userinfo_data;
        }
    }

    function close_session(key = null) {

        var sessiontor = window.sessionStorage;
        if (key && key != null) {
            var msg = sessiontor.getItem(key);

            var d = sessiontor.removeItem(msg);
            if (d) {
                alert('清理成功' + key);
                return;
            }
            alert('清理失败' + key);
        }
    }

    function concat(jsonbject1, jsonbject2) {

        var resultJsonObject = {};
        for (var attr in jsonbject1) {
            resultJsonObject[attr] = jsonbject1[attr];
        }
        for (var attr in jsonbject2) {
            resultJsonObject[attr] = jsonbject2[attr];
        }
        return resultJsonObject;
    }

    /**
     *
     * @param old_data
     * @param now_data
     * @constructor
     */
    function InServerTopicInfo(old_data, now_data) {
        $.ajax({
            type: 'POST',
            url: '/active/loadserver',
            dataType: 'json',
            success: function (result) {
                if (result.errcode == 0) {
                    var zTree;
                    $.fn.zTree.init($("#tree"), setting, result.msg);
                    zTree = $.fn.zTree.getZTreeObj("tree");
                    zTree.expandAll(true);
                }
            }
        });
    }

</script>
