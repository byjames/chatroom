<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-11
 * Time: 下午 06:19
 */
class ChatModel
{

    public $roole_name = null;
    public $roole_password = null;
    public $roole_type = null;
    public $request = null;
    public $time = null;

    protected $uid = null;
    protected static $config = null;

    private $user_info = null;
    private $utils = null;
    private $service = null;

    //
    private static $pact = null;
    private static $clien_data = null;

    private $swoole = null;
    private $clien_fd = null;
    private $message = null;
    private $friendid_info = null;

    public function __construct($swoole_server = null, $fd = null, $data = null)
    {
        log_message::info("++++++++++++++++++ fd", $fd);
        $this->utils = new Utils();
        $this->service = new ChataSer();
        $this->time = date('Y-m-d H:i:s', time());
        $this->swoole = $swoole_server;
        $this->clien_fd = $fd;
        log_message::info("+++++++++++++++++++ clien_info", $data);
        $this->message = Utils::decodeDate($data);

        self::$pact = self::isParame($this->message, 'pact');
        self::$clien_data = self::isParame($this->message, 'data');

        log_message::info("++++++++++++++++++ pact", self::$pact);
        log_message::info("++++++++++++++++++ clien_data", self::$clien_data);

        self::$config = Utils::config();
        log_message::info("++++++++++++++++++config", json_encode(self::$config));
        $pact_action = $this->IsPact();
        log_message::info("++++++++++++++++++ pact_action ", $pact_action);
        if (method_exists('ChatModel', $pact_action)) {
            log_message::info("++++++++++++++++++", $pact_action);
            return $this->$pact_action();
        } else {

            log_message::info("++++++++++++++++++ pact_action is function false", $pact_action);
        }
    }

    /***
     * 初始基础配置数据
     * @return bool
     */
    public function httpData($type = null)
    {

        //$request = file_get_contents("php://input");

        /* $this->request = $_REQUEST;
         log_message::info(json_encode($_REQUEST));
         $this->roole_name = self::isParame($_REQUEST, 'account');
         $this->roole_password = self::isParame($_REQUEST, 'paw');
         $this->roole_type = self::isParame($_REQUEST, 'type');*/
    }

    public function friendInfo()
    {
        $uid = self::$clien_data['id'];

        $res = $this->service->friendidInfo($uid);
        if ($res) {
            return Utils::errorCode($res, SUCCESS);
        }
        return Utils::errorCode('好友列表空');
    }

    /***
     * 登录
     */
    public function login()
    {
        log_message::info("~~~~~~~~~~~~~~~~  is login");
        $account = self::$clien_data['account'];
        $password = self::$clien_data['password'];
        if (isDatas($account) && isDatas($password)) {
            log_message::info("~~~~~~~~~~~~~~~~  is login and account a pass is ok");
            $time = date('Y-m-d H:i:s', time());

            $data = [
                'account' => $account,
                'nick_name' => $account,
                'password' => $password,
                'creat_at' => $time,
                'login_at' => $time,
                'fd' => $this->clien_fd,
                'status' => ONE,
            ];

            $this->user_info = $this->service->saveCharUserInfo($data);
            if (isDatas($this->user_info)) {
                // 获取好友列表信息
                //
                $this->user_info['friendinfo'] = $this->service->friendidInfo($this->user_info['id']);

                log_message::info(Utils::errorCode($this->user_info, SUCCESS, 'login'));

                return $this->swoole_pull(Utils::errorCode($this->user_info, SUCCESS, 'login'));
            }
        }
        log_message::info("账号密码错误！");
        $this->swoole_pull(Utils::errorCode("账号密码错误"));
        return false;
    }

