# YÊU CẦU NGƯỜI DÙNG & PHÂN TÍCH THIẾT KẾ HỆ THỐNG - RISE FITNESS

Tài liệu đặc tả các yêu cầu người dùng, sơ đồ phân rã chức năng (FDD), sơ đồ Use Case tổng quát và chi tiết các luồng nghiệp vụ hệ thống.

---

## A. Sơ đồ phân rã chức năng (Functional Decomposition Diagram - FDD)

Sơ đồ phân rã chức năng dưới đây thể hiện cấu trúc phân cấp các tính năng dành cho đối tượng **Khách hàng** và **Quản trị viên** trong hệ thống Rise Fitness:

```mermaid
graph TD
    %% Định nghĩa Style
    classDef default fill:#111827,stroke:#374151,stroke-width:1px,color:#d1d5db,font-family:Arial,font-size:12px;
    classDef root fill:#1e293b,stroke:#3b82f6,stroke-width:2px,color:#ffffff,font-size:14px,font-weight:bold;
    classDef actor fill:#1e1b4b,stroke:#6366f1,stroke-width:2px,color:#ffffff,font-size:13px,font-weight:bold;
    classDef module fill:#312e81,stroke:#818cf8,stroke-width:1.5px,color:#ffffff,font-size:12px,font-weight:bold;
    classDef leaf fill:#1f2937,stroke:#4b5563,stroke-width:1px,color:#e5e7eb,font-size:11px;

    ROOT[Website kinh doanh phòng GYM & Fitness<br/>Rise Fitness]:::root
    
    KH[Khách hàng / Khách vãng lai]:::actor
    AD[Quản trị viên]:::actor
    
    ROOT --> KH
    ROOT --> AD

    %% ================= KHÁCH HÀNG =================
    QLTK[Quản lý tài khoản]:::module
    DKTT[Đăng ký tập thử]:::module
    MGT[Mua gói tập]:::module
    MSP[Mua sản phẩm & Giỏ hàng]:::module
    DSK[Đo sức khỏe]:::module

    KH --> QLTK
    KH --> DKTT
    KH --> MGT
    KH --> MSP
    KH --> DSK

    %% Quản lý tài khoản
    QLTK_1[Đăng nhập]:::leaf
    QLTK_2[Đăng ký]:::leaf
    QLTK_3[Đặt lại mật khẩu]:::leaf
    QLTK_4[Chỉnh sửa thông tin cá nhân]:::leaf
    QLTK_5[Quên mật khẩu]:::leaf
    QLTK_6[Đăng xuất]:::leaf

    QLTK --> QLTK_1
    QLTK --> QLTK_2
    QLTK --> QLTK_3
    QLTK --> QLTK_4
    QLTK --> QLTK_5
    QLTK --> QLTK_6

    %% Đăng ký tập thử
    DKTT_1[Xem danh sách lớp học]:::leaf
    DKTT_2[Xem chi tiết thông tin lớp học]:::leaf
    DKTT_3[Đăng ký giữ chỗ lớp học]:::leaf
    DKTT_4[Đăng ký tập thử]:::leaf

    DKTT --> DKTT_1
    DKTT --> DKTT_2
    DKTT --> DKTT_3
    DKTT --> DKTT_4

    %% Mua gói tập
    MGT_1[Xem danh sách gói tập]:::leaf
    MGT_2[Xem chi tiết gói tập]:::leaf
    MGT_3[Thanh toán gói tập]:::leaf
    MGT_4[Nhận thông báo sắp hết hạn]:::leaf
    MGT_5[Gia hạn gói tập]:::leaf
    MGT_6[Xem lịch sử mua/gia hạn gói tập]:::leaf

    MGT --> MGT_1
    MGT --> MGT_2
    MGT --> MGT_3
    MGT --> MGT_4
    MGT --> MGT_5
    MGT --> MGT_6

    %% Mua sản phẩm
    MSP_1[Xem danh sách sản phẩm]:::leaf
    MSP_2[Lọc, tìm kiếm sản phẩm]:::leaf
    MSP_3[Thêm & Cập nhật giỏ hàng]:::leaf
    MSP_4[Đặt hàng nhanh Guest Checkout]:::leaf
    MSP_5[Tra cứu đơn hàng vãng lai]:::leaf

    MSP --> MSP_1
    MSP --> MSP_2
    MSP --> MSP_3
    MSP --> MSP_4
    MSP --> MSP_5

    %% Đo sức khỏe
    DSK_1[Nhập thông tin cơ thể]:::leaf
    DSK_2[Tính toán các chỉ số BMI, TDEE, BMR]:::leaf

    DSK --> DSK_1
    DSK --> DSK_2

    %% ================= QUẢN TRỊ VIÊN =================
    QLGT_AD[Quản lý gói tập]:::module
    QLDH_AD[Quản lý đơn hàng]:::module
    QLSP_AD[Quản lý sản phẩm]:::module
    QLND_AD[Quản lý người dùng]:::module
    BCTK_AD[Báo cáo thống kê]:::module

    AD --> QLGT_AD
    AD --> QLDH_AD
    AD --> QLSP_AD
    AD --> QLND_AD
    AD --> BCTK_AD

    %% Quản lý gói tập Admin
    QLGT_1[Cập nhật gói tập/Giá gói]:::leaf
    QLGT_2[Duyệt & kích hoạt hạn tập]:::leaf
    QLGT_3[Phân công Huấn luyện viên PT]:::leaf
    QLGT_AD --> QLGT_1
    QLGT_AD --> QLGT_2
    QLGT_AD --> QLGT_3

    %% Quản lý đơn hàng Admin
    QLDH_1[Xem danh sách & chi tiết đơn]:::leaf
    QLDH_2[Cập nhật trạng thái giao hàng]:::leaf
    QLDH_3[Duyệt lịch đăng ký tập thử]:::leaf
    QLDH_AD --> QLDH_1
    QLDH_AD --> QLDH_2
    QLDH_AD --> QLDH_3

    %% Quản lý sản phẩm Admin
    QLSP_1[Thêm/Sửa/Xóa sản phẩm]:::leaf
    QLSP_2[Quản lý danh mục & biến thể size]:::leaf
    QLSP_3[Cấu hình mã khuyến mãi & Freeship]:::leaf
    QLSP_AD --> QLSP_1
    QLSP_AD --> QLSP_2
    QLSP_AD --> QLSP_3

    %% Quản lý người dùng Admin
    QLND_1[Phân quyền tài khoản]:::leaf
    QLND_2[Khóa/Mở tài khoản khách]:::leaf
    QLND_3[Hệ thống Chat support tư vấn]:::leaf
    QLND_AD --> QLND_1
    QLND_AD --> QLND_2
    QLND_AD --> QLND_3

    %% Báo cáo thống kê Admin
    BCTK_1[Biểu đồ thống kê doanh thu]:::leaf
    BCTK_2[Biểu đồ thống kê đơn hàng]:::leaf
    BCTK_3[Biểu đồ thống kê lượt tập thử]:::leaf
    BCTK_AD --> BCTK_1
    BCTK_AD --> BCTK_2
    BCTK_AD --> BCTK_3
```

