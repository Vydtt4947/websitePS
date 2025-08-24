# 📚 HƯỚNG DẪN SỬ DỤNG API - WEBSITE PARROT SMELL

## 🚀 Tổng quan

Website Parrot Smell cung cấp đầy đủ các API endpoints để tương tác với hệ thống thông qua JSON. Tài liệu này hướng dẫn cách sử dụng tất cả các API có sẵn.

## 🔑 Xác thực và Session

### Đăng nhập để lấy Session
```bash
POST /websitePS/public/customerauth/loginApi
Content-Type: application/x-www-form-urlencoded

email=your_email@example.com&password=your_password
```

**Response thành công:**
```json
{
  "success": true,
  "message": "Đăng nhập thành công!",
  "data": {
    "customer": {
      "id": 1,
      "name": "Tên Khách Hàng",
      "email": "your_email@example.com",
      "phone": "0123456789"
    }
  }
}
```

### Lưu ý về Session
- Sau khi đăng nhập thành công, session sẽ được tạo tự động
- Sử dụng cookie session để duy trì trạng thái đăng nhập
- Một số API yêu cầu đăng nhập, một số không

---

## 🛍️ API SẢN PHẨM (Products)

### 1. Lấy danh sách sản phẩm
```bash
GET /websitePS/public/products/apiList
```

**Query Parameters:**
- `search`: Tìm kiếm theo tên hoặc mô tả
- `category`: Lọc theo danh mục
- `page`: Số trang (mặc định: 1)
- `sort`: Sắp xếp (name, price, newest)
- `limit`: Số sản phẩm mỗi trang (mặc định: 20)

**Ví dụ:**
```bash
GET /websitePS/public/products/apiList?search=bánh&category=1&page=1&sort=price&limit=10
```

**Response:**
```json
{
  "success": true,
  "data": {
    "products": [
      {
        "MaSP": 1,
        "TenSP": "Bánh Kem Socola",
        "DonGia": 150000,
        "MoTa": "Bánh kem socola thơm ngon",
        "SoLuong": 50,
        "HinhAnh": "banh-kem-socola.jpg",
        "TenDanhMuc": "Bánh Kem"
      }
    ],
    "categories": [...],
    "pagination": {
      "currentPage": 1,
      "totalPages": 5,
      "totalProducts": 100,
      "limit": 20
    },
    "filters": {
      "search": "bánh",
      "category": "1",
      "sort": "price"
    }
  }
}
```

### 2. Lấy chi tiết sản phẩm
```bash
GET /websitePS/public/products/apiShow/{productId}
```

**Ví dụ:**
```bash
GET /websitePS/public/products/apiShow/1
```

**Response:**
```json
{
  "success": true,
  "data": {
    "product": {
      "MaSP": 1,
      "TenSP": "Bánh Kem Socola",
      "DonGia": 150000,
      "MoTa": "Bánh kem socola thơm ngon",
      "SoLuong": 50,
      "HinhAnh": "banh-kem-socola.jpg",
      "TenDanhMuc": "Bánh Kem"
    },
    "relatedProducts": [...],
    "reviews": [...],
    "rating": 4.5,
    "reviewStats": {
      "total": 25,
      "average": 4.5,
      "distribution": {...}
    },
    "canReview": true
  }
}
```

### 3. Lấy thông tin tồn kho
```bash
GET /websitePS/public/products/getStockInfo/{productId}
```

---

## ⭐ API ĐÁNH GIÁ (Reviews)

### Lấy đánh giá sản phẩm
```bash
GET /websitePS/public/review/api/{productId}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "reviews": [
      {
        "MaDG": 1,
        "MaKH": 1,
        "MaSP": 1,
        "MaDH": 1,
        "SoSao": 5,
        "NoiDung": "Sản phẩm rất ngon!",
        "NgayTao": "2024-01-01 10:00:00",
        "TenKH": "Tên Khách Hàng"
      }
    ],
    "rating": 4.5,
    "productId": 1,
    "totalReviews": 25
  }
}
```

---

## 🎯 API KHUYẾN MÃI (Promotions)

### 1. Lấy tất cả khuyến mãi
```bash
GET /websitePS/public/promotion/api
```

**Response:**
```json
{
  "success": true,
  "data": {
    "promotions": [
      {
        "MaKM": 1,
        "TenKM": "LEQUOCKHANH",
        "MoTa": "Khuyến mãi lễ quốc khánh",
        "PhanTramGiamGia": 20,
        "SoTienGiamGia": null,
        "NgayBatDau": "2024-09-01",
        "NgayKetThuc": "2024-09-05"
      }
    ],
    "total": 1,
    "currentDate": "2024-01-01",
    "lastUpdated": "2024-01-01 12:00:00"
  }
}
```

### 2. Lấy khuyến mãi theo ID
```bash
GET /websitePS/public/promotion/apiShow/{promotionId}
```

### 3. Lấy khuyến mãi theo danh mục
```bash
GET /websitePS/public/promotion/apiByCategory/{categoryId}
```

