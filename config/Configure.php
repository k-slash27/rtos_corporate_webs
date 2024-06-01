<?php
declare(strict_types=1);

namespace Configure;


class Configure
{    
    // サーバー環境
    private $mode = 'local';

    // ドキュメントルート
    private $root = [
        'prod' => '/home/users/1/main.jp-rtos/web',
        'dev' => '/var/www/html',
        'local' => '.',
    ];

    // 環境変数
    private $env = [
        '__PROJECT_ROOT__' => '/',
        '__CONTROLLER_DIR__' => '/app/Controllers',
        '__MODEL_DIR__' => '/app/Models',
        '__VIEW_DIR__' => '/app/Views',
    ];

    public function __construct() {
        // 環境定義
        $root_path = $this->root[$this->mode];
        foreach ($this->env as $key => $val) {
            define($key, $root_path.$val);
        }
    }
}
