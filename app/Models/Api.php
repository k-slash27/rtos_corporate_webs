<?php

declare(strict_types=1);

namespace App\Models;

require_once __PROJECT_ROOT__ . "/vendor/autoload.php";

use Dotenv\Dotenv;
use Exception;
use \Microcms\Client;

class Api
{
    protected $client;
    
    public function __construct() {
        Dotenv::createImmutable(__PROJECT_ROOT__)->load();

        $this->client = new Client(
            $_ENV['MICROCMS_SERVICE_DOMAIN'],
            $_ENV['MICROCMS_API_KEY']
        );
    }

    public function getData($endpoint=null, $field=null, $cond=[]) {
        if ($endpoint != null) {
            if ($cond != []) {
                try {
                    $obj = $this->client->list($endpoint, $cond);
                } catch (Exception $e) {
                    $error_code = $e->getCode() ?? "";
                    header('Location: /error/'.$error_code);
                    exit;
                }
                $arr = json_decode(json_encode($obj), true);
                return $arr;    
            }

            if ($field != null) {
                try {
                    $singleContent = $this->client->get($endpoint)->{$field};
                } catch (Exception $e) {
                    $error_code = $e->getCode() ?? "";
                    header('Location: /error/'.$error_code);
                    exit;
                }
                return $singleContent;
            }

            try {
                $obj = $this->client->get($endpoint);
            } catch (Exception $e) {
                $error_code = $e->getCode() ?? "";
                header('Location: /error/'.$error_code);
                exit;
            }
            $arr = json_decode(json_encode($obj), true);
            return $arr;
        }

        return 'Bad Request';
    }
}