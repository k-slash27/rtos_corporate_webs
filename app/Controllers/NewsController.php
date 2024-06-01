<?php

declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class NewsController extends Controller
{

    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index($page = null) {
        $api = new Api();
        $meta = $api->getData('meta');

        $limit = 10;
        $page = $page ?? 1;
        $offset = $page > 1 ? ($page - 1) * $limit : 0;

        $news = $api->getData('news', null, [
            "orders" => ["-published"]
        ]);

        $pageCount = $news['totalCount'] % $limit > 0 ? intval($news['totalCount'] / $limit) + 1 : intval($news['totalCount'] / $limit);

        $contents = array_slice($news['contents'], $offset, $limit);

        return $this->view('news/index', ['meta' => $meta, 'news' => $contents, 'current' => $page, 'pageCount' => $pageCount, 'env' => $this->env]);
    }

    public function detail($id) {
        $api = new Api();
        $meta = $api->getData('meta');
        $news = $api->getData('news/' . $id);

        return $this->view('news/detail', ['meta' => $meta, 'news' => $news, 'env' => $this->env]);
    }
}
