<?php

namespace Cli;

use Core as Core;
use Utilities\Maintenance;

class Lister
{
    private $route;
    private $extension;
    private $app_dir;
    private $public_dir;
    private $args;


    public function __construct($route, $extension, $app_dir, $public_dir) {
        $this->route = &$route;
        $this->extension = &$extension;
        $this->app_dir = $app_dir;
        $this->public_dir = $public_dir;
    }


    public function index($args) {
        $this->args = $args;

        switch ($this->args[1]) {
            case 'extensions':
                $this->extensions();
                break;
            case 'views':
                $this->views();
                break;
            case 'controllers':
                $this->controllers();
                break;
            case 'libraries':
                $this->libraries();
                break;
            case 'languages':
                $this->languages();
                break;
            case 'public':
                $this->public();
                break;
            case 'routes':
                $this->routes();
                break;
            case 'redirects':
                $this->redirects();
                break;
            case 'blocked':
                $this->blocked();
                break;
            case 'config':
                $this->config();
                break;
            case 'ip':
                $this->ip();
                break;
            default:
                echo "\e[1;31m WARNING: Command doesn't exists\e[0m \n \n";
                break;
        }
    }


    private function extensions() {
        $extensions = $this->extension->get();

        if (empty($extensions)) {
            echo "Extensions: none \n \n";
            return;
        }

        foreach ($extensions as $ext) {
            echo "\n ->\e[32m " . $ext['name'] . "\e[0m";
            echo "\nDescription: " . $ext['description'];
            echo "\nVersion: " . $ext['version'];
            echo "\nAuthor: " . $ext['author'];
            echo "\nDirectory: " . $ext['directory'];
            echo "\nFilename: " . $ext['filename'];
            echo "\n";
        }
        echo "\n";
    }


    private function views() {
        $views = $this->listViewFiles($this->app_dir . 'views');

        foreach ($views as $view) {
            echo "\n" . $view;
        }
        echo "\n \n";
    }


    private function controllers() {
        $controllers = $this->listPHPFiles($this->app_dir . 'controllers');

        foreach ($controllers as $controller) {
            echo "\n" . $controller;
        }
        echo "\n \n";
    }


    private function libraries() {
        $libraries = $this->listPHPFiles($this->app_dir . 'libraries');

        foreach ($libraries as $library) {
            echo "\n" . $library;
        }
        echo "\n \n";
    }


    private function languages() {
        $languages = glob($this->app_dir . 'languages/*', GLOB_ONLYDIR);

        foreach ($languages as $language) {
            echo "\n" . substr($language, strrpos($language, '/') + 1);
        }
        echo "\n \n";
    }


    private function public() {
        $files = $this->listAnyFiles($this->public_dir);

        foreach ($files as $file) {
            echo "\n" . $file;
        }
        echo "\n \n";
    }


    private function listViewFiles($dir, $folder = '', &$result = array()) {
        $folder = substr($dir, strrpos($dir, '/') + 1);
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . '/' . $value);

            if (!is_dir($path) && in_array(pathinfo($path)['extension'], array('php', 'html', 'phtml'))) {
                $file_path = substr($path, strpos($path, $folder) + strlen($folder) + 1);
                $result[] = $file_path;
            } else {
                if ($value != "." && $value != "..") {
                    $this->listFiles($path, $result);
                }
            }
        }

        return $result;
    }


    private function listPHPFiles($dir, $folder = '', &$result = array()) {
        $folder = substr($dir, strrpos($dir, '/') + 1);
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . '/' . $value);

            if (!is_dir($path) && pathinfo($path)['extension'] == 'php') {
                $file_path = substr($path, strpos($path, $folder) + strlen($folder) + 1);
                $result[] = $file_path;
            } else {
                if ($value != "." && $value != "..") {
                    $this->listPHPFiles($path, $folder, $result);
                }
            }
        }

        return $result;
    }


    private function listAnyFiles($dir, &$result = array()) {
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . '/' . $value);

            if (!is_dir($path)) {
                $file_path = $path;
                $result[] = $file_path;
            } else {
                if ($value != "." && $value != "..") {
                    $this->listAnyFiles($path, $result);
                }
            }
        }

        return $result;
    }


    private function routes() {
        $routes = Core\Route::getRoutes();

        if (count($routes) <= 0) {
            echo "\n ROUTES: none \n \n";
            return;
        } else {
            foreach ($routes as $key => $value) {
                echo "\n " . $key;
            }
        }

        echo "\n \n";
    }


    private function blocked() {
        $blocked = Core\Route::getBlocked();

        if (count($blocked) <= 0) {
            echo "\n BLOCKED: none \n \n";
            return;
        } else {
            foreach ($blocked as $key => $value) {
                echo "\n " . $key;
            }
        }

        echo "\n \n";
    }


    private function redirects() {
        $redirects = Core\Route::getRedirects();

        if (count($redirects) <= 0) {
            echo "\n REDIRECTIONS: none \n \n";
            return;
        } else {
            foreach ($redirects as $key => $value) {
                echo "\n " . $redirects[$key]['origin'] . " -> " . $redirects[$key]['destiny'] . " | " . $redirects[$key]['code'];
            }
        }

        echo "\n \n";
    }


    private function ip() {
        $ips = Maintenance::getAllowedIPs();

        if ($ips === false || count($ips) <= 0) {
            echo "\n Allowed IPs: none \n \n";
            return;
        } else {
            foreach ($ips as $ip) {
                echo "\n " . $ip;
            }
        }

        echo "\n \n";
    }


    private function config() {
        echo "\n -> SERVER CONFIG: ";
        echo "\n getDBMS(): " . getDBMS();
        echo "\n Server: " . getServer();
        echo "\n Database: " . getDB();
        echo "\n User: " . getDBUser();
        echo "\n Password: " . getDBPass();
        echo "\n";
        echo "\n -> GENERAL CONFIG: ";
        echo "\n Project folder: " . WOLFF_ROOT_DIR;
        echo "\n App folder: " . WOLFF_APP_DIR;
        echo "\n Public folder: " . WOLFF_PUBLIC_DIR;
        echo "\n Page title: " . WOLFF_PAGE_TITLE;
        echo "\n Main page: " . WOLFF_MAIN_PAGE;
        echo "\n Language: " . WOLFF_LANGUAGE;
        echo "\n";
        echo "\n -> EXTRA CONFIG: ";
        echo "\n Cache enabled: " . (WOLFF_CACHE_ON ? "yes" : "no");
        echo "\n Extensions enabled: " . (WOLFF_EXTENSIONS_ON ? "yes" : "no");
        echo "\n Maintenance mode enabled: " . (WOLFF_MAINTENANCE_ON ? "yes" : "no");
        echo "\n \n";
    }

}