<?php

namespace TPaksu\TodoBar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class TodoBarController extends Controller {

    public function getScripts(){
        return "<script type='text/javascript'>" . file_get_contents(__DIR__."\\assets\\todobar.js") . "</script>";
    }

    public function getDrawer(){
        return View::make("laravel-todobar::todobar");
    }

    public function getStyles(){
        return "<style>" . file_get_contents(dirname(__FILE__)."\\assets\\todobar.css") . "</style>";
    }

    public function getInjection()
    {
        return $this->getStyles() . $this->getDrawer() . $this->getScripts();
    }

    public function inject(Response $response){
        $response->setContent(str_replace("</body>", "</body>" . $this->getInjection(), $response->getContent()));
    }
}