---

## B. Sơ đồ Use Case tổng quát (General Use Case Diagram)

Sơ đồ thể hiện mối quan hệ giữa các Actor và các chức năng chính trong hệ thống:

```mermaid
flowchart LR
    %% Định nghĩa Style
    classDef actor fill:#1e1b4b,stroke:#6366f1,stroke-width:2px,color:#ffffff,font-size:12px;
    classDef uc fill:#111827,stroke:#10b981,stroke-width:1.5px,color:#d1d5db,font-size:11px;

    %% Định nghĩa Actors
    KVL((Khách vãng lai)):::actor
    KH((Khách hàng)):::actor
    AD((Quản trị viên)):::actor
    SYS((Hệ thống)):::actor

    subgraph "Hệ thống Quản lý Rise Fitness"
        %% Nhóm Khách hàng & Vãng lai
        UC_Auth(Đăng ký / Đăng nhập / Quên MK):::uc
        UC_DKTT(Đăng ký tập thử dịch vụ):::uc
        UC_DKGT(Đăng ký & Thanh toán gói tập):::uc
        UC_XemSP(Xem sản phẩm & Lọc kích cỡ):::uc
        UC_MuaSP(Đặt mua sản phẩm & Checkout):::uc
        UC_DGV(Viết đánh giá sản phẩm đã mua):::uc
        UC_TCDH(Tra cứu đơn hàng vãng lai):::uc
        UC_BMI(Đo sức khỏe & Tính chỉ số):::uc
        UC_Chat(Chat trực tuyến với hỗ trợ viên):::uc

        %% Nhóm Admin
        UC_QLGT(Quản lý gói tập & Kích hoạt hội viên):::uc
        UC_QLSP(Quản lý hàng hóa, danh mục & size):::uc
        UC_QLDH(Quản lý & Cập nhật trạng thái đơn hàng):::uc
        UC_QLND(Quản lý người dùng & Phân quyền):::uc
        UC_BCTK(Xem báo cáo & Biểu đồ doanh thu):::uc
        
        %% Nhóm Hệ thống
        UC_MailRecall(Gửi email nhắc lịch tập thử):::uc
        UC_ExpireRecall(Cập nhật tự động hạn gói tập):::uc
    end

    %% Mối liên kết Khách vãng lai
    KVL --> UC_Auth
    KVL --> UC_DKTT
    KVL --> UC_XemSP
    KVL --> UC_MuaSP
    KVL --> UC_TCDH
    KVL --> UC_BMI

    %% Mối liên kết Khách hàng
    KH --> UC_Auth
    KH --> UC_DKTT
    KH --> UC_DKGT
    KH --> UC_XemSP
    KH --> UC_MuaSP
    KH --> UC_DGV
    KH --> UC_TCDH
    KH --> UC_BMI
    KH --> UC_Chat

    %% Mối liên kết Admin
    AD --> UC_QLGT
    AD --> UC_QLSP
    AD --> UC_QLDH
    AD --> UC_QLND
    AD --> UC_BCTK
    AD --> UC_Chat

    %% Mối liên kết Hệ thống
    SYS --> UC_MailRecall
    SYS --> UC_ExpireRecall
```

