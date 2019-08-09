<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26 0026
 * Time: 下午 6:28
 */
class  ChataSer extends Mysqldb
{
    private static $mysql;
    public $redis = null;
    private static $appid = null;
    protected $game_db_name = 'gank_activites';
    protected $redis_prefix = 'gank_wechat_activites';
    protected $activity_reward_table = 'app_user_reward';
    protected $redis_prize_key = null;
    protected static $activity_user_table = null;
    protected static $activity_prize_dbname = 'wechat_prize_config';
    protected $login_table = 'receivelogin';
    protected static $consignee_table = 'wechat_user_consignee';
    protected static $virtual_item_prize_table = 'wechat_virtual_item_prize';
    protected static $table = 'tb_user';
    public static $prize_info = null;
    protected static $wechat_stat_lottery_tab = 'wechat_stat_lottery_info';
    protected static $wechat_stat_webclick_tab = 'wechat_stat_web_click';
    const LIMIT_ONE = 1;
    const K_EXPICE_TIME = 3600;

    #----------------
    protected $user_table = "tb_user";
    protected static $friend_table = "tb_friendid";
    protected static $tb_topic_table = "tb_topic";

    function __construct()
    {
        self::$mysql = new Mysqldb();
        //$this->redis = new Xredis();
    }

    //登录获取
    public function getdbCharUserInfo($account, $password)
    {
        $sql = "SELECT * FROM tb_user WHERE account='" . $account . "' AND password='" . $password . "'   limit 1 ";

        if (self::$mysql->query($sql)) {
            return self::$mysql->fetch_row();
        }
        return false;

    }

    public function getByIdUserinfo($id)
    {

        $sql = "SELECT * FROM tb_user WHERE id='" . $id . "'   limit 1 ";

        if (self::$mysql->query($sql)) {
            return self::$mysql->fetch_row();
        }
        return false;
    }

    public function addUserInfo($data)
    {

        if (!self::$mysql->insert($this->user_table, $data)) {
            log_message::info('insert indo db saveuserinfo false');
            return false;
        }
        return true;
    }

    /***
     * 添加缓存消息
     * @param $data
     * @return bool
     */
    public function addTopitInfo($data)
    {
        if (!self::$mysql->insert(self::$tb_topic_table, $data)) {
            log_message::info('insert indo db tb_topic_table false');
            return false;
        }
        return true;
    }

    /***
     *
     * 更新用户信息
     */
    public function setUser($id, $applydata)
    {
        $res = self::$mysql->update2($this->user_table, $applydata, 'id=:id', array('id' => $id));

        if ($res) {

            return true;
        }
        log_message::info("用户变更false");
        return false;
    }

    /***
     *
     * 退出更新用户信息
     */
    public function setFdUser($fd, $applydata)
    {
        $res = self::$mysql->update2($this->user_table, $applydata, 'fd=:fd', array('fd' => $fd));

        if ($res) {

            return true;
        }
        log_message::info("用户变更false");
        return false;
    }
    /***
     * 更新用户管道
     */

    /***
     * Save Userinfo
     * @param $data ['openid']
     * @return array|bool|mixed|null
     */
    public function saveCharUserInfo($data)
    {
        //$openid = isset($data['openid']) ? $data['openid'] : ZERO;
        $account = isset($data['account']) ? $data['account'] : ZERO;
        $password = isset($data['password']) ? $data['password'] : ZERO;
        $db_user_info = $this->getdbCharUserInfo($account, $password);

        // 如果db 也不存在那么 cache 与 redis 都有进行录入set
        if (empty($db_user_info)) {
            // 没有该账户
            // 这个时候注意参数 $data 是客户端新用户第一次进来初始的参数
            /* if (!self::$mysql->insert(self::$table, $data)) {
                 log_message::info('insert indo db saveuserinfo false');
             }
             $data['status'] = ONE;
             return $data;*/
            // 如果不存在或者密码不正确则进行提示
            // 缓存后期进行添加
            return false;
        }
        // 更新fd
        log_message::info("db user info id ", $db_user_info['id']);

        if (!$this->setUser($db_user_info['id'], $data)) {
            //
            log_message::info('user edit is false');
        }

        $db_user_info['status'] = TWO;
        // 存在账户
        return $db_user_info;
    }

    /***
     * add user
     */
    public function addFriend($data)
    {
        if (!self::$mysql->insert(self::$friend_table, $data)) {
            log_message::info('insert addFriend db addFriend false');
            return false;
        }
        return true;
    }

    /***
     * 好友列表
     */
    public function friendidInfo($uid)
    {

        $sql = "SELECT * FROM tb_user WHERE id in (SELECT friendid FROM tb_friendid WHERE uid='" . $uid . "')";

        if (self::$mysql->query($sql)) {
            return self::$mysql->fetch_all();
        }
        return false;
    }

    /***
     * 好友状态变更  1-申请中 2-已拒绝 3-已接收 4已拉黑
     * $applydata = ['apply_status' => $apply_status]
     */
    public function setFriendid($uid, $applydata)
    {
        $res = self::$mysql->update2(self::$friend_table, $applydata, 'uid=:uid', array('uid' => $uid));
        if ($res) {

            return true;
        }
        log_message::info("好友变更false");
        return false;
    }

    /**
     * 发送消息内容
     */
    public function addusersendMessage($data)
    {

        if (!self::$mysql->insert(self::$tb_topic_table, $data)) {
            log_message::info('insert addFriend db addFriend false');
            return false;
        }
        return true;
    }

    /***
     * 登录轮训缓存消息
     * @param $uid
     */
    public function usersendMessageinfo($uid)
    {
        $sql = "SELECT * FROM " . self::$tb_topic_table . " WHERE receiveuid='" . $uid . "'";

        if (self::$mysql->query($sql)) {
            return self::$mysql->fetch_all();
        }
        return false;
    }

    /***
     * 更改消息状态
     */
    public function setUserMessageStatus($message_status, $id)
    {
        $res = self::$mysql->update2(self::$tb_topic_table, ['message_status' => $message_status], 'id=:id', array('id' => $id));
        if ($res) {
            return true;
        }
        log_message::info("update  message status false");
        return false;
    }


}