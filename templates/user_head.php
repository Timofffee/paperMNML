<? 
if (!isset($_GET["login"]) or 
    !$database->has("user", [
        "login" => $_GET['login']
    ])) {
    header("Location: /");
} 
$suser = $database->select("user", [
    "user_id",
    "login",
    "email",
    "role",
    "reg_date",
    "avatar", 
    "session_id"
], [
    "login" => $_GET['login']
])[0];

$is_owner = $suser[user_id] == $_COOKIE[uid] and $suser[session_id] == $_COOKIE[sid];

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day'
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(' ', $string) : 'just now';
} ?> 