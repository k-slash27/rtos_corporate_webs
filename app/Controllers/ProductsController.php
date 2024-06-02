<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class ProductsController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        $api = new Api();
        $meta = $api->getData('meta');
        
        return $this->view('products/index', ['meta' => $meta, 'env' => $this->env]);
    }

    public function detail($uri) {
        $api = new Api();
        $meta = $api->getData('meta');
        
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/static/img/products/slider';
        $num = count(glob($dir . "/*"));

        return $this->view('products/'.$uri.'/index', ['meta' => $meta, 'env' => $this->env, 'slideDir' => $dir, 'slideCount' => $num]);
    }
}