---

## C. Phân rã và vẽ sơ đồ các luồng nghiệp vụ chi tiết

### 1. Luồng Mua hàng Không Đăng nhập (Guest Checkout Flow)

Luồng này dành cho Khách vãng lai muốn mua sắm trực tuyến nhanh chóng mà không cần đăng ký tài khoản. Hệ thống sử dụng Session để quản lý giỏ hàng tạm thời và ghi nhận đơn hàng với mã khách hàng (`id_nd`) là `null`.

```mermaid
sequenceDiagram
    autonumber
    actor KVL as Khách vãng lai
    participant Web as Giao diện Website
    participant Controller as CartController
    participant DB as Cơ sở dữ liệu (MySQL)
    participant VNPay as Cổng thanh toán VNPay
    participant Mail as Hệ thống Mail (SMTP)

    KVL->>Web: Chọn sản phẩm & chọn size
    Web->>Controller: Thêm vào giỏ hàng (Session)
    KVL->>Web: Vào giỏ hàng -> Tiến hành thanh toán
    Web-->>KVL: Hiển thị Form thông tin nhận nhận hàng
    KVL->>Web: Điền: Họ tên, Email, SĐT, Địa chỉ, Thành phố
    KVL->>Web: Chọn phương thức thanh toán (COD hoặc VNPay)
    KVL->>Web: Nhấn "Đặt hàng"
    Web->>Controller: Gửi request dathang() / vnpay()
    
    activate Controller
    Controller->>DB: Xác thực thông tin đầu vào & kiểm tra tồn kho theo size
    activate DB
    DB-->>Controller: Trả về số lượng tồn kho thực tế
    deactivate DB

    alt Không đủ tồn kho
        Controller-->>Web: Trả về thông báo lỗi "Sản phẩm không đủ tồn kho"
        Web-->>KVL: Hiển thị cảnh báo và dừng giao dịch
    else Đủ tồn kho
        Controller->>DB: Lưu đơn hàng mới (trạng thái: 'Chờ xác nhận', id_nd: null)
        
        alt Chọn thanh toán VNPay
            Controller->>VNPay: Tạo URL thanh toán & redirect khách
            KVL->>VNPay: Thực hiện thanh toán trực tuyến bảo mật
            VNPay-->>Controller: Trả kết quả giao dịch (IPN/Callback)
            Controller->>DB: Cập nhật trạng thái đơn hàng & ghi nhận mã giao dịch
        end
        
        Controller->>Mail: Gửi email xác nhận đơn hàng qua SMTP
        activate Mail
        Mail-->>KVL: Gửi email thông báo chi tiết đơn hàng
        deactivate Mail
        
        Controller-->>Web: Hiển thị trang thông báo đặt hàng thành công
        deactivate Controller
        Web-->>KVL: Hiển thị mã đơn hàng & hướng dẫn tra cứu
    end
```

