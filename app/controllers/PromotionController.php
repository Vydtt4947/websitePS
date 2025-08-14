<?php
// File: app/controllers/PromotionController.php

class PromotionController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        require_once __DIR__ . '/../views/pages/promotion.php';
    }
}