    public function intopic()
    {
        //{'pact': 'intopic', 'data': {"history_receive_info": receive_info, "receive_info": data}};
        $recive_dat = self::$clien_data['receive_info'];
        $history_recive_dat = self::$clien_data['history_receive_info'];
        log_message::info("intopic******recive_dat*************", $recive_dat);
        log_message::info("intopic******history_recive_dat*************", $history_recive_dat);

        echo "-------------------------" . "<br>";
        //$recive_dat = json_decode($recive_dat, true);

        //$history_recive_dat = json_decode   ($history_recive_dat, true);
        $sumdata = null;

        $history_recive = isDatas($history_recive_dat) ? $history_recive_dat : $recive_dat;

        $dim = Utils::arrayDimension($history_recive);
        log_message::info("intopic dim**********", $dim);
        if ($dim == ONE) {
            $sumdata[] = $history_recive;
            $sumdata[] = $recive_dat;
            $indata = json_encode($sumdata, JSON_UNESCAPED_UNICODE);
            log_message::info("[][][][][][][]intopic dim**********", $dim, $indata);
            return $this->swoole_pull(Utils::errorCode($indata, SUCCESS, 'intopic'));
        }

        if ($dim == TWO) {
            //$sumdata = array_push($history_recive_dat, $recive_dat);
            $history_recive_dat[time()] = $recive_dat;
            $sumdata = $history_recive_dat;
            $indata = json_encode($sumdata, JSON_UNESCAPED_UNICODE);
            log_message::info("[][][][][][][]intopic*************dim", $dim, $indata);
            return $this->swoole_pull(Utils::errorCode($indata, SUCCESS, 'intopic'));
        }
        return $this->swoole_pull(Utils::errorCode('msg data is null', SUCCESS, 'intopic'));
    }

    public function sende_message()
    {
        //data = {"pact": "sende_message", "data": {"msg": msg, "friendid": friendid, "user_id": userid}};

        $uid = self::$clien_data['user_id'];
        // 接收者id
        $friendid = self::$clien_data['friendid'];
        $info = self::$clien_data['msg'];
        $this->user_info = $this->service->getByIdUserinfo($uid);
        // 接收者信息
        $this->friendid_info = $this->service->getByIdUserinfo($friendid);
        $friendid_info_fd = $this->friendid_info['fd'];
        if ($friendid_info_fd) {
            // 中心根据接收者
            // 当返回数据的时候好友的相关角色就互换了
            // 接收者就成了自己
            // 发消息的就成了推送者 及 friend_info
            $data = [
                'friend_info' => $this->user_info, //
                'user_info' => $this->friendid_info,
                'info' => $info

            ];
            $data = Utils::errorCode($data, SUCCESS, 'sende_message');
            // 如果接收者不在线那么存储到数据缓存等到上线的时候进行推送给他
            if ($this->friendid_info['status'] == ZERO) {

                $topic_data = [
                    'receiveuid' => $friendid,
                    'senduid' => $uid,
                    'send_user_name' => $this->user_info['nick_name'],
                    'message_status' => ZERO,
                    'message' => $info,
                    'send_at' => $this->time
                ];
                $res = $this->service->addTopitInfo($topic_data);
                if (!$res) {
                    log_message::info("发送消息失败！");
                    $this->swoole_pull(Utils::errorCode("发送消息失败！"));
                }
            }
            $this->swoole->push($friendid_info_fd, $data);
        }
        // data = {"pact": "sende_message", "data": {"msg": msg, "friendid": friendid, "user_id": userid}};
    }

    public function index($pact)
    {
        switch ($pact) {
            case 'login' :
                $this->login();
                break;
            default:
                break;
        }

    }

    /**
     * 退出
     */
    public function quit()
    {
        $this->clien_fd;
        $res = $this->service->setFdUser($this->clien_fd, ['status' => ZERO]);
        if ($res) {
            // 推送用户已经退出了
            log_message::info("退出状态更新成功");
            log_message::info("quit 已经退出了");
        } else {
            log_message::info("退出状态更新失败");
        }

    }

    /***
     * 注册
     * @return bool
     */
    public function registered()
    {

        $account = self::$clien_data['account'];
        $password = self::$clien_data['password'];
        if (isDatas($account) && isDatas($password)) {
            $time = date('Y-m-d H:i:s', time());

            $data = [
                'nick_name' => $account,
                'password' => $password,
                'creat_at' => $time,
                'login_at' => $time,
                'fd' => $this->clien_fd,
            ];

            $req = $this->service->addUserInfo($data);
            if ($req) {
                return true;
            }
            return false;
        }
        $this->swoole_pull(Utils::errorCode("账号密码为空"));
        return false;
    }

