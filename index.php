<?php
if (empty($_SERVER['REQUEST_URI'])) {
  exit;
}
require_once "./vendor/autoload.php";

use Configure\Configure;

$c = new Configure();

// URLをスラッシュで分解
$array_parse_uri = explode('/', $_SERVER['REQUEST_URI']);

// コントローラー名抽出
$last_uri = $array_parse_uri[1];
$last_uri = substr($last_uri, 0, strcspn($last_uri,'?'));

$uris = explode('_', $last_uri);

$call = reset($uris);
$call = ucfirst(strtr(ucwords(strtr($call, ['_' => ' '])), [' ' => ''])) . "Controller";
$call = $call==='Controller' ? 'IndexController' : $call;

// コントローラー呼び出し
if (file_exists(__CONTROLLER_DIR__ . "/" . $call . ".php")) {

    include(__CONTROLLER_DIR__ . "/" . $call . ".php");
    $class = 'App\Controllers\\' . $call;

    $obj = new $class();

    // クラスメソッドの実行
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      // GET時
      $menu = $array_parse_uri[1] ?? "";
      $param_1 = $array_parse_uri[2] ?? "";
      $param_2 = $array_parse_uri[3] ?? "";

      if (!empty($param_2) && $param_1 == "p") {
        // ページネーションの場合 (Ex: /news/p/2)
        $response = $obj->index($param_2);
      } else if (!empty($param_1)) {
        // 記事IDがある場合 (Ex: /news/gfniwi8h7o)
        $response = $obj->detail($param_1);
      } else {
        // 各メニューTOPの場合 (Ex: /news)
        $response = $obj->index();
      }
    } else {
        // POST時
        $response = $obj->post();
    }

    // コントローラーからのレスポンスを出力
    echo $response;
    exit;

} else {
    // ファイルがなければ404エラー
    header('Location: /error/404');
    exit;
}