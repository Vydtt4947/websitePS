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
        
        error_log("CartController::index() called");
        error_log("Session customer_id: " . (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 'not set'));
        
        try {
            $cartModel = new CartModel();
            $sessionCartModel = new SessionCartModel();
            $promotionModel = new PromotionModel();
            $cart = [];
            
            // Debug: Log request method
            error_log("Cart: Request method: " . $_SERVER['REQUEST_METHOD']);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                error_log("Cart: POST data: " . print_r($_POST, true));
            }
            
            // Lấy giỏ hàng dựa trên trạng thái đăng nhập
            if (isset($_SESSION['customer_id'])) {
                // Khách hàng đã đăng nhập - lấy từ database
                $cart = $cartModel->getCart($_SESSION['customer_id']);
                error_log("Cart items count (logged in): " . count($cart));
            } else {
                // Khách vãng lai - lấy từ session
                $cart = $sessionCartModel->getCart();
                error_log("Cart items count (guest): " . count($cart));
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
            
            error_log("Total cart value: " . $total);
            
            // Lấy ưu đãi được chọn từ session hoặc form
            $selectedPromotions = [];
            if (isset($_POST['promotion_form_submitted'])) {
                // Form đã được submit, sử dụng POST data
                $selectedPromotions = isset($_POST['selected_promotions']) && is_array($_POST['selected_promotions']) ? $_POST['selected_promotions'] : [];
                $_SESSION['selected_promotions'] = $selectedPromotions;
                error_log("Cart: Selected promotions from POST: " . print_r($selectedPromotions, true));
            } elseif (isset($_SESSION['selected_promotions'])) {
                $selectedPromotions = $_SESSION['selected_promotions'];
                error_log("Cart: Selected promotions from SESSION: " . print_r($selectedPromotions, true));
            } elseif (isset($_SESSION['promotion_from_page'])) {
                // Nếu có khuyến mãi từ trang khuyến mãi, tự động chọn
                $selectedPromotions = $_SESSION['promotion_from_page'];
                $_SESSION['selected_promotions'] = $selectedPromotions;
                error_log("Cart: Selected promotions from promotion page: " . print_r($selectedPromotions, true));
            } else {
                // Khởi tạo mảng rỗng - không chọn sẵn khuyến mãi cho khách hàng
                $selectedPromotions = [];
                error_log("Cart: No selected promotions found, initializing empty array");
            }
            
            error_log("Cart: Final selected promotions: " . print_r($selectedPromotions, true));
            
            // Debug: Log cart information
            error_log("Cart: Customer ID: " . (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 'not set'));
            error_log("Cart: Total value: " . $total);
            error_log("Cart: Product categories: " . implode(',', $productCategories));
            
            // Tính toán ưu đãi nếu có sản phẩm trong giỏ hàng và đã đăng nhập
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
            $availablePromotions = [];
            
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
                
                // Debug: Log promotion details
                error_log("Cart: Applied promotions: " . print_r($appliedPromotions, true));
                error_log("Cart: Discount percentage: " . $discountPercentage);
            }
            
            // Tính phí vận chuyển
            $shippingFee = 0;
            if ($finalTotal < 100000) {
                $shippingFee = 15000;
            }
            
            // Kiểm tra xem có ưu đãi miễn phí vận chuyển không
            foreach ($appliedPromotions as $promotion) {
                if ($promotion['promotionType'] === 'free_shipping') {
                    $shippingFee = 0;
                    break;
                }
            }
            
            $finalTotal += $shippingFee;
            
            // Debug: Log promotion calculation results
            error_log("Cart: Available promotions count: " . count($availablePromotions));
            error_log("Cart: Applied promotions count: " . count($appliedPromotions));
            error_log("Cart: Total discount: " . $totalDiscount);
            error_log("Cart: Final total: " . $finalTotal);
            error_log("Cart: Shipping fee: " . $shippingFee);
            
            error_log("About to include cart.php view");
            require_once __DIR__ . '/../views/pages/cart.php';
            error_log("Cart.php view included successfully");
            
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
            $_SESSION['error_message'] = 'Thông tin sản phẩm không hợp lệ!';
            header('Location: /websitePS/public/');
            exit();
        }

        // Xử lý giỏ hàng dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            // Khách hàng đã đăng nhập - lưu vào database
            $cartModel = new CartModel();
            $result = $cartModel->addCartItem($_SESSION['customer_id'], $productId, $quantity);
        } else {
            // Khách vãng lai - lưu vào session
            $sessionCartModel = new SessionCartModel();
            $result = $sessionCartModel->addCartItem($productId, $quantity);
        }

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

        // Xóa sản phẩm dựa trên trạng thái đăng nhập
        if (isset($_SESSION['customer_id'])) {
            $cartModel = new CartModel();
            $result = $cartModel->removeCartItem($_SESSION['customer_id'], $productId);
        } else {
            $sessionCartModel = new SessionCartModel();
            $result = $sessionCartModel->removeCartItem($productId);
        }

        if ($result) {
            // Bỏ thông báo thành công khi xóa sản phẩm
            // $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng!';
        }

        header('Location: /websitePS/public/cart');
        exit();
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
             if (isset($_POST['selected_promotions']) && is_array($_POST['selected_promotions'])) {
                 $selectedPromotions = $_POST['selected_promotions'];
                 $_SESSION['selected_promotions'] = $selectedPromotions;
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
             
             // Tính phí vận chuyển
             $shippingFee = 0;
             if ($finalTotal < 100000) {
                 $shippingFee = 15000;
             }
             
             // Kiểm tra ưu đãi miễn phí vận chuyển
             foreach ($appliedPromotions as $promotion) {
                 if ($promotion['promotionType'] === 'free_shipping') {
                     $shippingFee = 0;
                     break;
                 }
             }
             
             $finalTotal += $shippingFee;
             
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
          
          error_log("updateQuantity method called");
          error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
          error_log("POST data: " . print_r($_POST, true));
          
          // Chỉ cho phép POST request
          if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
              http_response_code(405);
              echo json_encode(['error' => 'Method not allowed']);
              return;
          }
          
          $productId = $_POST['productId'] ?? null;
          $change = isset($_POST['change']) ? (int)$_POST['change'] : 0;
          
          error_log("Product ID: " . $productId);
          error_log("Change: " . $change);
          
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
                  error_log("Using CartModel for logged in user");
              } else {
                  $sessionCartModel = new SessionCartModel();
                  $cart = $sessionCartModel->getCart();
                  error_log("Using SessionCartModel for guest user");
              }
              
              error_log("Current cart: " . print_r($cart, true));
              
              $currentQuantity = $cart[$productId]['quantity'] ?? 0;
              $newQuantity = $currentQuantity + $change;
              
              error_log("Current quantity: " . $currentQuantity);
              error_log("New quantity: " . $newQuantity);
              
              // Kiểm tra số lượng mới
              if ($newQuantity <= 0) {
                  // Bỏ thông báo lỗi, chỉ trả về response thành công nhưng không thay đổi gì
                  $response = [
                      'success' => true,
                      'newQuantity' => $currentQuantity,
                      'newSubtotal' => number_format($currentQuantity * ($cart[$productId]['price'] ?? 0), 0, ',', '.'),
                      'message' => ''
                  ];
                  
                  error_log("Quantity would be 0, returning current quantity without error");
                  echo json_encode($response);
                  return;
              }
              
              // Cập nhật số lượng
              if (isset($_SESSION['customer_id'])) {
                  $result = $cartModel->updateCartItem($_SESSION['customer_id'], $productId, $newQuantity);
              } else {
                  $result = $sessionCartModel->updateCartItem($productId, $newQuantity);
              }
              
              error_log("Update result: " . ($result ? 'true' : 'false'));
              
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
                  
                  error_log("Sending response: " . json_encode($response));
                  echo json_encode($response);
              } else {
                  $response = ['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật số lượng!'];
                  error_log("Sending error response: " . json_encode($response));
                  echo json_encode($response);
              }
              
          } catch (Exception $e) {
              error_log("Exception in updateQuantity: " . $e->getMessage());
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
              
              // Tính phí vận chuyển
              $shippingFee = 0;
              if ($finalTotal < 100000) {
                  $shippingFee = 15000;
              }
              
              // Kiểm tra ưu đãi miễn phí vận chuyển
              foreach ($appliedPromotions as $promotion) {
                  if ($promotion['promotionType'] === 'free_shipping') {
                      $shippingFee = 0;
                      break;
                  }
              }
              
              $finalTotal += $shippingFee;
              
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
  }
?>