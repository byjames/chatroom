<?php
set_time_limit(0);
ini_set('mysql.connect_timeout', 30000);
ini_set('default_socket_timeout', 30000);
require "autoload.php";
global $mysql;
$mysql = new mysqldb();
/*id
uid
nick_name
creat_at
login_at
channelid
channename
*/
$rand_at = [
    '2019-01-03',
    '2019-01-04',
    '2019-01-05',
    '2019-01-06',
    '2019-01-07',
    '2019-01-08',
    '2019-01-09',
    '2019-01-10',
    '2019-01-11',
    '2019-01-12',
    '2019-01-13',
    '2019-01-14',
    '2019-01-15',
    '2019-01-16',
    '2019-01-17',
    '2019-01-18',
    '2019-01-19',
    '2019-01-20',
    '2019-01-21',
    '2019-01-22',
    '2019-01-23',
    '2019-01-24',
    '2019-01-25',
    '2019-01-26',
    '2019-01-27',
    '2019-01-28',
    '2019-01-29',
    '2019-01-30',
    '2019-01-31',
    '2019-02-01',
    '2019-02-02',
    '2019-02-03',
    '2019-02-04',
    '2019-02-05',
    '2019-02-06',
    '2019-02-07',
    '2019-02-08',
    '2019-02-09',
    '2019-02-10',
    '2019-02-11',
    '2019-02-12',
    '2019-02-13',
    '2019-02-14',
    '2019-02-15',
    '2019-02-16',
    '2019-02-17',
    '2019-02-18',
    '2019-02-19',
    '2019-02-20',
    '2019-02-21',
    '2019-02-22',
    '2019-02-23',
    '2019-02-24',
    '2019-02-25',
    '2019-02-26',
    '2019-02-27',
    '2019-02-28',
    '2019-03-01',
    '2019-03-02',
    '2019-03-03',
    '2019-03-04',
    '2019-03-05',
    '2019-03-06',
    '2019-03-07',
    '2019-03-08',
    '2019-03-09',
    '2019-03-10',
    '2019-03-11',
    '2019-03-12',
    '2019-03-13',
    '2019-03-14',
    '2019-03-15',
    '2019-03-16',
    '2019-03-17',
    '2019-03-18',
    '2019-03-19',
    '2019-03-20',
    '2019-03-21',
    '2019-03-22',
    '2019-03-23',
    '2019-03-24',
    '2019-03-25',
    '2019-03-26',
    '2019-03-27',
    '2019-03-28',
    '2019-03-29',
    '2019-03-30',
    '2019-03-31',
    '2019-04-01',
    '2019-04-02',
    '2019-04-03',
    '2019-04-04',
    '2019-04-05',
    '2019-04-06',
    '2019-04-07',
    '2019-04-08',
    '2019-04-09',
    '2019-04-10',
    '2019-04-11',
    '2019-04-12',
    '2019-04-13',
    '2019-04-14',
    '2019-04-15',
    '2019-04-16',
    '2019-04-17',
    '2019-04-18',
    '2019-04-19',
    '2019-04-20',
    '2019-04-21',
    '2019-04-22',
    '2019-04-23',
    '2019-04-24',
    '2019-04-25',
    '2019-04-26',
    '2019-04-27',
    '2019-04-28',
    '2019-04-29',
    '2019-04-30',
    '2019-05-01',
    '2019-05-02',
    '2019-05-03',
    '2019-05-04',
    '2019-05-05',
    '2019-05-06',
    '2019-05-07',
    '2019-05-08',
    '2019-05-09',
    '2019-05-10',
    '2019-05-11',
    '2019-05-12',
    '2019-05-13',
    '2019-05-14',
    '2019-05-15',
    '2019-05-16',
    '2019-05-17',
    '2019-05-18',
    '2019-05-19',
    '2019-05-20',
    '2019-05-21',
    '2019-05-22',
    '2019-05-23',
    '2019-05-24',
    '2019-05-25',
    '2019-05-26',
    '2019-05-27',
    '2019-05-28',
    '2019-05-29',
    '2019-05-30',
    '2019-05-31',
    '2019-06-01',
    '2019-06-02',
    '2019-06-03',
    '2019-06-04',
    '2019-06-05',
    '2019-06-06',
    '2019-06-07',
    '2019-06-08',
    '2019-06-09',
    '2019-06-10',
    '2019-06-11',
    '2019-06-12',
    '2019-06-13',
    '2019-06-14',
    '2019-06-15',
    '2019-06-16',
    '2019-06-17',
    '2019-06-18',
    '2019-06-19',
    '2019-06-20',
    '2019-06-21',
    '2019-06-22',
    '2019-06-23',
    '2019-06-24',
    '2019-06-25',
    '2019-06-26',
    '2019-06-27',
    '2019-06-28',
    '2019-06-29',
    '2019-06-30',
    '2019-07-01',
    '2019-07-02',
    '2019-07-03',
    '2019-07-04',
    '2019-07-05',
    '2019-07-06',
    '2019-07-07',
    '2019-07-08',
    '2019-07-09',
    '2019-07-10'
];
$nicheng_tou = array('快乐的', '冷静的', '醉熏的', '潇洒的', '糊涂的', '积极的', '冷酷的', '深情的', '粗暴的', '温柔的', '可爱的', '愉快的', '义气的', '认真的', '威武的', '帅气的', '传统的', '潇洒的', '漂亮的', '自然的', '专一的', '听话的', '昏睡的', '狂野的', '等待的', '搞怪的', '幽默的', '魁梧的', '活泼的', '开心的', '高兴的', '超帅的', '留胡子的', '坦率的', '直率的', '轻松的', '痴情的', '完美的', '精明的', '无聊的', '有魅力的', '丰富的', '繁荣的', '饱满的', '炙热的', '暴躁的', '碧蓝的', '俊逸的', '英勇的', '健忘的', '故意的', '无心的', '土豪的', '朴实的', '兴奋的', '幸福的', '淡定的', '不安的', '阔达的', '孤独的', '独特的', '疯狂的', '时尚的', '落后的', '风趣的', '忧伤的', '大胆的', '爱笑的', '矮小的', '健康的', '合适的', '玩命的', '沉默的', '斯文的', '香蕉', '苹果', '鲤鱼', '鳗鱼', '任性的', '细心的', '粗心的', '大意的', '甜甜的', '酷酷的', '健壮的', '英俊的', '霸气的', '阳光的', '默默的', '大力的', '孝顺的', '忧虑的', '着急的', '紧张的', '善良的', '凶狠的', '害怕的', '重要的', '危机的', '欢喜的', '欣慰的', '满意的', '跳跃的', '诚心的', '称心的', '如意的', '怡然的', '娇气的', '无奈的', '无语的', '激动的', '愤怒的', '美好的', '感动的', '激情的', '激昂的', '震动的', '虚拟的', '超级的', '寒冷的', '精明的', '明理的', '犹豫的', '忧郁的', '寂寞的', '奋斗的', '勤奋的', '现代的', '过时的', '稳重的', '热情的', '含蓄的', '开放的', '无辜的', '多情的', '纯真的', '拉长的', '热心的', '从容的', '体贴的', '风中的', '曾经的', '追寻的', '儒雅的', '优雅的', '开朗的', '外向的', '内向的', '清爽的', '文艺的', '长情的', '平常的', '单身的', '伶俐的', '高大的', '懦弱的', '柔弱的', '爱笑的', '乐观的', '耍酷的', '酷炫的', '神勇的', '年轻的', '唠叨的', '瘦瘦的', '无情的', '包容的', '顺心的', '畅快的', '舒适的', '靓丽的', '负责的', '背后的', '简单的', '谦让的', '彩色的', '缥缈的', '欢呼的', '生动的', '复杂的', '慈祥的', '仁爱的', '魔幻的', '虚幻的', '淡然的', '受伤的', '雪白的', '高高的', '糟糕的', '顺利的', '闪闪的', '羞涩的', '缓慢的', '迅速的', '优秀的', '聪明的', '含糊的', '俏皮的', '淡淡的', '坚强的', '平淡的', '欣喜的', '能干的', '灵巧的', '友好的', '机智的', '机灵的', '正直的', '谨慎的', '俭朴的', '殷勤的', '虚心的', '辛勤的', '自觉的', '无私的', '无限的', '踏实的', '老实的', '现实的', '可靠的', '务实的', '拼搏的', '个性的', '粗犷的', '活力的', '成就的', '勤劳的', '单纯的', '落寞的', '朴素的', '悲凉的', '忧心的', '洁净的', '清秀的', '自由的', '小巧的', '单薄的', '贪玩的', '刻苦的', '干净的', '壮观的', '和谐的', '文静的', '调皮的', '害羞的', '安详的', '自信的', '端庄的', '坚定的', '美满的', '舒心的', '温暖的', '专注的', '勤恳的', '美丽的', '腼腆的', '优美的', '甜美的', '甜蜜的', '整齐的', '动人的', '典雅的', '尊敬的', '舒服的', '妩媚的', '秀丽的', '喜悦的', '甜美的', '彪壮的', '强健的', '大方的', '俊秀的', '聪慧的', '迷人的', '陶醉的', '悦耳的', '动听的', '明亮的', '结实的', '魁梧的', '标致的', '清脆的', '敏感的', '光亮的', '大气的', '老迟到的', '知性的', '冷傲的', '呆萌的', '野性的', '隐形的', '笑点低的', '微笑的', '笨笨的', '难过的', '沉静的', '火星上的', '失眠的', '安静的', '纯情的', '要减肥的', '迷路的', '烂漫的', '哭泣的', '贤惠的', '苗条的', '温婉的', '发嗲的', '会撒娇的', '贪玩的', '执着的', '眯眯眼的', '花痴的', '想人陪的', '眼睛大的', '高贵的', '傲娇的', '心灵美的', '爱撒娇的', '细腻的', '天真的', '怕黑的', '感性的', '飘逸的', '怕孤独的', '忐忑的', '高挑的', '傻傻的', '冷艳的', '爱听歌的', '还单身的', '怕孤单的', '懵懂的');
$nicheng_wei = array('嚓茶', '凉面', '便当', '毛豆', '花生', '可乐', '灯泡', '哈密瓜', '野狼', '背包', '眼神', '缘分', '雪碧', '人生', '牛排', '蚂蚁', '飞鸟', '灰狼', '斑马', '汉堡', '悟空', '巨人', '绿茶', '自行车', '保温杯', '大碗', '墨镜', '魔镜', '煎饼', '月饼', '月亮', '星星', '芝麻', '啤酒', '玫瑰', '大叔', '小伙', '哈密瓜，数据线', '太阳', '树叶', '芹菜', '黄蜂', '蜜粉', '蜜蜂', '信封', '西装', '外套', '裙子', '大象', '猫咪', '母鸡', '路灯', '蓝天', '白云', '星月', '彩虹', '微笑', '摩托', '板栗', '高山', '大地', '大树', '电灯胆', '砖头', '楼房', '水池', '鸡翅', '蜻蜓', '红牛', '咖啡', '机器猫', '枕头', '大船', '诺言', '钢笔', '刺猬', '天空', '飞机', '大炮', '冬天', '洋葱', '春天', '夏天', '秋天', '冬日', '航空', '毛衣', '豌豆', '黑米', '玉米', '眼睛', '老鼠', '白羊', '帅哥', '美女', '季节', '鲜花', '服饰', '裙子', '白开水', '秀发', '大山', '火车', '汽车', '歌曲', '舞蹈', '老师', '导师', '方盒', '大米', '麦片', '水杯', '水壶', '手套', '鞋子', '自行车', '鼠标', '手机', '电脑', '书本', '奇迹', '身影', '香烟', '夕阳', '台灯', '宝贝', '未来', '皮带', '钥匙', '心锁', '故事', '花瓣', '滑板', '画笔', '画板', '学姐', '店员', '电源', '饼干', '宝马', '过客', '大白', '时光', '石头', '钻石', '河马', '犀牛', '西牛', '绿草', '抽屉', '柜子', '往事', '寒风', '路人', '橘子', '耳机', '鸵鸟', '朋友', '苗条', '铅笔', '钢笔', '硬币', '热狗', '大侠', '御姐', '萝莉', '毛巾', '期待', '盼望', '白昼', '黑夜', '大门', '黑裤', '钢铁侠', '哑铃', '板凳', '枫叶', '荷花', '乌龟', '仙人掌', '衬衫', '大神', '草丛', '早晨', '心情', '茉莉', '流沙', '蜗牛', '战斗机', '冥王星', '猎豹', '棒球', '篮球', '乐曲', '电话', '网络', '世界', '中心', '鱼', '鸡', '狗', '老虎', '鸭子', '雨', '羽毛', '翅膀', '外套', '火', '丝袜', '书包', '钢笔', '冷风', '八宝粥', '烤鸡', '大雁', '音响', '招牌', '胡萝卜', '冰棍', '帽子', '菠萝', '蛋挞', '香水', '泥猴桃', '吐司', '溪流', '黄豆', '樱桃', '小鸽子', '小蝴蝶', '爆米花', '花卷', '小鸭子', '小海豚', '日记本', '小熊猫', '小懒猪', '小懒虫', '荔枝', '镜子', '曲奇', '金针菇', '小松鼠', '小虾米', '酒窝', '紫菜', '金鱼', '柚子', '果汁', '百褶裙', '项链', '帆布鞋', '火龙果', '奇异果', '煎蛋', '唇彩', '小土豆', '高跟鞋', '戒指', '雪糕', '睫毛', '铃铛', '手链', '香氛', '红酒', '月光', '酸奶', '银耳汤', '咖啡豆', '小蜜蜂', '小蚂蚁', '蜡烛', '棉花糖', '向日葵', '水蜜桃', '小蝴蝶', '小刺猬', '小丸子', '指甲油', '康乃馨', '糖豆', '薯片', '口红', '超短裙', '乌冬面', '冰淇淋', '棒棒糖', '长颈鹿', '豆芽', '发箍', '发卡', '发夹', '发带', '铃铛', '小馒头', '小笼包', '小甜瓜', '冬瓜', '香菇', '小兔子', '含羞草', '短靴', '睫毛膏', '小蘑菇', '跳跳糖', '小白菜', '草莓', '柠檬', '月饼', '百合', '纸鹤', '小天鹅', '云朵', '芒果', '面包', '海燕', '小猫咪', '龙猫', '唇膏', '鞋垫', '羊', '黑猫', '白猫', '万宝路', '金毛', '山水', '音响');

