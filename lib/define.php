<?php

define('TIMEZONE', "PRC");                // 时区设置
date_default_timezone_set(TIMEZONE);

define('DBHOST', '127.0.0.1');            // 数据库地址
define('DBUSER', 'chatroom');                 // 数据库用户名
define('DBPORT', 3306);
define('DBPASSWORD', 'lmj3503791673');    // 数据库密码
define('DBNAME', 'chatroom');              // 默认数据库
define('DBCHARSET', 'utf8');              // 数据库字符集

#wechat defaine
define('WECHAT_APPID', 'wx6a7abf227bcd0d56');
define('WECHAT_KEY', '13084de8fbb0038feeaa15c3d6b392e7');
define('WECHAT_SCOPE_BASE', 'snsapi_base'); // 不弹框
define('WECHAT_SCOPE', 'snsapi_userinfo'); // 弹框

define('WECHAT_SERVER', 'https://open.weixin.qq.com/connect/oauth2/authorize');
define('WECHAT_REDIRECT_URL', urlencode('localhost'));

define('WECHAT_ACCESSTOKEN_URL', 'https://api.weixin.qq.com/sns/oauth2/access_token');

#log dir
define('DIR_SEPARATOR', "/");
define('LINUX_LOGDIRS', dirname(dirname(__FILE__)) . '/log/'); // 日志目录
define('WINDOWS_LOGDIRS', dirname(dirname(__FILE__)) . '/log/error.txt'); // 日志目录
define('LOGDIRS_FILENAME', 'error.log'); // 日志目录
define("LOG_SERVER_URL", dirname(dirname(__FILE__)) . "/log/");
#gift code status
define('GIFTCODE_STATUS', 0); // 正常
define('GIFTCODE_EXPIRED_STATUS', 1); //过期
#log url


# class dir
define('LIBDIR', dirname(__FILE__) . '/'); // lib
define('LIBDIR_TWO', dirname(dirname(__FILE__)) . '/mode/'); // mode

#Redis
define('REDIS_HOST', 'd2444656u3.zicp.vip');
define('REDIS_PORT', '6379');
define('REDIS_AUTH', '123456');
# time format
define('DATE_FORMAT_S', "Y-m-d H:i:s");
define('DATE_FORMAT_D', "Y-m-d");

# res
#file upload url
//define('RES_URL', 'http://192.168.181.133:9095');
//define('RES_PATH', dirname(dirname(dirname($_SERVER['DOCUMENT_ROOT']))) . '/res/config/');
//define('RES_CONFIG_URL', 'https://d.djsh5.com');// config file url
define('RES_CONFIG_URL', 'http://d.djsh5.com');
//define('RES_FILE_URL','/home/projects/res/config');
#排行榜接口地址
define('STAT_RANKING_DIR', 'http://event.djsh5.com/rank/?');
# 常数zero
define('ZERO', 0);
define('ONE', 1);
define('TWO', 2);
define('THREE', 3);
define('FIVE', 5);
define('SIX', 6);
define('HUNDRED', 100);
#activites
define('ACTIVITES_STATUS', 1); // 0 未开启 1 已开启

#error info
define('SUCCESS', 1);
define('FAILURE', -1);

#swoole
define('SWOOLE_SER_HOST', '0.0.0.0');
define('SWOOLE_SER_PORT', 9501);

# css and js dir

define('CSS_DIR', dirname(dirname(__FILE__)) . '/res/css/'); // css
define('JS_DIR', dirname(dirname(__FILE__)) . '/res/js/'); // js