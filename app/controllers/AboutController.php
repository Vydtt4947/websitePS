<?php
// File: app/controllers/AboutController.php

class AboutController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../views/pages/about.php';
    }
}