function getMaxUid()
{
    $sql = "SELECT MAX(uid) as uid FROM tb_register";
    $mysql = new mysqldb();
    if ($mysql->query($sql)) {
        $res = $mysql->fetch_row();
        return $res['uid'];
    }
    return false;
}

$max_uid = getMaxUid();

$min = ONE;
$max = 100;

echo "uid---" . $max_uid . "<br>";

if (!empty($max_uid)) {
    $min = $max_uid + ONE;
    $max = $min + 100;
}
$data = [];
$at = [''];
$indata = [];
//$config = Utils::config('rand_at');
// 查询注册最大uid 对应进行自增

$myfile = fopen("C:\Users\Administrator\Desktop\online\\tb_register" . $min . "and" . $max . ".json", "a+") or die("Unable to open file!");
$myloginfile = fopen("C:\Users\Administrator\Desktop\online\\tb_login" . $min . "and" . $max . ".json", "a+") or die("Unable to open file!");
$mypayfile = fopen("C:\Users\Administrator\Desktop\online\\tb_pay" . $min . "and" . $max . ".json", "a+") or die("Unable to open file!");

echo $min . "---" . $max . "<br>";

for ($i = $min; $i <= $max; $i++) {
    $creat_at_rand_num = mt_rand(ZERO, 188);
    $server_id = mt_rand(ONE, HUNDRED);
    $creat_at = $rand_at[$creat_at_rand_num];

    $dat_day = mt_rand(ONE, 10);

    $data1 = date('Y-m-d', strtotime("$creat_at +$dat_day day"));

    $chandid = rand(1, 20);

    $tou_num = rand(ZERO, 331);
    $wei_num = rand(ZERO, 325);
    $nick_name = $nicheng_tou[$tou_num] . $nicheng_wei[$wei_num] . $i;

    $channd_name = 'channd' . $chandid;
    // online 注册
    $setdata[] = array(
        $i,
        "'" . $nick_name . "'",
        "'" . $creat_at . "'",
        "'" . $data1 . "'",
        $chandid,
        "'" . $channd_name . "'",
        $server_id
    );
    $vip = ONE;
    $level = ONE;
    //  整理初始登录数据
    $indata[] = array(
        $i,
        $chandid,
        "'" . $creat_at . "'",
        "'" . $creat_at . "'",
        $vip,
        $level,
        "'" . $nick_name . "'",
        $server_id
    );

    // 组装json 录入json 文件
    $str1 = '{"index":{"_type":"register","_id":"' . $i . '"}}' . "\n";
    $str2 = '{"uid":' . $i . ',"server_id":"' . $server_id . '","nick_name":"' . $nick_name . '","creat_at":"' . $creat_at . '","login_at":"' . $data1 . '","channelid":"' . $chandid . '","channelname":"' . $channd_name . '"}' . "\n";
    if ($myfile) {
        fwrite($myfile, $str1);
        fwrite($myfile, $str2);
    }

}

