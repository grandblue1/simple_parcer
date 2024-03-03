<?php 

namespace Src\Controller; 

class Controller {
    protected $viewPath;

    public function __construct() {
        $this->viewPath =  __DIR__ . '/../View/';
    }
    protected function render($view, $data = []) {
        extract($data);
    
        $viewFilePath = $this->viewPath . $view . '.php';
    
        if (file_exists($viewFilePath)) {
            include($viewFilePath);
        } else {
            $this->renderError("View not found: $view");
        }
    }
    protected function renderError($message){
        echo "Error: $message";
    }
}