### 4. Lấy khuyến mãi cho khách hàng cụ thể
```bash
GET /websitePS/public/promotion/apiForCustomer/{customerId}
```

---

## 🛒 API GIỎ HÀNG (Cart)

### 1. Lấy thông tin giỏ hàng
```bash
GET /websitePS/public/cart/getCartApi
```

**Response:**
```json
{
  "success": true,
  "data": {
    "cart": {
      "1": {
        "productId": 1,
        "name": "Bánh Kem Socola",
        "price": 150000,
        "quantity": 2,
        "subtotal": 300000
      }
    },
    "summary": {
      "itemCount": 2,
      "subtotal": 300000,
      "totalDiscount": 30000,
      "shippingFee": 15000,
      "finalTotal": 285000
    },
    "promotions": {
      "selected": [1],
      "applied": [...]
    },
    "customerId": 1,
    "isLoggedIn": true
  }
}
```

### 2. Thêm sản phẩm vào giỏ hàng
```bash
POST /websitePS/public/cart/addToCartApi
Content-Type: application/x-www-form-urlencoded

product_id=1&quantity=2
```

### 3. Cập nhật số lượng sản phẩm
```bash
POST /websitePS/public/cart/updateCartApi
Content-Type: application/x-www-form-urlencoded

product_id=1&quantity=3
```

### 4. Xóa sản phẩm khỏi giỏ hàng
```bash
POST /websitePS/public/cart/removeFromCartApi
Content-Type: application/x-www-form-urlencoded

product_id=1
```

### 5. Xóa toàn bộ giỏ hàng
```bash
POST /websitePS/public/cart/clearCartApi
```

---

## 📦 API ĐƠN HÀNG (Orders)

### 1. Lấy danh sách đơn hàng
```bash
GET /websitePS/public/customerorders/getOrdersApi
```
**Yêu cầu đăng nhập**

**Response:**
```json
{
  "success": true,
  "data": {
    "orders": [
      {
        "MaDH": 1,
        "NgayDat": "2024-01-01 10:00:00",
        "TongTien": 300000,
        "TenTrangThai": "Delivered",
        "DiaChiGiao": "123 Đường ABC, Quận 1, TP.HCM"
      }
    ],
    "statistics": {
      "total": 5,
      "pending": 1,
      "processing": 1,
      "shipped": 1,
      "delivered": 1,
      "cancelled": 1
    },
    "customerId": 1
  }
}
```

### 2. Lấy chi tiết đơn hàng
```bash
GET /websitePS/public/customerorders/getOrderDetailApi/{orderId}
```
**Yêu cầu đăng nhập**

### 3. Hủy đơn hàng
```bash
POST /websitePS/public/customerorders/cancelOrderApi/{orderId}
```
**Yêu cầu đăng nhập**

---

## 👤 API KHÁCH HÀNG (Customer)

### 1. Đăng nhập
```bash
POST /websitePS/public/customerauth/loginApi
Content-Type: application/x-www-form-urlencoded

email=your_email@example.com&password=your_password
```

### 2. Đăng ký
```bash
POST /websitePS/public/customerauth/registerApi
Content-Type: application/x-www-form-urlencoded

fullname=Tên Khách Hàng&email=your_email@example.com&password=your_password&phone=0123456789
```

### 3. Đăng xuất
```bash
POST /websitePS/public/customerauth/logoutApi
```

---

## 🧪 HƯỚNG DẪN TEST API VỚI POSTMAN

### 1. Thiết lập Postman

#### Tạo Environment Variables:
- `base_url`: `http://localhost/websitePS/public`
- `session_cookie`: (để lưu session sau khi đăng nhập)

#### Headers mặc định:
```
Content-Type: application/x-www-form-urlencoded
User-Agent: PostmanRuntime/7.32.3
```

### 2. Test API không cần đăng nhập

#### Test API sản phẩm:
```bash
GET {{base_url}}/products/apiList
GET {{base_url}}/products/apiShow/1
GET {{base_url}}/products/getStockInfo/1
```

#### Test API khuyến mãi:
```bash
GET {{base_url}}/promotion/api
GET {{base_url}}/promotion/apiShow/1
```

#### Test API đánh giá:
```bash
GET {{base_url}}/review/api/1
```

### 3. Test API cần đăng nhập

#### Bước 1: Đăng nhập
```bash
POST {{base_url}}/customerauth/loginApi
Body (x-www-form-urlencoded):
email: your_email@example.com
password: your_password
```

#### Bước 2: Lưu session cookie
- Sau khi đăng nhập thành công, copy `PHPSESSID` từ response headers
- Thêm vào Environment Variable `session_cookie`

#### Bước 3: Test các API cần đăng nhập
```bash
GET {{base_url}}/cart/getCartApi
Headers:
Cookie: PHPSESSID={{session_cookie}}

POST {{base_url}}/cart/addToCartApi
Headers:
Cookie: PHPSESSID={{session_cookie}}
Body:
product_id: 1
quantity: 2
```

### 4. Test API giỏ hàng

#### Lấy giỏ hàng:
```bash
GET {{base_url}}/cart/getCartApi
Headers:
Cookie: PHPSESSID={{session_cookie}}
```

