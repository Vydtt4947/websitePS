Model: Tầng xử lý dữ liệu (kết nối DB, truy vấn, logic nghiệp vụ liên quan đến dữ liệu).
View: Tầng giao diện hiển thị dữ liệu cho người dùng (HTML, CSS, JS).
Controller: Tầng trung gian, nhận request từ người dùng, gọi Model xử lý dữ liệu và trả kết quả ra View.

Dựa trên yêu cầu này, hệ thống của bạn không phải chỉ là shop đơn giản mà là cửa hàng bánh ngọt có quản trị đa vai trò (Admin + Nhân viên + Khách hàng) → cấu trúc file và chức năng cần rõ ràng để dễ mở rộng.

1. Models (14 models)
UserModel → quản lý tài khoản người dùng (bao gồm cả role: admin, staff, member)

CustomerModel → quản lý thông tin khách hàng (thông tin cá nhân, tích điểm, nhiều địa chỉ)

StaffModel → quản lý nhân viên

CategoryModel → danh mục sản phẩm (nếu cần phân loại bánh ngọt)

ProductModel → sản phẩm (có đánh giá, ảnh, mô tả)

PromotionModel → khuyến mãi

OrderModel → đơn hàng + trạng thái

OrderDetailModel → chi tiết đơn hàng

OrderHistoryModel → lịch sử thay đổi trạng thái đơn hàng

InventoryModel → tồn kho + nguyên liệu

AddressModel → nhiều địa chỉ của khách hàng

PaymentModel → thanh toán đơn hàng

ReviewModel → đánh giá sản phẩm

DashboardModel → dữ liệu thống kê doanh số, khách hàng mới, sản phẩm bán chạy

2. Controllers
A. Admin Controllers (8)
AdminController → Dashboard + báo cáo nhanh

AdminUserController → quản lý tài khoản người dùng (nâng quyền, khóa/mở tài khoản)

AdminCustomerController → quản lý thông tin khách hàng

AdminStaffController → quản lý thông tin nhân viên

AdminOrderController → quản lý đơn hàng

AdminPromotionController → quản lý khuyến mãi

AdminInventoryController → quản lý nguyên liệu + tồn kho

AdminProductController → quản lý thông tin sản phẩm

B. Nhân viên Controllers (3)
(có thể dùng chung một số với Admin nhưng giới hạn quyền)

StaffProductController → xem danh sách sản phẩm, khuyến mãi

StaffOrderController → xem và xác nhận đơn hàng, xác nhận thanh toán

StaffInventoryController → xem và nhập tồn kho, viết báo cáo

C. Khách hàng Controllers (6)
HomeController → hiển thị sản phẩm, danh mục

ProductController → chi tiết sản phẩm, tìm kiếm

CartController → giỏ hàng

CheckoutController → đặt hàng, thanh toán

CustomerController → quản lý tài khoản, nhiều địa chỉ, tích điểm, lịch sử đơn hàng

ReviewController → đánh giá sản phẩm

D. Khách vãng lai
Dùng chung controller với khách hàng (Home, Product, Cart) nhưng check login trước khi Checkout.

3. Views (đề xuất cấu trúc)
arduino
Sao chép
Chỉnh sửa
views/
 ├── admin/
 │    ├── layouts/
 │    ├── auth/
 │    │     ├── login.php
 │    │     └── register.php
 │    ├── dashboard.php
 │    ├── users/
 │    ├── customers/
 │    ├── staffs/
 │    ├── orders/
 │    ├── promotions/
 │    ├── inventory/
 │    └── products/
 │
 ├── staff/
 │    ├── orders/
 │    ├── inventory/
 │    ├── products/
 │    └── reports/
 │
 ├── pages/
 │    ├── layouts/
 │    ├── home/
 │    │     └── homepage.php
 │    ├── products/
 │    │     ├── product_detail.php
 │    │     └── product_list.php
 │    ├── cart/
 │    │     └── cart.php
 │    ├── checkout/
 │    │     ├── checkout.php
 │    │     └── thankyou.php
 │    ├── account/
 │    │     ├── account.php
 │    │     ├── account_profile.php
 │    │     └── address.php
 │    └── auth/
 │          ├── login.php
 │          └── register.php
4. Quyền người dùng
Admin: Full CRUD tất cả module + thống kê + quản lý quyền người dùng.

Nhân viên: chỉ được xem sản phẩm, xem/duyệt đơn hàng, xác nhận thanh toán, cập nhật tồn kho, viết báo cáo.

Khách hàng: đặt hàng, quản lý địa chỉ, xem lịch sử, tích điểm, đánh giá sản phẩm.

Khách vãng lai: chỉ xem và thêm vào giỏ hàng, muốn mua phải đăng ký.