$str1 = null;
$str2 = null;
fclose($myfile);

function setRegister($setdata)
{
    if (count($setdata) > ZERO) {
        $mysql = new mysqldb();
        $res = $mysql->insertBatch("tb_register", "uid, nick_name, creat_at, login_at, channelid, channelname,server_id", $setdata);

        if ($res) {

            return "注册用户 录入成功！<br>";
        } else {
            return "注册用户 录入失败！<br>";
        }
    }
    return "resq user data is null ！<br>";
}

// 登录
function setLogin($setdata)
{
    if (count($setdata) > ZERO) {
        $mysql = new mysqldb();

        $res = $mysql->insertBatch("tb_login", "uid, channelid,create_at,login_at, vip, level,nick_name,server_id", $setdata);

        if ($res) {

            return "登录活跃 录入成功！<br>";
        }
        return "登录活跃 录入失败！<br>";

    }
    return "dau data is null ！<br>";

}

function setPay($setdata)
{

    if (count($setdata) > ZERO) {
        $mysql = new mysqldb();
        $res = $mysql->insertBatch("tb_pay", "uid, pay_num, status, channelid, creat_at,pay_at,server_id", $setdata);

        if ($res) {

            //echo\n;
            return "充值成功 <br>";
        }
        return "充值失败 <br>";;

    }

    //echo "resq user data is null ！<br>";
    return "充值失败 data <br>";;;

}

