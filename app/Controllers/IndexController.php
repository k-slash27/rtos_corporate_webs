<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class IndexController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        $api = new Api();
        $meta = $api->getData('meta');
        $news = $api->getData('news', null, [
            "limit" => 3,
            "orders" => ["-published"]
        ]);

        return $this->view('index', ['meta' => $meta, 'news' => $news, 'env' => $this->env]);
    }
}