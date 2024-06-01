<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class BusinessController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        $api = new Api();
        $meta = $api->getData('meta');
        $business = $api->getData('business');
        return $this->view('business/index', ['meta' => $meta, 'business' => $business, 'env' => $this->env]);
    }
}