---

### 2. Luồng Đăng ký & Kích hoạt gói tập hội viên (Gym Package Registration & Activation)

Luồng nghiệp vụ xử lý khi khách hàng đăng ký dịch vụ tập luyện trực tuyến và hệ thống tự động hóa kích hoạt gói tập sau khi nhận thanh toán.

```mermaid
sequenceDiagram
    autonumber
    actor KH as Khách hàng
    participant Web as Giao diện Website
    participant Admin as Admin Dashboard
    participant Controller as GoiTapController
    participant DB as Cơ sở dữ liệu (MySQL)
    participant Mail as Hệ thống Mail (SMTP)

    KH->>Web: Chọn gói tập (Silver/Gold/Diamond) + Chọn mốc tháng (1/3/6/12)
    KH->>Web: Tùy chọn thuê PT (Huấn luyện viên cá nhân)
    Note over Web: Tự động tính tiền = Giá gói + (Phụ phí PT * Số tháng)
    KH->>Web: Điền ghi chú & nhấn "Xác nhận đăng ký"
    Web->>Controller: Gửi request registerStore()
    
    activate Controller
    Controller->>DB: Sinh mã đăng ký duy nhất RF-XXXXXX & Lưu dạng 'cho_thanh_toan'
    Controller->>Mail: Gửi email hướng dẫn thanh toán kèm mã RF-XXXXXX
    Mail-->>KH: Email hướng dẫn chuyển khoản ngân hàng
    Controller-->>Web: Điều hướng sang trang Lịch sử đăng ký với trạng thái 'Chờ thanh toán'
    deactivate Controller

    KH->>Admin: Thực hiện chuyển khoản kèm nội dung mã RF-XXXXXX
    Admin->>DB: Admin xác nhận nhận tiền & Duyệt kích hoạt (gán PT nếu có)
    activate DB
    Note over DB: Cập nhật ngay_bat_dau = Hôm nay, ngay_ket_thuc = Hôm nay + số tháng
    DB-->>Admin: Xác nhận cập nhật thành công
    deactivate DB

    Admin->>Mail: Gọi mailable KichHoatGoiTapMail gửi thông báo
    activate Mail
    Mail-->>KH: Gửi email thông báo kích hoạt gói tập & thông tin PT hướng dẫn
    deactivate Mail
```

---

### 3. Luồng Đánh giá sản phẩm tin cậy (Verified Purchase Review)

Đảm bảo chỉ những khách hàng đã thực tế mua sản phẩm trong đơn hàng thành công (Hoàn thành) mới được viết đánh giá, tránh tình trạng spam ảo.

```mermaid
sequenceDiagram
    autonumber
    actor KH as Khách hàng
    participant Web as Giao diện Website
    participant Controller as CommentController
    participant DB as Cơ sở dữ liệu (MySQL)

    KH->>Web: Vào chi tiết sản phẩm -> Viết bình luận (Sao, nội dung, ảnh đính kèm)
    Web->>Controller: Gửi request store()
    
    activate Controller
    Controller->>DB: Kiểm tra đơn hàng có sản phẩm này & trạng thái có là 'Hoàn thành' không?
    activate DB
    DB-->>Controller: Trả về kết quả xác thực mua hàng
    deactivate DB

    alt Chưa từng mua sản phẩm này hoặc đơn chưa hoàn thành
        Controller-->>Web: Trả về mã lỗi HTTP 403 (Không được phép đánh giá)
        Web-->>KH: Báo lỗi: "Chỉ được đánh giá sản phẩm sau khi đã mua hàng thành công."
    else Đã mua & Đã hoàn thành
        Controller->>Controller: Quét nội dung bình luận qua danh sách từ cấm 'dstucam.txt'
        alt Chứa từ ngữ thô tục vi phạm
            Controller-->>Web: Trả về thông báo lỗi vi phạm tiêu chuẩn
            Web-->>KH: Hiển thị lỗi cảnh báo từ ngữ không phù hợp
        else Nội dung hợp lệ
            Controller->>Controller: Lưu ảnh đính kèm vào thư mục upload & mã hóa JSON
            Controller->>DB: Lưu bình luận mới vào bảng 'comments'
            Controller-->>Web: Trả về phản hồi thành công
            Web-->>KH: Hiển thị đánh giá mới trực quan trên giao diện sản phẩm
        end
    end
    deactivate Controller
```
