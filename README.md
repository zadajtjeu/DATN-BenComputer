# Đồ án tốt nghiệp
XÂY DỰNG WEBSITE BÁN LAPTOP VÀ PHỤ KIỆN BEN COMPUTER BẰNG PHP & MySQL (LARAVEL)

GVHD	:	TS. Đặng Trọng Hợp

Sinh viên	:	Phạm Thanh Nam

Mã sinh viên	:	2018604735



# HƯỚNG DẪN SỬ DỤNG

### Mục lục

[I. Mở đầu](#begin)

[II. Cài đặt](#install)
- [1. Yêu cầu](#requirements)
- [2. Cấu trúc](#requirements)
- [3. Triển khai](#deploy)
- [4. Chạy chương trình](#run)
	
[III. Sử dụng](#usage)
- [1. Đăng nhập](#login)
- [2. Giới thiệu chức năng](#functions)

[Câu hỏi thường gặp](#faq)

===========================

<a name="begin"></a>
## I. Mở đầu

Ứng dụng web bán hàng Ben Computer giúp tạo một trang bán hàng điện tử một cách nhanh chóng và thuận tiện. Có những chức năng như:
- Login
- Register
- Logout
- View Products List
- View Product Details
- Search Product
- View Order History
- Rating
- Cart
- Checkout
- Product Management
- Order Management
- Post Management
- Post Type Management
- Category Management
- Brand Management
- User Management
- Vocher Management

<a name="instal"></a>
## II. Cài đặt 

<a name="requirements"></a>
### 1. Yêu cầu

- Webserver: Apache hoặc Web server tương đương
- Ngôn ngữ lập trình: PHP 7.4 trở lên
- Cơ sở dữ liệu: MySQL 8.0
- Framework: Laravel 8.0
- NodeJS: npm version 8
- Bower: version 1.8
- Composer: version 2.3.5


<a name="libraries"></a>
### 2. Cấu trúc

- Front End: HTML, CSS, JS, Bootstrap, Jquery, Truemart Theme [5], Admin LTE 3 [6], ChartJS, …
- Backend: Framework Laravel 8, PHP, MVC Design pattern
- DBMS: MySQL & phpmyadmin
- Web server: Apache2

<a name=deploy></a>
### 3. Triển khai

**Bước 1: Thực hiện clone git hoặc giải nén source code.**

**Bước 2: Sử dụng Terminal, chuyển đến thư mục vừa giải nén source code, Chạy các câu lệnh để cài các gói cần thiết**
```sh
composer install
npm install
bower install
```

**Bước 3: Tạo database và config database**

Thực hiện tạo mới một databse trên Mysql.

Sau đó ta thực hiện lệnh sau để copy ra file env:
```sh
cp .env.example .env
```
Cập nhật file env của bạn với các thông số của DB và các thông số khác:
```
DB_CONNECTION=mysql          
DB_HOST=127.0.0.1            
DB_PORT=3306                 
DB_DATABASE=dbname
DB_USERNAME=root             
DB_PASSWORD= 
```

Cài đặt các biến để gửi mail quan SMTP
```
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Đăng ký tài khoản test ở https://sandbox.vnpayment.vn/devreg/ và điền các thông số
```
VNP_TMN_CODE=
VNP_HASH_SECRET=
VNP_URL=http://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNP_QUERYDR=https://sandbox.vnpayment.vn/merchant_webapi/merchant.html
```

**Bước 4: Tạo ra key cho dự án**
```sh
php artisan key:gen
```

**Bước 5: Tạo ra các bảng và dữ liệu mẫu cho database**
```sh
php artisan migrate
php artisan db:seed
php artisan db:seed --class=AddressSeeder
```

**Bước 6: Xây dựng các styles và scripts**
```sh
npm run dev
```
**Bước 7: Storage:link**
```sh
php artisan storage:link
```

Sau khi cài dự án bạn phải chạy lệnh trên để public thư mục lưu trữ của bạn khi người dùng upload ảnh.


<a name="run"></a>
### 4. Chạy chương trình

- Có thể chạy trên môi trường
```sh
php artisan server
```
- Nếu không bạn cần chạy với đường dẫn trở đến thư mục `public`


<a name="usage"></a>
## III. Sử dụng

<a name="login"></a>
### Đăng nhập

Trước khi truy cập vào hệ thống, bắt buộc người dùng phải đăng nhập với tài khoản được cấp phép.

Mội số tài khoản mặc định: 

| Tài khoản | Mật khẩu | Quyền|
|-----------|----------|------
| admin@nam.name.vn | 12345678 | admin |
| manager@nam.name.vn | 12345678 | manager |
| user@nam.name.vn | 12345678 | user |
| user2@nam.name.vn | 12345678 | user banned |

<a name="functions"></a>
### Giới thiệu chức năng

Click để xem chi tiết.
[{owner}/{repository}#PR](https://github.com/{owner}/{repository}/pulls)

<a name="faq"></a>
## Câu hỏi thường gặp

**Lỗi ABC**


# Copyright
- Đồ án tốt nghiệp &copy; Phạm Thanh Nam - 2018604735 - HAUI
