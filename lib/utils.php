<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/26 0026
 * Time: 下午 3:24
 */
class  Utils
{
    public $timelist;
    public $timearray;
    private $day = 1;
    private $datatamp = 86400;
    private $signvar = 1;

    public function __construct()
    {
        unset($this->timelist);
        unset($this->timearray);
        $this->GetDayList();
    }

    public function GetDayList()
    {
        $totalDay = date("t");

        //获取本月第一天时间戳
        $start_time = strtotime(date('Y-m-01'));

        $array = array();

        for ($i = 0; $i < $totalDay; $i++) {
            //每隔一天赋值给数组
            $array[] = date('Ymd', $start_time + $i * $this->datatamp);
        }
        $this->timearray = $array;
        return $array;
    }

    /***
     * 活动 data info
     * @param null $array
     * @return bool
     */
    public function SetDay($array = null)
    {
        $array = (isset($array) && !empty($array)) ? $array : $this->timearray;

        if (empty($array) || count($array) <= ZERO) {
            return false;
        }

        $i = $this->day;

        foreach ($array as $times) {

            $data[$i] = array
            (
                'day' => $times,
            );
            $i++;
        }
        return ['sign' => $data];
    }

    /***
     * 设置 sign
     * @param string $time
     * @return array
     */
    public function SetSignDay($data = array(), $time = '20180902')
    {
        // $data = $this->SetDay();

        $dataOut = [];

        foreach ($data['sign'] as $key => $var) {

            if ($var['day'] == $time) {

                $var['sign'] = $this->signvar;
            }
            $dataOut[$key] = $var;
        }
        return ['sign' => $dataOut];
    }

    public function SetMesage($data, $mesage, $code = ZERO)
    {
        $ret = ($code == ZERO) ? 'success' : 'failure';

        if (isset($data) && count($data) > ZERO) {

            $data['ret'] = $ret;
            $data['msg'] = $mesage;
            $data['login'] = true;
        }
        return $data;
    }

    public function GetdefaultConfig()
    {
        $data = $this->SetDay();
        $data['ret'] = 'success';
        $data['msg'] = 'default day list ';
        $data['login'] = true;
        return $data;
    }

    /***
     * 礼包规则配置 获奖励规则
     */
    public function isGiftDay()
    {

    }

    /***
     * Json 生成规则
     */
    public function ActivityConfig($pc = null, $channel = null)
    {
        $Acitvity = [
            'pc' => $pc,
            'channel' => $channel
        ];
        // $dd = json_encode($Acitvity);
    }

    /**
     * 是不是简单基础类型(null, boolean , string, numeric)
     * @param $object
     * @return bool
     */
    function isPrimary($object)
    {
        return is_null($object) || is_bool($object) || is_string($object) || is_numeric($object);
    }

    function isBlank($object)
    {
        if (is_null($object) || '' === $object || (is_array($object) && count($object) < 1)) {
            return true;
        }
        return empty($object);
    }

    /***
     * @param $json_config_name
     * @return bool|mixed
     */
    function getFileConfig($file_name)
    {
        log_message::info(RES_CONFIG_URL . DIR_SEPARATOR . 'res/config/' . $file_name);
        if ($headers = get_headers(RES_CONFIG_URL . DIR_SEPARATOR . 'res/config/' . $file_name)) {
            if (strpos($headers[ZERO], '404') === false) {
                $url = RES_CONFIG_URL . DIR_SEPARATOR . 'res/config/' . $file_name;
                $pagecontent = trim(file_get_contents($url));

                if (!isBlank($pagecontent)) // runtime
                {
                    return json_decode($pagecontent, true);
                }
                log_message::info('open url json data null');
                return false;
            }
            log_message::info('open url json false');
            return false;
        }
        log_message::info('json url false');
        return false;
    }

    /***
     * 区服区间验证
     */
    public function serverVerif($role_sid, $min_sid, $max_sid)
    {
        if (($role_sid >= $min_sid) && ($role_sid <= $max_sid)) {
            return true;
        }
        log_message::info('user sid 区间有误');
        return false;
    }

