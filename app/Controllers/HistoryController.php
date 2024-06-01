<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class HistoryController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        $api = new Api();
        $meta = $api->getData('meta');
        $news = $api->getData('news', null, [
            "orders" => ["published"],
            "filters" => 'isHistory[equals]true'
        ]);

        foreach ($news['contents'] as $key => $arr) {
            $news['contents'][$key]['published'] = date('Y年 n月', strtotime($arr['published']));
        }

        return $this->view('history/index', ['meta' => $meta, 'history' => $news, 'env' => $this->env]);
    }
}