// 录入注册用户
//$re_nline = setOnline($setdata);
$indata2 = [];

if (count($indata) > ZERO) {


    // 循环遍历100万条记录数据

    for ($i = ZERO; $i < count($indata); $i++) {

        $uid = $indata[$i][ZERO];
        $channelid = $indata[$i][ONE];
        $nick_name = $indata[$i][SIX];
        $creat_at = $indata[$i][TWO];
        $vip = $indata[$i][4];
        $level = $indata[$i][5];
        $server_id = $indata[$i][7];
        // -
        //

        // 遍历次数
        $fornum = mt_rand(ONE, 30);

        for ($j = ONE; $j <= $fornum; $j++) {
            $dat_day = mt_rand(ONE, 30);
            $level_rand = mt_rand(ONE, 5);
            $str = str_replace("'", '', $creat_at);

            $data1 = date('Y-m-d', strtotime("$str +$dat_day day"));

            $level += $level_rand;
            if ($level >= ONE AND $level <= 10) {
                $vip = $vip;
            }
            if ($level >= 10 AND $level <= 20) {
                $vip = 1;
            }
            if ($level >= 20 AND $level <= 30) {
                $vip = 2;
            }
            if ($level >= 30 AND $level <= 50) {
                $vip = 3;
            }
            if ($level >= 50 AND $level <= 100) {
                $vip = 4;
            }
            if ($level >= 100) {
                $vip = 5;
            }
            // 死循环 在执行 indata 第一层循环的时候进行的遍历 到地二次执行的时候确是有队 indata 进行了重新赋值,这时候indata 是不断的增大 通过
            // 第一层等for循环也会一直存在数据 count 永远会被迭代 所以一直就会处于死循环的状态了
            $indata2[] = array(
                $uid,
                $channelid,
                $creat_at,
                "'" . $data1 . "'",
                $vip,
                $level,
                $nick_name,
                $server_id
            );
            $str1 = '{"index":{"_type":"login","_id":"' . $uid . '"}}' . "\n";
            //"uid, channelid, login_at, create_at, vip, level,nick_name
            $str2 = '{"uid":' . $uid . ',"server_id":"' . $server_id . '","channelid":"' . $chandid . '","login_at":"' . $data1 . '","create_at":"' . $creat_at . '","vip":"' . $vip . '","level":"' . $level . '"}' . "\n";

            if ($myloginfile) {
                fwrite($myloginfile, $str1);
                fwrite($myloginfile, $str2);
            }
        }

    }
    fclose($myloginfile);

}
$pay_gear = [6, 10, 688, 188];
// 付费充值
if (count($indata) > ZERO) {

    $indata_max_key = count($indata);
    $pay_probability = [0.06, 0.02, 0.1, 0.2];
    $rand_sifter = mt_rand(ZERO, THREE);

    $paylin = ceil(($indata_max_key * $pay_probability[$rand_sifter]));
    //echo $paylin . "<br>";
    for ($i = ZERO; $i < $paylin; $i++) {
        //echo "-indata max key --" . $indata_max_key . "<br>";
        $role_dat_key = ceil(mt_rand(ZERO, $indata_max_key - ONE));
        //echo $role_dat_key . "<br>";
        $in_rand_roole = $indata[$role_dat_key];

        $uid = $in_rand_roole[ZERO];
        $channelid = $in_rand_roole[ONE];
        $nick_name = $in_rand_roole[SIX];
        $creat_at = $in_rand_roole[TWO];
        $server_id = $in_rand_roole[7];
        $pay_rand_num = mt_rand(ZERO, THREE);
        $pay_num = $pay_gear[$pay_rand_num];
        $status = rand(ZERO, THREE);

        $dat_day = mt_rand(ZERO, 30);

        $str = str_replace("'", '', $creat_at);

        $data1 = date('Y-m-d', strtotime("$str +$dat_day day"));

        $pay_data[] = array(
            $uid,
            $pay_num,
            $status,
            $channelid,
            $creat_at,
            "'" . $data1 . "'",
            $server_id
        );
        $str1 = '{"index":{"_type":"pay","_id":"' . $uid . '"}}' . "\n";
        //"uid, channelid, login_at, create_at, vip, level,nick_name
        $str2 = '{"uid":' . $uid . ',"server_id":"' . $server_id . '","channelid":"' . $channelid . '","login_at":"' . $data1 . '","create_at":"' . $creat_at . '","vip":"' . $vip . '","level":"' . $level . '"}' . "\n";

        if ($mypayfile) {
            fwrite($mypayfile, $str1);
            fwrite($mypayfile, $str2);
        }
    }
    fclose($mypayfile);
}
echo $paylin . "<br>";


echo setRegister($setdata);

unset($setdata);

echo setLogin($indata2);
unset($indata2);

echo setPay($pay_data);

unset($indata);
unset($pay_data);