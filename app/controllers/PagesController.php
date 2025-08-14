<?php
// File: app/controllers/PagesController.php

class PagesController {

    public function promotion() {
        require_once __DIR__ . '/../views/pages/promotion.php';
    }

    public function about() {
        require_once __DIR__ . '/../views/pages/about.php';
    }

    public function contact() {
        require_once __DIR__ . '/../views/pages/contact.php';
    }
}
