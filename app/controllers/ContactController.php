<?php
// File: app/controllers/ContactController.php

class ContactController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../views/pages/contact.php';
    }
}
