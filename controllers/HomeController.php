<?php

class HomeController {
    public function index() {
        $this->render('home/index');
    }
    
    public function about() {
        $this->render('home/about');
    }
    
    private function render($view, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }
}
