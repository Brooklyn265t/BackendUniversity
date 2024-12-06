<?php
session_start();
$session_id = session_id();
$random = md5(rand(1, 1000)); // Случайное имя куки
$randomcookie = $random;
setcookie($random, $session_id, time() + 3600, true, true);

// Подключение к Redis
$redis = new \Redis();
try {
    $redis->connect('cache', 6379);
} catch (\Exception $e) {
    var_dump($e->getMessage());
    die;
}

// Функция для получения IP-адреса
function get_ip_list() {
    $list = array();
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $list = array_merge($list, $ip);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $list = array_merge($list, $ip);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $list[] = $_SERVER['REMOTE_ADDR'];
    }
    $list = array_unique($list);
    return implode(',', $list);
}

// Получение информации о пользователе
$ip = get_ip_list();
$browser = getBrowser();
$acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$languages = explode(',', $acceptLanguage);
$preferredLanguage = substr($languages[0], 0, 2); // Получаем только код языка

// Сохранение данных в Redis
$redis->hMSet("session:$session_id", [
    'user_ip' => $ip,
    'browser' => $browser,
    'preferred_language' => $preferredLanguage
]);

// Получение данных из Redis
$userData = $redis->hGetAll("session:$session_id");

// Формирование контента на основе параметров
$content = "Добро пожаловать, {$userData['user_ip']}! Браузер: {$userData['browser']}, Язык: {$userData['preferred_language']}.";
echo $content;

// Функция для определения браузера
function getBrowser() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, 'Firefox') !== false) {
        return 'Mozilla Firefox';
    } elseif (strpos($userAgent, 'Chrome') !== false) {
        return 'Google Chrome';
    } elseif (strpos($userAgent, 'Safari') !== false) {
        return 'Apple Safari';
    } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
        return 'Opera';
    } else {
        return 'Неизвестный браузер';
    }
}
?>
<?php
$dir = $_SERVER["DOCUMENT_ROOT"];
$dir_content = scandir($dir);
foreach ($dir_content as $item){
    if($item != "." && $item != ".."){
        echo "<a href='./$item'>$item</a><br>";
    }
}
?>
