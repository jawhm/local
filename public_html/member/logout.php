<?

session_start();
mb_language("Ja");
mb_internal_encoding("utf8");

// ログインOK
$_SESSION['mem_id'] = '';
$_SESSION['mem_name'] = '';
$_SESSION['mem_level'] = -1;
header("Location: /member/");
exit;

?>