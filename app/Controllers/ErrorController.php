<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class ErrorController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        return $this->detail();
    }

    public function detail($code = "") {
        $api = new Api();
        $meta = $api->getData('meta');

        $view = 'error/'.strval($code);

        if (empty($code) || !file_exists(__VIEW_DIR__."/error/".$code.".html")) {
            $view = 'error/index';
        }

        return $this->view($view, ['meta' => $meta, 'env' => $this->env]);
    }
}