    /***
     * pact解码
     */
    public function IsPact()
    {
        if (self::isParame($this->message, 'pact')) {
            log_message::info("IsPact isParame 11");
            // 是否存在协议
            log_message::info("IsPact message 1110", $this->message['pact']);
            if ($this->isAction($this->message['pact'])) {
                log_message::info("IsPact isParame 22");
                return $this->message['pact'];
            }
        }
        log_message::info(Utils::errorCode('协议异常', FAILURE));

        $this->swoole_pull(Utils::errorCode('协议异常', FAILURE));

        return false;
    }

    public function isAction($pact)
    {
        log_message::info("isAction", json_encode(self::$config['server_pact']));

        log_message::info("isAction22", self::isParame(self::$config['server_pact'], $pact));

        if (in_array($pact, self::$config['server_pact'])) {

            return $pact;
        }
        return false;
    }

    public function swoole_pull($data)
    {
        $this->swoole->push($this->clien_fd, $data);
    }

    /***
     * 参数是否为空
     * @param $data
     * @return bool
     */
    public static function isParame($data, $key)
    {
        if ($red = isDatas($data, $key)) {
            return $red;
        }
        log_message::info("$key is null ");
        //exit(Utils::sendResults("$key is null"));
        //exit(Utils::errorCode("$key is null ", FAILURE));
        return null;
    }

    public function parameVerif()
    {
        if (isBlank($this->roole_name)) {
            log_message::info('roole_name is null');
            exit(Utils::sendResults("roole_name is null "));
        }
        if (isBlank($this->roole_password)) {
            log_message::info('roole_password is null');
            exit(Utils::sendResults("roole_password is null "));
        }
        $_SESSION['account'] = $this->roole_name;
        $_SESSION['password'] = $this->roole_password;
        $_SESSION['type'] = $this->roole_type;
        return true;
    }

    /***
     * 添加好友
     */
    public function addFriend()
    {

    }

    /***
     *
     */
    public function userVerif()
    {
        // 获取服务端用户密码
        // 正确返回true 跳转登录界面
        // else false 提示失败
        $this->initializeUserinfo();
        return $this->verifAccount();
    }

    /***
     * @param array $userdata
     * @return bool
     */
    public function initializeUserinfo($userdata = [])
    {

        $data = [
            'nick_name' => $this->roole_name,
            'account' => $this->roole_name,
            'password' => $this->roole_password,
            'creat_at' => date('Ymd', time()),
            'type' => $this->roole_type
            //'sign_rule'=>$ruleinfo,
        ];
        $data = isDatas($userdata) ? $userdata : $data;

        $this->user_info = $this->service->saveCharUserInfo($data);
        // 如果type 是注册 但是已经存在用户或者 空的进行注册 返回注册成功 二类 返回已经存在用户
        // 如果type 是登录 但是
        // 最好是分开设置注册就是注册的函数 登录就是登录的函数 每次只要

        if ($this->user_info) {
            return $this->user_info;
        }
        return Utils::sendResults("获取信息失败");
    }

    public function verifAccount()
    {
        $roole_name = $this->roole_name;
        $roole_password = $this->roole_password;
        if ($roole_name = $this->user_info['account'] && $roole_password == $this->user_info['password']) {
            log_message::info(Utils::sendResults('ok...', $this->user_info));
            return Utils::sendResults('ok', $this->user_info);;
        }
        return false;
    }

    public function userLogin()
    {
        $db_user_info = $this->service->getdbCharUserInfo($this->roole_name);
        $this->uid = $db_user_info['id'];
        $this->user_info = $db_user_info;
        $roole_name = $this->roole_name;
        $roole_password = $this->roole_password;
        if ($roole_name = $db_user_info['account'] && $roole_password == $db_user_info['password']) {
            return Utils::sendResults('登录成功', $this->user_info, SUCCESS);
        }
        return Utils::sendResults('账号或密码错误！', $this->user_info, FAILURE);;
    }

    public function friendList()
    {

        $this->service->friendidInfo($this->uid);
    }
    //~

}