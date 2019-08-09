<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="http://localhost:8055/chatroom/res/js/jquery.cookie.js"></script>

<?php

//include "autoload.php";

//$config = Utils::config();
//$pact = 'login';
/*function isAction($pact,$config)
{

    $data = isParame($config['server_pact'], $pact);

    if ($data) {

        var_dump($pact);
    }
   var_dump($data);
}*/
/***
 * 参数是否为空
 * @param $data
 * @return bool
 */
/*   function isParame($data, $key)
{
    if ($red = isDatas($data, $key)) {
        return $red;
    }
    log_message::info("$key is null ");
    //exit(Utils::sendResults("$key is null"));
    //exit(Utils::errorCode("$key is null ", FAILURE));
    return null;
}
$data = isParame($config['server_pact'], $pact);

if (in_array($pact,  $config['server_pact'])) {

    echo "dddddddd". $pact;
}

isAction('login',$config);*/

/*function tess()
{

    return "123";
}


$dd = 'tess';
if (function_exists($dd)) {

    echo $dd();
} else {

    echo "fall";
}*/

$dd = '{"friend_msg":"555","friendid":2105055520,"friend_nickname":"byjames","create_at":"2019-05-12 星期日 20:01:58","status":1}';
$aa = ' {"friend_msg":"dff123","friendid":2105055520,"friend_nickname":"byjames","create_at":"2019-05-12 星期日 20:01:58","status":1}';
$cc2 = ' {"friend_msg":"dff1234","friendid":2105055520,"friend_nickname":"byjames","create_at":"2019-05-12 星期日 20:01:58","status":1}';

$a = json_decode($dd, true);
$b = json_decode($aa, true);
//var_dump($a);
echo "<br>";
//var_dump($b);

echo "<br>";
$m = $a + $b;
$data[] = $a;
$data[] = $b;

//var_dump($data);

$aa = json_encode($data, JSON_UNESCAPED_UNICODE);

$cc = json_decode($aa, true);

$dam[] = $cc;
$dam[] = json_decode($cc2, true);
 echo count($a);
echo count($b, 1);
?>



