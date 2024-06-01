<?php
declare(strict_types=1);

namespace App\Controllers;

require_once 'Controller.php';

use App\Models\Api;

class ContactController extends Controller
{
    protected $env;

    public function __construct() {
        $this->env = $this->env();
    }

    public function index() {
        $api = new Api();
        $meta = $api->getData('meta');
        return $this->view('contact/index', ['meta' => $meta, 'env' => $this->env]);
    }
}