    /***
     * @param $url
     * @param $data
     * @param string $coding
     * @param string $refererUrl
     * @param string $method
     * @param string $contentType
     * @param int $timeout
     * @param bool $proxy
     * @return bool|null|string
     */
    public static function send_request($url, $data, $coding = 'gbk', $refererUrl = '',
                                        $method = 'POST', $contentType = 'application/json;', $timeout = 30, $proxy = false)
    {
        $ch = $responseData = null;
        //$data = trim(mb_convert_encoding($data, "gbk", "utf-8"));
        if ('POST' === strtoupper($method)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $info = curl_getinfo($ch);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
            $contentType = '';
            if ($contentType) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $contentType);
            }
            if (isset($data['upload_file'])) {
                $file = new \CURLFile($data['upload_file']['file'],
                    $data['upload_file']['type'], $data['upload_file']['name']);
                $params[$data['upload_file']['get_name']] = $file;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            }
        } else if ('GET' === strtoupper($method)) {
            if (is_string($data)) {
                $real_url = $url . rawurlencode($data);
            } else {
                $real_url = $url . http_build_query($data);
            }

            //$urldata = rawurlencode($data);
            $ch = curl_init($real_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:' . $contentType]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($refererUrl) {
                curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
            }
        } else {
            $args = func_get_args();
            return false;
        }
        if ($proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $ret = curl_exec($ch);
        curl_close($ch);
        $responseData = $ret;
        //$responseData = mb_convert_encoding($ret, "utf-8", "gbk");
        return $responseData;
    }

    /**
     * @param $messige
     * @param null $status
     * @param null $pact
     * @return false|string
     */
    public static function errorCode($messige, $status = null, $pact = null)
    {
        if (!isDatas($messige)) {
            $status = isDatas($status) ? $status : FAILURE;
        }
        $data = array(
            'msg' => $messige,
            'status' => $status,
            'pact' => $pact,
        );

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /***
     * @param $messige
     * @param array $result_dat
     * @param null $status
     * @return false|string
     */
    public static function sendResults($messige, $result_dat = null, $status = null)
    {
        $status = !isDatas($status) ? $status : FAILURE;

        $data = array(
            'msg' => $messige,
            'result' => $status,
            'val' => null
        );
        $result_dat = is_string($result_dat) ? json_decode($result_dat, true) : $result_dat;

        if (is_array($result_dat)) {
            $data = array_merge($data, $result_dat);
        }
        return json_encode($data, JSON_UNESCAPED_UNICODE);
        //return $data;
    }

    /***
     * @param $tag
     * @return bool
     */
    public static function config($tag = null, $var = null)
    {
        $url = require "config.php";

        if (isset($url[$tag]) && !empty($url[$tag])) {

            return !empty($var) ? $url[$tag][$var] : $url[$tag];
        }
        log_message::info('configs key is null ');
        return $url;
    }

    /***
     * @param $data
     * @return mixed|null
     */
    public static function decodeDate($data)
    {
        if (isDatas($data)) {
            if (is_array($data) && count($data) > ZERO) {
                return $data;
            }
            return json_decode($data, true);
        }
        log_message::info('decode date is null');
        return null;
    }

    /***
     * @param $proArr
     * @return int|string
     */
    public static function getPrizeRand($proArr)
    {
        log_message::info("&&&&&&&&&&&&++", json_encode($proArr, JSON_UNESCAPED_UNICODE));
        $result = null;

        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        // 修改 key 则需要修改这里的取值范围

        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(ONE, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }

        unset ($proArr);
        return $result;
    }

    public static function prizeAssembly($proArr)
    {
        $data = [];
        if (isDatas($proArr)) {
            foreach ($proArr as $key => $proCur) {
                $data[$proCur['prize_id']] = json_encode($proCur, JSON_UNESCAPED_UNICODE);
            }
            return $data;
        }
        return false;
    }

    /***
     * 干预判断 如果 不是无限制的类型并且 game 上限大于或等于用户已抽取的次数
     * 表示已经达到上限符合干预条件需要系统重新随机奖品
     * @param $role_upper_limit
     * @param $game_upper_limit
     * @return bool
     */
    public static function isUpperlimit($role_upper_limit, $game_upper_limit)
    {
        if (($game_upper_limit != ZERO && $game_upper_limit >= $role_upper_limit)) {
            return true;
        }
        return false;
    }

    /****
     * 判断有效范围内可增加抽取次数并返回客户端
     * @param $role_upper_limit
     * @param $game_upper_limit
     * @return bool
     */
    public static function isNayUpperLimit($role_upper_limit, $game_upper_limit)
    {
        if (($game_upper_limit != ZERO && $role_upper_limit > $game_upper_limit) || $game_upper_limit == ZERO) {
            return true;
        }
        return false;
    }

    /***
     * @param $data_at
     * @return array
     */
    public static function successiveTime($data_at)
    {
        sort($data_at);
        $data = [];
        for ($i = 1; $i < count($data_at); $i++) {
            $lastone = strtotime($data_at[$i - 1]);
            $thisone = strtotime($data_at[$i]);
            if ($thisone - $lastone != 3600 * 24) {
                $data = [];
            } else {
                $data[] = date('Y-m-d', $thisone);
            }
        }
        return $data;
    }

    // 二维数组按指定的键值排序 $reque_data_out, "power", "desc", HUNDRED
    public static function array_sort($array, $keys, $type = 'asc', $limit = null, $dimen = TWO)
    {
        if (!is_array($array) || empty($array) || !in_array(strtolower($type), array('asc', 'desc'))) return '';
        $keysvalue = array();

        foreach ($array as $key => $val) {
            $val[$keys] = str_replace('-', '', $val[$keys]);
            $val[$keys] = str_replace(' ', '', $val[$keys]);
            $val[$keys] = str_replace(':', '', $val[$keys]);
            $keysvalue[] = $val[$keys];
        }

        asort($keysvalue);//key值排序
        reset($keysvalue);//指针重新指向数组第一个
        foreach ($keysvalue as $key => $vals) {
            $keysort[] = $key;
        }
        $keysvalue = array();
        $count = count($keysort);
        if (strtolower($type) != 'asc') {
            for ($i = $count - 1; $i >= 0; $i--) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        } else {
            for ($i = 0; $i < $count; $i++) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        }
        if (!empty($limit)) {
            array_slice($keysvalue, ZERO, $limit);
        }
        return $keysvalue;
    }

    /***
     * @param $filepatch
     * @param $filename
     * @param $string
     * @return bool
     */
    public static function mkdirFile($filepatch, $filename, $string)
    {
        if (is_array($string)) {
            $string = json_encode($string, JSON_UNESCAPED_UNICODE);
        }
        if (file_exists($filepatch)) {

            $myfile = fopen($filepatch . $filename, "w");
            fwrite($myfile, $string);
            return true;
        }
        log_message::info('mkdir file false...');
        return false;
    }

    /***
     * @param array $data
     * @return bool|null
     */
    public static function prizeFormat($data = [])
    {
        $cache_data = null;

        sort($data);
        foreach ($data as $val) {
            $cache_data[$val['prize_id']] = $val;
        }
        if (isDatas($cache_data)) {
            return $cache_data;
        }
        return false;
    }

    /**
     * 组发消息
     */
    public static function senFormatData($pact = ZERO, $data = array())
    {
        $package = array(
            'pact' => $pact,
            'data' => $data
        );
        $string = json_encode($package, JSON_UNESCAPED_UNICODE);
        log_message::info($string);
        return $string;
    }

    /***
     *
     */
    public static function encodeData($string, $fd)
    {


    }

    /***
     * 数组维度判断
     */
    public statiC function arrayDimension($array)
    {
        if (isDatas($array)) {
            log_message::info('arrayDimension is days ');
            if (count($array) == count($array, ONE)) {
                log_message::info('arrayDimension is daysq1 ');
                return ONE;
            } else {
                log_message::info('arrayDimension is daysq 2 ');
                return TWO;
            }
        }
        log_message::info('arrayDimension is daysq 000 ');
        return ZERO;
    }
}