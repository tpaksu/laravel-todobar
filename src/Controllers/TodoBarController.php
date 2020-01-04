<?php

namespace TPaksu\TodoBar\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class TodoBarController extends Controller {

    public function getScripts() {
        return "<script type='text/javascript'>" . file_get_contents($this->assets_path("todobar.js")) . "</script>";
    }

    public function getDrawer() {
        return View::make("laravel-todobar::todobar");
    }

    public function getStyles() {
        $dark_mode = config("todobar.dark_mode", false);
        $file = "todobar.css";
        if ($dark_mode) {
            $file = "todobar-dark.css";
        }
        $path = $this->assets_path($file);
        return "<style>" . file_get_contents($path) . "</style>";
    }

    public function getInjection()
    {
        return $this->getStyles() . $this->getDrawer() . $this->getScripts();
    }

    public function inject(Response $response) {
        $response->setContent(str_replace("</body>", "</body>" . $this->getInjection(), $response->getContent()));
    }

    public function assets_path($file)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, "..", "assets", $file]);
    }
}
