<?php
// File: app/controllers/CartController.php

require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/SessionCartModel.php';
require_once __DIR__ . '/../models/PromotionModel.php';

class CartController {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Debug: Kiểm tra session ID và status
        error_log("DEBUG: Session ID: " . session_id());
        error_log("DEBUG: Session status: " . session_status());
        error_log("DEBUG: All session data: " . json_encode($_SESSION));
        
        // Debug logs removed for production
        
        try {
            $cartModel = new CartModel();
            $sessionCartModel = new SessionCartModel();
            $promotionModel = new PromotionModel();
            $cart = [];
            
            // Debug logs removed for production
            
            // Lấy giỏ hàng dựa trên trạng thái đăng nhập
            if (isset($_SESSION['customer_id'])) {
                // Khách hàng đã đăng nhập - lấy từ database
                $cart = $cartModel->getCart($_SESSION['customer_id']);
                // Debug logs removed for production
            } else {
                // Khách vãng lai - lấy từ session
                $cart = $sessionCartModel->getCart();
                // Debug logs removed for production
            }
            
            // Không redirect khi giỏ hàng trống, chỉ hiển thị trang giỏ hàng trống
            // if (empty($cart)) {
            //     header('Location: /websitePS/public/');
            //     exit();
            // }
            
            // Tính toán tổng tiền
            $total = 0;
            $productCategories = [];
            
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                    
                    // Thu thập danh mục sản phẩm để kiểm tra ưu đãi
                    if (!empty($item['category'])) {
                        $productCategories[] = $item['category'];
                    }
                }
            }
            
            // Debug log tổng tiền ban đầu
            error_log("DEBUG CartController: Initial total calculated: " . $total);
            
            // Debug logs removed for production
            
            // Lấy ưu đãi được chọn từ session hoặc form
            $selectedPromotions = [];
            
            // Debug: Kiểm tra session
            error_log("DEBUG: Session selected_promotions: " . (isset($_SESSION['selected_promotions']) ? json_encode($_SESSION['selected_promotions']) : 'NOT SET'));
            error_log("DEBUG: POST promotion_form_submitted: " . (isset($_POST['promotion_form_submitted']) ? 'YES' : 'NO'));
            
            if (isset($_POST['promotion_form_submitted'])) {
                // Form đã được submit, sử dụng POST data
                $selectedPromotions = isset($_POST['selected_promotions']) && is_array($_POST['selected_promotions']) ? $_POST['selected_promotions'] : [];
                // Giới hạn tối đa 3 khuyến mãi
                $selectedPromotions = array_slice($selectedPromotions, 0, 3);
                $_SESSION['selected_promotions'] = $selectedPromotions;
                error_log("DEBUG: Set from POST: " . json_encode($selectedPromotions));
            } elseif (isset($_SESSION['selected_promotions'])) {
                // Lấy từ session nếu không có POST data (khi refresh trang)
                $selectedPromotions = $_SESSION['selected_promotions'];
                // Giới hạn tối đa 3 khuyến mãi
                $selectedPromotions = array_slice($selectedPromotions, 0, 3);
                $_SESSION['selected_promotions'] = $selectedPromotions;
                error_log("DEBUG: Loaded from session: " . json_encode($selectedPromotions));
            } elseif (isset($_SESSION['promotion_from_page'])) {
                // Nếu có khuyến mãi từ trang khuyến mãi, tự động chọn
                $selectedPromotions = $_SESSION['promotion_from_page'];
                // Giới hạn tối đa 3 khuyến mãi
                $selectedPromotions = array_slice($selectedPromotions, 0, 3);
                $_SESSION['selected_promotions'] = $selectedPromotions;
                error_log("DEBUG: Set from promotion_from_page: " . json_encode($selectedPromotions));
            } else {
                // Khởi tạo mảng rỗng - không chọn sẵn khuyến mãi cho khách hàng
                $selectedPromotions = [];
                // KHÔNG ghi đè session nếu không có dữ liệu mới
                error_log("DEBUG: No promotions selected, using empty array");
            }
            
            // Debug logs removed for production
            
            // Debug logs removed for production
            
            // Tính toán ưu đãi (chỉ cho khách hàng đã đăng nhập)
            $availablePromotions = [];
            $discountResult = [
                'promotions' => [],
                'totalDiscount' => 0,
                'finalTotal' => $total,
                'maxDiscount' => 0,
                'discountPercentage' => 0
            ];
            $appliedPromotions = [];
            $totalDiscount = 0;
            $finalTotal = $total;
            $maxDiscount = 0;
            $discountPercentage = 0;
            
            if (!empty($cart) && isset($_SESSION['customer_id'])) {
                // Chỉ tính ưu đãi cho khách hàng đã đăng nhập
                $availablePromotions = $promotionModel->getAvailablePromotions($_SESSION['customer_id'], $total, implode(',', $productCategories));
                
                // Tính toán ưu đãi dựa trên lựa chọn
                $discountResult = $promotionModel->calculateAllDiscounts($_SESSION['customer_id'], $total, implode(',', $productCategories), $selectedPromotions);
                
                $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                    return isset($promotion['isSelected']) && $promotion['isSelected'];
                });
                
                $totalDiscount = $discountResult['totalDiscount'];
                $finalTotal = $discountResult['finalTotal'];
                $maxDiscount = $discountResult['maxDiscount'];
                $discountPercentage = $discountResult['discountPercentage'];
                
                // Debug logs removed for production
            } else {
                // Khách vãng lai - không có ưu đãi
                $availablePromotions = [];
                $appliedPromotions = [];
                $totalDiscount = 0;
                $finalTotal = $total;
                $maxDiscount = 0;
                $discountPercentage = 0;
            }
            
            // Lấy danh sách ưu đãi có thể chọn bằng checkbox (chỉ ưu đãi phân khúc)
            $selectablePromotions = [];
            if (isset($_SESSION['customer_id'])) {
                $selectablePromotions = $promotionModel->getSelectablePromotions();
            }
            
            // Tính phí vận chuyển - tính cho TẤT CẢ đơn hàng có sản phẩm
            $shippingFee = 0;
            if (!empty($cart)) {
                $shippingFee = 30000;
            }
            
            // Kiểm tra xem có ưu đãi miễn phí vận chuyển không (từ database)
            // CHỈ khách hàng đã đăng nhập mới được áp dụng FREESHIP
            if (isset($_SESSION['customer_id'])) {
                foreach ($appliedPromotions as $promotion) {
                    if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                        // Kiểm tra tên mã khuyến mãi có chứa "FREESHIP" không
                        $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                        if (strpos($promotionName, 'FREESHIP') !== false) {
                            // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                            if ($total >= 500000) {
                                $shippingFee = 0;
                                error_log("DEBUG CartController: Free shipping applied from FREESHIP promotion (Total: " . $total . ")");
                            } else {
                                error_log("DEBUG CartController: FREESHIP not applied - order total too low (Total: " . $total . ", Required: 500000)");
                            }
                            break;
                        } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                            // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                            $shippingFee = 0;
                            error_log("DEBUG CartController: Free shipping applied from other promotion: " . $promotion['promotionType']);
                            break;
                        }
                    }
                }
            } else {
                // Khách vãng lai - LUÔN tính phí vận chuyển 30,000₫, KHÔNG áp dụng FREESHIP
                error_log("DEBUG CartController: Guest user - shipping fee fixed at 30000, no FREESHIP applied");
            }
            
            // Debug log phí vận chuyển
            error_log("DEBUG CartController: Shipping fee calculated: " . $shippingFee . " (Total: " . $total . ", FREESHIP applied: " . ($shippingFee == 0 ? "Yes" : "No") . ")");
            
            // Tính tổng cuối cùng: Tổng tiền hàng - Giảm giá + Phí vận chuyển
            $finalTotal = $total - $totalDiscount + $shippingFee;
            
            // Debug log để kiểm tra tính toán
            error_log("DEBUG CartController: Total: " . $total . ", TotalDiscount: " . $totalDiscount . ", ShippingFee: " . $shippingFee . ", FinalTotal: " . $finalTotal);
            
            // Debug logs removed for production
            
            require_once __DIR__ . '/../views/pages/cart.php';
            
        } catch (Exception $e) {
            error_log("Error in CartController::index(): " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Hiển thị trang lỗi đơn giản
            echo "<h1>Lỗi</h1>";
            echo "<p>Có lỗi xảy ra khi tải trang giỏ hàng. Vui lòng thử lại sau.</p>";
            echo "<a href='/websitePS/public/'>Về trang chủ</a>";
        }
    }

    public function add() {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai thêm vào giỏ hàng

        // Xử lý cả GET và POST request
        $productId = null;
        $quantity = 1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['productId'] ?? null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        } else {
            // GET request từ trang danh sách sản phẩm
            $productId = $_GET['productId'] ?? null;
            $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        }

        if (!$productId || $quantity <= 0) {
            // Kiểm tra nếu là AJAX request
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Thông tin sản phẩm không hợp lệ!'
                ]);
                return;
            }
            
            $_SESSION['error_message'] = 'Thông tin sản phẩm không hợp lệ!';
            header('Location: /websitePS/public/');
            exit();
        }
        
        // VALIDATION: Kiểm tra số lượng tồn kho
        $productModel = new ProductModel();
        $product = $productModel->getProductById($productId);
        
        if (!$product) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ]);
                return;
            }
            
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại!';
            header('Location: /websitePS/public/');
            exit();
        }
        
        // Kiểm tra số lượng tồn kho
        $availableStock = $product['SoLuong'] ?? 0;
        
        // Kiểm tra tổng số lượng sau khi cộng dồn với giỏ hàng hiện tại
        $currentCartQuantity = 0;
        if (isset($_SESSION['customer_id'])) {
            // Khách hàng đã đăng nhập - kiểm tra giỏ hàng database
            $tempCartModel = new CartModel();
            $currentCart = $tempCartModel->getCart($_SESSION['customer_id']);
            $currentCartQuantity = $currentCart[$productId]['quantity'] ?? 0;
        } else {
            // Khách vãng lai - kiểm tra giỏ hàng session
            $tempSessionCartModel = new SessionCartModel();
            $currentCart = $tempSessionCartModel->getCart();
            $currentCartQuantity = $currentCart[$productId]['quantity'] ?? 0;
        }
        
        $totalRequestedQuantity = $currentCartQuantity + $quantity;
        
        if ($totalRequestedQuantity > $availableStock) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => "Chỉ còn $availableStock sản phẩm trong kho! Bạn đã có $currentCartQuantity sản phẩm trong giỏ hàng và đang yêu cầu thêm $quantity sản phẩm nữa (tổng: $totalRequestedQuantity)."
                ]);
                return;
            }
            
            $_SESSION['error_message'] = "Chỉ còn $availableStock sản phẩm trong kho! Bạn đã có $currentCartQuantity sản phẩm trong giỏ hàng và đang yêu cầu thêm $quantity sản phẩm nữa (tổng: $totalRequestedQuantity).";
            header('Location: /websitePS/public/');
            exit();
        }
        
        // Kiểm tra nếu sản phẩm hết hàng
        if ($availableStock <= 0) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Sản phẩm này hiện đang hết hàng!'
                ]);
                return;
            }
            
            $_SESSION['error_message'] = 'Sản phẩm này hiện đang hết hàng!';
            header('Location: /websitePS/public/');
            exit();
        }
        
        // Kiểm tra nếu số lượng yêu cầu vượt quá tồn kho
        if ($quantity > $availableStock) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => "Chỉ còn $availableStock sản phẩm trong kho! Bạn đang yêu cầu $quantity sản phẩm."
                ]);
                return;
            }
            
            $_SESSION['error_message'] = "Chỉ còn $availableStock sản phẩm trong kho! Bạn đang yêu cầu $quantity sản phẩm.";
            header('Location: /websitePS/public/');
            exit();
        }

        // Khai báo các model trước
        $cartModel = null;
        $sessionCartModel = null;
        
        // Xử lý giỏ hàng dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            // Khách hàng đã đăng nhập - lưu vào database
            $cartModel = new CartModel();
            // Sử dụng strategy 'add' để cộng dồn số lượng khi thêm cùng sản phẩm
            $result = $cartModel->addCartItem($_SESSION['customer_id'], $productId, $quantity, 'add');
        } else {
            // Khách vãng lai - lưu vào session
            $sessionCartModel = new SessionCartModel();
            $result = $sessionCartModel->addCartItem($productId, $quantity);
        }

        // Kiểm tra nếu là AJAX request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            
            if ($result) {
                // Tính toán số lượng sản phẩm trong giỏ hàng
                $cartCount = 0;
                if (isset($_SESSION['customer_id']) && $cartModel) {
                    $cart = $cartModel->getCart($_SESSION['customer_id']);
                } else if ($sessionCartModel) {
                    $cart = $sessionCartModel->getCart();
                } else {
                    $cart = [];
                }
                
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'];
                }
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!',
                    'cartCount' => $cartCount
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!'
                ]);
            }
            return;
        }

        // Xử lý redirect cho non-AJAX request
        if ($result) {
            $_SESSION['success_message'] = 'Đã thêm sản phẩm vào giỏ hàng thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!';
        }

        // Redirect về trang trước đó hoặc trang sản phẩm
        $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/websitePS/public/';
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function update($productId = null, $change = null) {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai cập nhật giỏ hàng

        // Lấy productId từ URL parameter hoặc POST data
        if (!$productId) {
            $productId = $_POST['productId'] ?? null;
        }

        // Lấy quantity từ URL parameter hoặc POST data
        if ($change !== null) {
            // Nếu có change từ URL, tính toán quantity mới
            if (isset($_SESSION['customer_id'])) {
                $cartModel = new CartModel();
                $cart = $cartModel->getCart($_SESSION['customer_id']);
            } else {
                $sessionCartModel = new SessionCartModel();
                $cart = $sessionCartModel->getCart();
            }
            $currentQuantity = $cart[$productId]['quantity'] ?? 0;
            $quantity = $currentQuantity + (int)$change;
        } else {
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
        }

                if (!$productId) {
            $_SESSION['error_message'] = 'Thông tin sản phẩm không hợp lệ!';
            header('Location: /websitePS/public/cart');
            exit();
        }
        
        // VALIDATION: Kiểm tra số lượng tồn kho
        $productModel = new ProductModel();
        $product = $productModel->getProductById($productId);
        
        if (!$product) {
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại!';
            header('Location: /websitePS/public/cart');
            exit();
        }
        
        // Kiểm tra nếu sản phẩm hết hàng
        if ($availableStock <= 0) {
            $_SESSION['error_message'] = 'Sản phẩm này hiện đang hết hàng!';
            header('Location: /websitePS/public/cart');
            exit();
        }
        
        // Kiểm tra số lượng tồn kho
        if ($quantity > $availableStock) {
            $_SESSION['error_message'] = "Chỉ còn $availableStock sản phẩm trong kho! Bạn đang yêu cầu $quantity sản phẩm.";
            header('Location: /websitePS/public/cart');
            exit();
        }
        
        // Cập nhật giỏ hàng dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            $cartModel = new CartModel();
            $result = $cartModel->updateCartItem($_SESSION['customer_id'], $productId, $quantity);
        } else {
            $sessionCartModel = new SessionCartModel();
            $result = $sessionCartModel->updateCartItem($productId, $quantity);
        }

        if ($result) {
            $_SESSION['success_message'] = 'Đã cập nhật giỏ hàng thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật giỏ hàng!';
        }

        header('Location: /websitePS/public/cart');
        exit();
    }

    public function remove($productId = null) {
        // Không cần kiểm tra đăng nhập - cho phép khách vãng lai xóa sản phẩm

        // Lấy productId từ URL parameter hoặc POST data
        if (!$productId) {
            $productId = $_POST['productId'] ?? null;
        }

        if (!$productId) {
            $_SESSION['error_message'] = 'Thông tin sản phẩm không hợp lệ!';
            header('Location: /websitePS/public/cart');
            exit();
        }

        // Khai báo các model trước
        $cartModel = null;
        $sessionCartModel = null;
        
        // Xóa sản phẩm dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            $cartModel = new CartModel();
            $result = $cartModel->removeCartItem($_SESSION['customer_id'], $productId);
        } else {
            $sessionCartModel = new SessionCartModel();
            $result = $sessionCartModel->removeCartItem($productId);
        }

        // Kiểm tra nếu là AJAX request
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        
        if ($result) {
            if ($isAjax) {
                // Lấy cart count mới
                $cartCount = 0;
                if (isset($_SESSION['customer_id']) && $cartModel) {
                    $cart = $cartModel->getCart($_SESSION['customer_id']);
                    if (!empty($cart)) {
                        foreach ($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    }
                } else {
                    if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                        foreach ($_SESSION['guest_cart'] as $item) {
                            $cartCount += $item['quantity'];
                        }
                    }
                }
                
                // Tính tổng tiền mới
                $cartTotal = 0;
                if (isset($_SESSION['customer_id']) && $cartModel) {
                    $cart = $cartModel->getCart($_SESSION['customer_id']);
                    if (!empty($cart)) {
                        foreach ($cart as $item) {
                            $cartTotal += $item['price'] * $item['quantity'];
                        }
                    }
                } else {
                    if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                        foreach ($_SESSION['guest_cart'] as $item) {
                            $cartCount += $item['quantity'];
                        }
                    }
                }
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng thành công!',
                    'cartCount' => $cartCount,
                    'cartTotal' => number_format($cartTotal, 0, ',', '.')
                ]);
                exit();
            } else {
                // Bỏ thông báo thành công khi xóa sản phẩm
                // $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng thành công!';
            }
        } else {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng!'
                ]);
                exit();
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng!';
            }
        }

        if (!$isAjax) {
            header('Location: /websitePS/public/cart');
            exit();
        }
    }

    public function clear() {
         // Không cần kiểm tra đăng nhập - cho phép khách vãng lai xóa giỏ hàng
 
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             header('Location: /websitePS/public/cart');
             exit();
         }
 
         // Xóa giỏ hàng dựa trên trạng thái đăng nhập
         if (isset($_SESSION['customer_id'])) {
             $cartModel = new CartModel();
             $result = $cartModel->clearCart($_SESSION['customer_id']);
         } else {
             $sessionCartModel = new SessionCartModel();
             $result = $sessionCartModel->clearCart();
         }
 
         if ($result) {
             $_SESSION['success_message'] = 'Đã xóa toàn bộ giỏ hàng thành công!';
         } else {
             $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa giỏ hàng!';
         }
 
         header('Location: /websitePS/public/cart');
         exit();
     }
 
     public function updatePromotions() {
         // Method riêng để xử lý AJAX request cho khuyến mãi
         if (session_status() === PHP_SESSION_NONE) {
             session_start();
         }
         
         // Chỉ cho phép POST request
         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             http_response_code(405);
             echo json_encode(['error' => 'Method not allowed']);
             return;
         }
         
         // Chỉ cho phép khách hàng đã đăng nhập
         if (!isset($_SESSION['customer_id'])) {
             http_response_code(403);
             echo json_encode(['error' => 'Unauthorized']);
             return;
         }
         
         try {
             $cartModel = new CartModel();
             $promotionModel = new PromotionModel();
             
             // Lấy giỏ hàng
             $cart = $cartModel->getCart($_SESSION['customer_id']);
             
             // Tính toán tổng tiền
             $total = 0;
             $productCategories = [];
             
             if (!empty($cart)) {
                 foreach ($cart as $item) {
                     $itemTotal = $item['price'] * $item['quantity'];
                     $total += $itemTotal;
                     
                     if (!empty($item['category'])) {
                         $productCategories[] = $item['category'];
                     }
                 }
             }
             
             // Lấy ưu đãi được chọn
             $selectedPromotions = [];
             
             // Debug: Kiểm tra POST data
             error_log("DEBUG updatePromotions: POST selected_promotions: " . (isset($_POST['selected_promotions']) ? json_encode($_POST['selected_promotions']) : 'NOT SET'));
             error_log("DEBUG updatePromotions: Session selected_promotions: " . (isset($_SESSION['selected_promotions']) ? json_encode($_SESSION['selected_promotions']) : 'NOT SET'));
             
             if (isset($_POST['selected_promotions']) && is_array($_POST['selected_promotions'])) {
                 // Giới hạn tối đa 3 khuyến mãi
                 $selectedPromotions = array_slice($_POST['selected_promotions'], 0, 3);
                 $_SESSION['selected_promotions'] = $selectedPromotions;
                 error_log("DEBUG updatePromotions: Set from POST: " . json_encode($selectedPromotions));
             } elseif (isset($_SESSION['selected_promotions'])) {
                 // Lấy từ session nếu không có POST data (khi refresh trang)
                 $selectedPromotions = $_SESSION['selected_promotions'];
                 error_log("DEBUG updatePromotions: Loaded from session: " . json_encode($selectedPromotions));
             } else {
                 error_log("DEBUG updatePromotions: No promotions selected");
             }
             
             // Tính toán ưu đãi
             $availablePromotions = [];
             $discountResult = [
                 'promotions' => [],
                 'totalDiscount' => 0,
                 'finalTotal' => $total,
                 'maxDiscount' => 0,
                 'discountPercentage' => 0
             ];
             $appliedPromotions = [];
             $totalDiscount = 0;
             $finalTotal = $total;
             $maxDiscount = 0;
             $discountPercentage = 0;
             
             if (!empty($cart)) {
                 $availablePromotions = $promotionModel->getAvailablePromotions($_SESSION['customer_id'], $total, implode(',', $productCategories));
                 $discountResult = $promotionModel->calculateAllDiscounts($_SESSION['customer_id'], $total, implode(',', $productCategories), $selectedPromotions);
                 
                 $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                     return isset($promotion['isSelected']) && $promotion['isSelected'];
                 });
                 
                 $totalDiscount = $discountResult['totalDiscount'];
                 $finalTotal = $discountResult['finalTotal'];
                 $maxDiscount = $discountResult['maxDiscount'];
                 $discountPercentage = $discountResult['discountPercentage'];
             }
             
             // Tính phí vận chuyển - tính cho TẤT CẢ đơn hàng có sản phẩm
             $shippingFee = 0;
             if (!empty($cart)) {
                 $shippingFee = 30000;
             }
             
             // Kiểm tra ưu đãi miễn phí vận chuyển (từ database)
             foreach ($appliedPromotions as $promotion) {
                 if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                     $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                     if (strpos($promotionName, 'FREESHIP') !== false) {
                         // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                         if ($total >= 500000) {
                             $shippingFee = 0;
                         }
                         break;
                     } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                         // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                         $shippingFee = 0;
                         break;
                     }
                 }
             }
             
             // Kiểm tra ưu đãi miễn phí vận chuyển (từ database)
             // CHỈ khách hàng đã đăng nhập mới được áp dụng FREESHIP
             if (isset($_SESSION['customer_id'])) {
                 foreach ($appliedPromotions as $promotion) {
                     if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                         $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                         if (strpos($promotionName, 'FREESHIP') !== false) {
                             // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                             if ($total >= 500000) {
                                 $shippingFee = 0;
                             }
                             break;
                         } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                             // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                             $shippingFee = 0;
                             break;
                         }
                     }
                 }
             } else {
                 // Khách vãng lai - LUÔN tính phí vận chuyển 30,000₫, KHÔNG áp dụng FREESHIP
             }
             
             // Tính tổng cuối cùng: Tổng tiền hàng - Giảm giá + Phí vận chuyển
             $finalTotal = $total - $totalDiscount + $shippingFee;
             
             // Trả về HTML của cart summary
             ob_start();
             include __DIR__ . '/../views/pages/cart_summary.php';
             $summaryHtml = ob_get_clean();
             
                           echo $summaryHtml;
              
          } catch (Exception $e) {
              http_response_code(500);
              echo json_encode(['error' => 'Internal server error']);
          }
      }
      
      public function updateQuantity() {
          // Method riêng để xử lý AJAX request cho cập nhật số lượng
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
                     // Debug logs removed for production
          
          // Chỉ cho phép POST request
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['error' => 'Method not allowed']);
              return;
          }
          
          $productId = $_POST['productId'] ?? null;
          $change = isset($_POST['change']) ? (int)$_POST['change'] : 0;
          
                     // Debug logs removed for production
          
          if (!$productId) {
              http_response_code(400);
              echo json_encode(['success' => false, 'message' => 'Thông tin sản phẩm không hợp lệ!']);
              return;
          }
          
          try {
              // Lấy số lượng hiện tại
              if (isset($_SESSION['customer_id'])) {
                  $cartModel = new CartModel();
                  $cart = $cartModel->getCart($_SESSION['customer_id']);
                                     // Debug logs removed for production
              } else {
                  $sessionCartModel = new SessionCartModel();
                  $cart = $sessionCartModel->getCart();
                                     // Debug logs removed for production
              }
              
                             // Debug logs removed for production
              
              $currentQuantity = $cart[$productId]['quantity'] ?? 0;
              $newQuantity = $currentQuantity + $change;
              
                             // Debug logs removed for production
              
              // Kiểm tra số lượng mới
              if ($newQuantity <= 0) {
                  // Bỏ thông báo lỗi, chỉ trả về response thành công nhưng không thay đổi gì
                  $response = [
                      'success' => true,
                      'newQuantity' => $currentQuantity,
                      'newSubtotal' => number_format($currentQuantity * ($cart[$productId]['price'] ?? 0), 0, ',', '.'),
                      'message' => ''
                  ];
                  
                                     // Debug logs removed for production
                  echo json_encode($response);
                  return;
              }
              
              // VALIDATION: Kiểm tra số lượng tồn kho
              require_once __DIR__ . '/../models/ProductModel.php';
              $productModel = new ProductModel();
              $product = $productModel->getProductById($productId);
              
              if (!$product) {
                  $response = ['success' => false, 'message' => 'Sản phẩm không tồn tại!'];
                  echo json_encode($response);
                  return;
              }
              
              $availableStock = $product['SoLuong'] ?? 0;
              
              // Kiểm tra nếu sản phẩm hết hàng
              if ($availableStock <= 0) {
                  $response = ['success' => false, 'message' => 'Sản phẩm này hiện đang hết hàng!'];
                  echo json_encode($response);
                  return;
              }
              
              // Kiểm tra số lượng mới không vượt quá tồn kho
              if ($newQuantity > $availableStock) {
                  $response = ['success' => false, 'message' => "Chỉ còn $availableStock sản phẩm trong kho! Bạn đang yêu cầu $newQuantity sản phẩm."];
                  echo json_encode($response);
                  return;
              }
              
              // Cập nhật số lượng
              if (isset($_SESSION['customer_id'])) {
                  $result = $cartModel->updateCartItem($_SESSION['customer_id'], $productId, $newQuantity);
              } else {
                  $result = $sessionCartModel->updateCartItem($productId, $newQuantity);
              }
              
                             // Debug logs removed for production
              
              if ($result) {
                  // Tính toán subtotal mới
                  $price = $cart[$productId]['price'] ?? 0;
                  $newSubtotal = $price * $newQuantity;
                  
                  $response = [
                      'success' => true,
                      'newQuantity' => $newQuantity,
                      'newSubtotal' => number_format($newSubtotal, 0, ',', '.'),
                      'message' => 'Đã cập nhật số lượng sản phẩm thành công!'
                  ];
                  
                                     // Debug logs removed for production
                  echo json_encode($response);
              } else {
                  $response = ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật số lượng!'];
                                     // Debug logs removed for production
                  echo json_encode($response);
              }
              
          } catch (Exception $e) {
                             // Debug logs removed for production
              http_response_code(500);
              echo json_encode(['success' => false, 'message' => 'Internal server error']);
          }
      }
      
      public function getSummary() {
          // Method riêng để lấy cart summary cho AJAX
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          try {
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              $promotionModel = new PromotionModel();
              $cart = [];
              
              // Lấy giỏ hàng dựa trên trạng thái đăng nhập
              if (isset($_SESSION['customer_id'])) {
                  $cart = $cartModel->getCart($_SESSION['customer_id']);
              } else {
                  $cart = $sessionCartModel->getCart();
              }
              
              // Tính toán tổng tiền
              $total = 0;
              $productCategories = [];
              
              if (!empty($cart)) {
                  foreach ($cart as $item) {
                      $itemTotal = $item['price'] * $item['quantity'];
                      $total += $itemTotal;
                      
                      if (!empty($item['category'])) {
                          $productCategories[] = $item['category'];
                      }
                  }
              }
              
              // Lấy ưu đãi được chọn
              $selectedPromotions = $_SESSION['selected_promotions'] ?? [];
              
              // Tính toán ưu đãi
              $availablePromotions = [];
              $discountResult = [
                  'promotions' => [],
                  'totalDiscount' => 0,
                  'finalTotal' => $total,
                  'maxDiscount' => 0,
                  'discountPercentage' => 0
              ];
              $appliedPromotions = [];
              $totalDiscount = 0;
              $finalTotal = $total;
              $maxDiscount = 0;
              $discountPercentage = 0;
              
              if (!empty($cart) && isset($_SESSION['customer_id'])) {
                  $availablePromotions = $promotionModel->getAvailablePromotions($_SESSION['customer_id'], $total, implode(',', $productCategories));
                  $discountResult = $promotionModel->calculateAllDiscounts($_SESSION['customer_id'], $total, implode(',', $productCategories), $selectedPromotions);
                  
                  $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                      return isset($promotion['isSelected']) && $promotion['isSelected'];
                  });
                  
                  $totalDiscount = $discountResult['totalDiscount'];
                  $finalTotal = $discountResult['finalTotal'];
                  $maxDiscount = $discountResult['maxDiscount'];
                  $discountPercentage = $discountResult['discountPercentage'];
              }
              
                           // Tính phí vận chuyển - tính cho TẤT CẢ đơn hàng có sản phẩm
             $shippingFee = 0;
             if (!empty($cart)) {
                 $shippingFee = 30000;
             }
             
             // Kiểm tra ưu đãi miễn phí vận chuyển (từ database)
             foreach ($appliedPromotions as $promotion) {
                 if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                     $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                     if (strpos($promotionName, 'FREESHIP') !== false) {
                         // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                         if ($total >= 500000) {
                             $shippingFee = 0;
                         }
                         break;
                     } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                         // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                         $shippingFee = 0;
                         break;
                     }
                 }
             }
             
             // Kiểm tra ưu đãi miễn phí vận chuyển (từ database)
             // CHỈ khách hàng đã đăng nhập mới được áp dụng FREESHIP
             if (isset($_SESSION['customer_id'])) {
                 foreach ($appliedPromotions as $promotion) {
                     if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                         $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                         if (strpos($promotionName, 'FREESHIP') !== false) {
                             // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                             if ($total >= 500000) {
                                 $shippingFee = 0;
                             }
                             break;
                         } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                             // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                             $shippingFee = 0;
                             break;
                         }
                     }
                 }
             } else {
                 // Khách vãng lai - LUÔN tính phí vận chuyển 30,000₫, KHÔNG áp dụng FREESHIP
             }
             
             // Tính tổng cuối cùng: Tổng tiền hàng - Giảm giá + Phí vận chuyển
             $finalTotal = $total - $totalDiscount + $shippingFee;
              
              // Trả về HTML của cart summary
              ob_start();
              include __DIR__ . '/../views/pages/cart_summary.php';
              $summaryHtml = ob_get_clean();
              
              echo $summaryHtml;
              
          } catch (Exception $e) {
              http_response_code(500);
              echo json_encode(['error' => 'Internal server error']);
          }
      }

      public function updateProductPromotions() {
          // Method riêng để xử lý AJAX request cho khuyến mãi sản phẩm đơn lẻ
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          // Chỉ cho phép POST request
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['error' => 'Method not allowed']);
              return;
          }
          
          // Chỉ cho phép khách hàng đã đăng nhập
          if (!isset($_SESSION['customer_id'])) {
              http_response_code(403);
              echo json_encode(['error' => 'Unauthorized']);
              return;
          }
          
          try {
              $promotionModel = new PromotionModel();
              
              // Lấy thông tin sản phẩm từ POST
              $productId = $_POST['product_id'] ?? null;
              
              if (!$productId) {
                  echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
                  return;
              }
              
              // Lấy thông tin sản phẩm
              require_once __DIR__ . '/../models/ProductModel.php';
              $productModel = new ProductModel();
              $product = $productModel->getProductById($productId);
              
              if (!$product) {
                  echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
                  return;
              }
              
              // Lấy ưu đãi được chọn
              $selectedPromotions = [];
              
              if (isset($_POST['selected_promotions']) && is_array($_POST['selected_promotions'])) {
                  // Giới hạn tối đa 3 khuyến mãi
                  $selectedPromotions = array_slice($_POST['selected_promotions'], 0, 3);
                  $_SESSION['selected_promotions'] = $selectedPromotions;
              } elseif (isset($_SESSION['selected_promotions'])) {
                  // Lấy từ session nếu không có POST data
                  $selectedPromotions = $_SESSION['selected_promotions'];
              }
              
              // Tính toán ưu đãi cho sản phẩm đơn lẻ
              $availablePromotions = $promotionModel->getAvailablePromotions(
                  $_SESSION['customer_id'], 
                  $product['DonGia'], 
                  $product['TenDanhMuc'] ?? null
              );
              
              $discountResult = $promotionModel->calculateAllDiscounts(
                  $_SESSION['customer_id'], 
                  $product['DonGia'], 
                  $product['TenDanhMuc'] ?? null, 
                  $selectedPromotions
              );
              
              $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                  return isset($promotion['isSelected']) && $promotion['isSelected'];
              });
              
              $totalDiscount = $discountResult['totalDiscount'];
              $finalPrice = $discountResult['finalTotal'];
              
              // Trả về JSON response
              header('Content-Type: application/json');
              echo json_encode([
                  'success' => true,
                  'message' => 'Cập nhật ưu đãi thành công!',
                  'totalDiscount' => $totalDiscount,
                  'finalPrice' => $finalPrice,
                  'originalPrice' => $product['DonGia'],
                  'appliedPromotions' => $appliedPromotions,
                  'availablePromotions' => $availablePromotions,
                  'selectedPromotions' => $selectedPromotions
              ]);
              
          } catch (Exception $e) {
              error_log("Error in updateProductPromotions: " . $e->getMessage());
              header('Content-Type: application/json');
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra khi cập nhật ưu đãi!'
              ]);
          }
      }

          /**
     * API để lấy thông tin giỏ hàng (JSON)
     */
    public function getCartApi() {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          try {
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              $promotionModel = new PromotionModel();
              
              $cart = [];
              $customerId = $_SESSION['customer_id'] ?? null;
              
              // Lấy giỏ hàng dựa trên trạng thái đăng nhập
              if ($customerId) {
                  $cart = $cartModel->getCart($customerId);
              } else {
                  $cart = $sessionCartModel->getCart();
              }
              
              // Tính toán tổng tiền
              $total = 0;
              $itemCount = 0;
              
              foreach ($cart as $item) {
                  $itemTotal = $item['price'] * $item['quantity'];
                  $total += $itemTotal;
                  $itemCount += $item['quantity'];
              }
              
              // Lấy ưu đãi được chọn
              $selectedPromotions = $_SESSION['selected_promotions'] ?? [];
              
              // Tính toán ưu đãi (chỉ cho khách hàng đã đăng nhập)
              $appliedPromotions = [];
              $totalDiscount = 0;
              $finalTotal = $total;
              
              if ($customerId) {
                  $productCategories = array_unique(array_column($cart, 'category'));
                  $discountResult = $promotionModel->calculateAllDiscounts(
                      $customerId, 
                      $total, 
                      implode(',', $productCategories), 
                      $selectedPromotions
                  );
                  
                  $appliedPromotions = array_filter($discountResult['promotions'], function($promotion) {
                      return isset($promotion['isSelected']) && $promotion['isSelected'];
                  });
                  $totalDiscount = $discountResult['totalDiscount'];
                  $finalTotal = $discountResult['finalTotal'];
              }
              
              // Tính phí vận chuyển - tính cho TẤT CẢ đơn hàng có sản phẩm
              $shippingFee = 0;
              if (!empty($cart)) {
                  $shippingFee = 30000;
              }
              
              // Kiểm tra ưu đãi miễn phí vận chuyển (từ database)
              // CHỈ khách hàng đã đăng nhập mới được áp dụng FREESHIP
              if (isset($_SESSION['customer_id'])) {
                  foreach ($appliedPromotions as $promotion) {
                      if (strpos($promotion['promotionType'], 'db_promo_') === 0) {
                          $promotionName = strtoupper($promotion['displayName'] ?? $promotion['description'] ?? '');
                          if (strpos($promotionName, 'FREESHIP') !== false) {
                              // FREESHIP chỉ áp dụng khi đơn hàng từ 500,000₫ trở lên
                              if ($total >= 500000) {
                                  $shippingFee = 0;
                              }
                              break;
                          } elseif (strpos(strtolower($promotion['description']), 'miễn phí vận chuyển') !== false) {
                              // Các mã khuyến mãi khác có mô tả "miễn phí vận chuyển" vẫn áp dụng bình thường
                              $shippingFee = 0;
                              break;
                          }
                      }
                  }
              } else {
                  // Khách vãng lai - LUÔN tính phí vận chuyển 30,000₫, KHÔNG áp dụng FREESHIP
              }
              
              // Tính tổng cuối cùng: Tổng tiền hàng - Giảm giá + Phí vận chuyển
              $finalTotal = $total - $totalDiscount + $shippingFee;
              
              header('Content-Type: application/json');
              echo json_encode([
                  'success' => true,
                  'data' => [
                      'cart' => $cart,
                      'summary' => [
                          'itemCount' => $itemCount,
                          'subtotal' => $total,
                          'totalDiscount' => $totalDiscount,
                          'shippingFee' => $shippingFee,
                          'finalTotal' => $finalTotal
                      ],
                      'promotions' => [
                          'selected' => $selectedPromotions,
                          'applied' => $appliedPromotions
                      ],
                      'customerId' => $customerId,
                      'isLoggedIn' => !is_null($customerId)
                  ]
              ]);
              
          } catch (Exception $e) {
              header('Content-Type: application/json');
              http_response_code(500);
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra khi lấy thông tin giỏ hàng',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

          /**
     * API để thêm sản phẩm vào giỏ hàng (JSON)
     */
    public function addToCartApi() {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['success' => false, 'message' => 'Method not allowed']);
              exit();
          }
          
          try {
              $productId = $_POST['product_id'] ?? null;
              $quantity = (int)($_POST['quantity'] ?? 1);
              
              if (!$productId || $quantity < 1) {
                  echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ']);
                  exit();
              }
              
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              
              $result = false;
              $customerId = $_SESSION['customer_id'] ?? null;
              
              if ($customerId) {
                  $result = $cartModel->addToCart($customerId, $productId, $quantity);
              } else {
                  $result = $sessionCartModel->addToCart($productId, $quantity);
              }
              
              if ($result) {
                  echo json_encode([
                      'success' => true,
                      'message' => 'Đã thêm sản phẩm vào giỏ hàng!'
                  ]);
              } else {
                  echo json_encode([
                      'success' => false,
                      'message' => 'Không thể thêm sản phẩm vào giỏ hàng'
                  ]);
              }
              
          } catch (Exception $e) {
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

          /**
     * API để cập nhật số lượng sản phẩm trong giỏ hàng (JSON)
     */
    public function updateCartApi() {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['success' => false, 'message' => 'Method not allowed']);
              exit();
          }
          
          try {
              $productId = $_POST['product_id'] ?? null;
              $quantity = (int)($_POST['quantity'] ?? 1);
              
              if (!$productId || $quantity < 0) {
                  echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ']);
                  exit();
              }
              
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              
              $result = false;
              $customerId = $_SESSION['customer_id'] ?? null;
              
              if ($customerId) {
                  if ($quantity === 0) {
                      $result = $cartModel->removeFromCart($customerId, $productId);
                  } else {
                      $result = $cartModel->updateQuantity($customerId, $productId, $quantity);
                  }
              } else {
                  if ($quantity === 0) {
                      $result = $sessionCartModel->removeFromCart($productId);
                  } else {
                      $result = $sessionCartModel->updateQuantity($productId, $quantity);
                  }
              }
              
              if ($result) {
                  echo json_encode([
                      'success' => true,
                      'message' => 'Đã cập nhật giỏ hàng!'
                  ]);
              } else {
                  echo json_encode([
                      'success' => false,
                      'message' => 'Không thể cập nhật giỏ hàng'
                  ]);
              }
              
          } catch (Exception $e) {
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

          /**
     * API để xóa sản phẩm khỏi giỏ hàng (JSON)
     */
    public function removeFromCartApi() {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['success' => false, 'message' => 'Method not allowed']);
              exit();
          }
          
          try {
              $productId = $_POST['product_id'] ?? null;
              
              if (!$productId) {
                  echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
                  exit();
              }
              
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              
              $result = false;
              $customerId = $_SESSION['customer_id'] ?? null;
              
              if ($customerId) {
                  $result = $cartModel->removeFromCart($customerId, $productId);
              } else {
                  $result = $sessionCartModel->removeFromCart($productId);
              }
              
              if ($result) {
                  echo json_encode([
                      'success' => true,
                      'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!'
                  ]);
              } else {
                  echo json_encode([
                      'success' => false,
                      'message' => 'Không thể xóa sản phẩm'
                  ]);
              }
              
          } catch (Exception $e) {
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

          /**
     * API để xóa toàn bộ giỏ hàng (JSON)
     */
    public function clearCartApi() {
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['success' => false, 'message' => 'Method not allowed']);
              exit();
          }
          
          try {
              $cartModel = new CartModel();
              $sessionCartModel = new SessionCartModel();
              
              $result = false;
              $customerId = $_SESSION['customer_id'] ?? null;
              
              if ($customerId) {
                  $result = $cartModel->clearCart($customerId);
              } else {
                  $result = $sessionCartModel->clearCart();
              }
              
              if ($result) {
                  echo json_encode([
                      'success' => true,
                      'message' => 'Đã xóa toàn bộ giỏ hàng!'
                  ]);
              } else {
                  echo json_encode([
                      'success' => false,
                      'message' => 'Không thể xóa giỏ hàng'
                  ]);
              }
              
          } catch (Exception $e) {
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

      /**
       * Áp dụng mã khuyến mãi từ input
       */
          public function applyCoupon() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit();
        }

        // Chỉ cho phép khách hàng đã đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để áp dụng mã khuyến mãi!']);
            exit();
        }

          try {
              $couponCode = trim($_POST['coupon_code'] ?? '');
              
              // Debug log
              error_log("DEBUG applyCoupon: Coupon code received: " . $couponCode);
              error_log("DEBUG applyCoupon: POST data: " . json_encode($_POST));
              
              if (empty($couponCode)) {
                  echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã khuyến mãi!']);
                  exit();
              }

              // Kiểm tra mã khuyến mãi trong database
              $promotionModel = new PromotionModel();
              
              // Lấy tổng tiền đơn hàng hiện tại để kiểm tra điều kiện
              $currentOrderTotal = 0;
              if (isset($_SESSION['customer_id'])) {
                  $cartModel = new CartModel();
                  $currentCart = $cartModel->getCart($_SESSION['customer_id']);
                  foreach ($currentCart as $item) {
                      $currentOrderTotal += $item['price'] * $item['quantity'];
                  }
              }
              
              // Debug log sau khi đã tính toán
              error_log("DEBUG applyCoupon: Current order total: " . $currentOrderTotal);
              
              $coupon = $promotionModel->validateCouponCode($couponCode, $currentOrderTotal);
              
              // Debug log
              error_log("DEBUG applyCoupon: Coupon validation result: " . json_encode($coupon));
              
              if (!$coupon) {
                  // Kiểm tra nếu là mã FREESHIP và đơn hàng không đủ tiêu chuẩn
                  if (strtoupper($couponCode) === 'FREESHIP' && $currentOrderTotal < 500000) {
                      echo json_encode(['success' => false, 'message' => 'Mã FREESHIP chỉ áp dụng cho đơn hàng từ 500,000₫ trở lên!']);
                      exit();
                  }
                  
                  echo json_encode(['success' => false, 'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn!']);
                  exit();
              }

              // Kiểm tra xem mã đã được áp dụng chưa
              $selectedPromotions = $_SESSION['selected_promotions'] ?? [];
              $couponPromotionType = 'db_promo_' . $coupon['MaKM'];
              
              // Debug log
              error_log("DEBUG applyCoupon: Selected promotions: " . json_encode($selectedPromotions));
              error_log("DEBUG applyCoupon: Coupon promotion type: " . $couponPromotionType);
              
              if (in_array($couponPromotionType, $selectedPromotions)) {
                  echo json_encode(['success' => false, 'message' => 'Mã khuyến mãi đã được áp dụng!']);
                  exit();
              }

              // Kiểm tra giới hạn số lượng khuyến mãi (tối đa 3)
              if (count($selectedPromotions) >= 3) {
                  echo json_encode(['success' => false, 'message' => 'Bạn chỉ có thể áp dụng tối đa 3 khuyến mãi!']);
                  exit();
              }

              // Lưu thông tin đầy đủ của mã khuyến mãi
              $couponInfo = [
                  'promotionType' => $couponPromotionType,
                  'displayName' => $coupon['displayName'] ?? $couponCode,
                  'description' => $coupon['description'] ?? '',
                  'discountPercent' => $coupon['PhanTramGiamGia'] ?? 0,
                  'discountAmount' => $coupon['SoTienGiamGia'] ?? 0
              ];
              
              // Lưu vào session với thông tin đầy đủ
              if (!isset($_SESSION['applied_coupons'])) {
                  $_SESSION['applied_coupons'] = [];
              }
              $_SESSION['applied_coupons'][$couponPromotionType] = $couponInfo;
              
              // Thêm mã khuyến mãi vào selected_promotions
              $selectedPromotions[] = $couponPromotionType;
              $_SESSION['selected_promotions'] = $selectedPromotions;
              
              // Debug log
              error_log("DEBUG applyCoupon: Updated selected promotions: " . json_encode($_SESSION['selected_promotions']));
              error_log("DEBUG applyCoupon: Applied coupon info: " . json_encode($couponInfo));

              echo json_encode([
                  'success' => true, 
                  'message' => 'Áp dụng mã khuyến mãi "' . $couponCode . '" thành công!'
              ]);

                    } catch (Exception $e) {
              error_log("Error in applyCoupon: " . $e->getMessage());
              echo json_encode([
                  'success' => false,
                  'message' => 'Có lỗi xảy ra khi áp dụng mã khuyến mãi',
                  'error' => $e->getMessage()
              ]);
          }
          exit();
      }

    /**
     * Bỏ mã khuyến mãi đã áp dụng
     */
    public function removeCoupon() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit();
        }

        // Chỉ cho phép khách hàng đã đăng nhập
        if (!isset($_SESSION['customer_id'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thao tác với mã khuyến mãi!']);
            exit();
        }

        try {
            $promotionType = trim($_POST['promotion_type'] ?? '');
            
            if (empty($promotionType)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin mã khuyến mãi!']);
                exit();
            }

            $selectedPromotions = $_SESSION['selected_promotions'] ?? [];
            
            // Tìm và xóa mã khuyến mãi
            $key = array_search($promotionType, $selectedPromotions);
            if ($key !== false) {
                unset($selectedPromotions[$key]);
                $_SESSION['selected_promotions'] = array_values($selectedPromotions); // Re-index array
                
                echo json_encode([
                    'success' => true, 
                    'message' => 'Đã bỏ mã khuyến mãi thành công!'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy mã khuyến mãi này!']);
            }

        } catch (Exception $e) {
            error_log("Error in removeCoupon: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi bỏ mã khuyến mãi',
                'error' => $e->getMessage()
            ]);
        }
        exit();
    }
  }
  ?>