#### Thêm sản phẩm:
```bash
POST {{base_url}}/cart/addToCartApi
Headers:
Cookie: PHPSESSID={{session_cookie}}
Body:
product_id: 1
quantity: 2
```

#### Cập nhật số lượng:
```bash
POST {{base_url}}/cart/updateCartApi
Headers:
Cookie: PHPSESSID={{session_cookie}}
Body:
product_id: 1
quantity: 3
```

### 5. Test API đơn hàng

#### Lấy danh sách đơn hàng:
```bash
GET {{base_url}}/customerorders/getOrdersApi
Headers:
Cookie: PHPSESSID={{session_cookie}}
```

#### Lấy chi tiết đơn hàng:
```bash
GET {{base_url}}/customerorders/getOrderDetailApi/1
Headers:
Cookie: PHPSESSID={{session_cookie}}
```

---

## 📋 MÃ LỖI HTTP

| Mã | Ý nghĩa | Mô tả |
|----|----------|-------|
| 200 | OK | Request thành công |
| 201 | Created | Tạo mới thành công |
| 400 | Bad Request | Dữ liệu request không hợp lệ |
| 401 | Unauthorized | Chưa đăng nhập hoặc session hết hạn |
| 403 | Forbidden | Không có quyền truy cập |
| 404 | Not Found | Không tìm thấy tài nguyên |
| 405 | Method Not Allowed | HTTP method không được hỗ trợ |
| 500 | Internal Server Error | Lỗi server |

---

## 🔒 BẢO MẬT

### Các biện pháp bảo mật:
1. **Session-based Authentication**: Sử dụng PHP session để xác thực
2. **CSRF Protection**: Bảo vệ chống tấn công CSRF
3. **Input Validation**: Kiểm tra và làm sạch dữ liệu đầu vào
4. **SQL Injection Protection**: Sử dụng PDO prepared statements
5. **XSS Protection**: Làm sạch dữ liệu đầu ra

### Lưu ý:
- Luôn sử dụng HTTPS trong môi trường production
- Không lưu trữ thông tin nhạy cảm trong session
- Thay đổi session ID sau khi đăng nhập thành công
- Giới hạn số lần đăng nhập thất bại

---

## 📱 SỬ DỤNG VỚI FRONTEND

### JavaScript Example:

#### Đăng nhập:
```javascript
async function login(email, password) {
  const formData = new FormData();
  formData.append('email', email);
  formData.append('password', password);
  
  const response = await fetch('/websitePS/public/customerauth/loginApi', {
    method: 'POST',
    body: formData
  });
  
  const data = await response.json();
  if (data.success) {
    console.log('Đăng nhập thành công:', data.data.customer);
  }
}
```

#### Lấy danh sách sản phẩm:
```javascript
async function getProducts(search = '', category = '', page = 1) {
  const params = new URLSearchParams({
    search,
    category,
    page,
    sort: 'name',
    limit: 20
  });
  
  const response = await fetch(`/websitePS/public/products/apiList?${params}`);
  const data = await response.json();
  
  if (data.success) {
    console.log('Sản phẩm:', data.data.products);
  }
}
```

#### Thêm vào giỏ hàng:
```javascript
async function addToCart(productId, quantity) {
  const formData = new FormData();
  formData.append('product_id', productId);
  formData.append('quantity', quantity);
  
  const response = await fetch('/websitePS/public/cart/addToCartApi', {
    method: 'POST',
    body: formData
  });
  
  const data = await response.json();
  if (data.success) {
    console.log('Đã thêm vào giỏ hàng:', data.message);
  }
}
```

---

## 🚨 XỬ LÝ LỖI

### Cấu trúc response lỗi:
```json
{
  "success": false,
  "message": "Mô tả lỗi",
  "error": "Chi tiết lỗi (nếu có)"
}
```

### Xử lý lỗi trong JavaScript:
```javascript
async function handleApiCall(apiFunction) {
  try {
    const response = await apiFunction();
    const data = await response.json();
    
    if (data.success) {
      return data.data;
    } else {
      throw new Error(data.message);
    }
  } catch (error) {
    console.error('API Error:', error.message);
    // Hiển thị thông báo lỗi cho người dùng
    showErrorMessage(error.message);
  }
}
```

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề khi sử dụng API:

1. **Kiểm tra Console**: Xem lỗi trong Developer Tools
2. **Kiểm tra Network**: Xem request/response trong Network tab
3. **Kiểm tra Session**: Đảm bảo session còn hiệu lực
4. **Kiểm tra Database**: Đảm bảo database hoạt động bình thường
5. **Liên hệ Admin**: Nếu vấn đề vẫn tiếp tục

---

## 🔄 CẬP NHẬT

- **Phiên bản**: 1.0.0
- **Ngày cập nhật**: 2024-01-01
- **Thay đổi**: 
  - Thêm API khuyến mãi
  - Cải thiện response format
  - Thêm validation và error handling

---

*Tài liệu này được cập nhật lần cuối vào: 2024-01-01*
