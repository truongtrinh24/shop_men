CREATE TABLE supplier (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(50) NOT NULL,
    supplier_phone VARCHAR(50) NOT NULL,
    supplier_address VARCHAR(50) NOT NULL,
    supplier_email VARCHAR(50) NOT NULL
);

CREATE TABLE customer (
    customer_id varchar(5) PRIMARY KEY,
    customer_name varchar(50) not null,
    customer_address varchar(50) not null,
    customer_phone varchar(10) not null,
    customer_email varchar(50) not null
);

CREATE TABLE employee (
    employee_id varchar(5) PRIMARY KEY,
    employee_name varchar(50) not null,
    employee_phone varchar(10) not null,
    employee_address varchar(50) not null,
    employee_email varchar(50) not null
);

DELIMITER //
CREATE TRIGGER before_insert_employee
BEFORE INSERT ON employee
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    SET new_id = (SELECT COUNT(*) FROM employee) + 1;
    SET NEW.employee_id = CONCAT('NV', LPAD(new_id, 2, '0'));
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER before_insert_customer
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
    DECLARE new_id INT;
    SET new_id = (SELECT COUNT(*) FROM customer) + 1;
    SET NEW.customer_id = CONCAT('KH', LPAD(new_id, 2, '0'));
END;
//
DELIMITER ;

CREATE TABLE good_receipt (
  good_receipt_id INT PRIMARY KEY AUTO_INCREMENT,
  supplier_id INT,
  employee_id varchar(5),
  date_good_receipt DATE,
  total float,
  CONSTRAINT fk_supplier_id FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id),
  CONSTRAINT fk_employee_id FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

CREATE TABLE status_order (
    status_order_id INT PRIMARY KEY AUTO_INCREMENT,
    status_order_name VARCHAR(50)
);

CREATE TABLE role ( 
	role_id INT PRIMARY KEY AUTO_INCREMENT,
	role_name varchar(60)
);
CREATE TABLE account (
	account_id INT PRIMARY KEY AUTO_INCREMENT,
	username varchar(5),
	password varchar(60) not null,
	role_id INT,
	status_account INT,
	CONSTRAINT fk_role_id_account FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT,
    status_order_id INT,
    employee_id VARCHAR(5),
    total FLOAT,
    date_buy DATETIME,
    CONSTRAINT fk_status_order_id FOREIGN KEY (status_order_id) REFERENCES status_order(status_order_id),
    CONSTRAINT fk_id_employee FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    CONSTRAINT fk_id_account FOREIGN KEY (account_id) REFERENCES account(account_id)
);


CREATE TABLE categories (
	category_id INT PRIMARY KEY AUTO_INCREMENT,
	category_name varchar(50) not null
);
CREATE TABLE product (
	category_id INT,
	product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name varchar(50),
	product_ram INT,
	product_rom INT,
	product_battery INT,
	product_screen float,
    quantity INT,
	product_made_in varchar(50),
	product_year_produce INT,
	product_time_insurance INT,
	product_price INT,
	product_image varchar(50),
    product_url varchar(50),
    product_description varchar(500),
	CONSTRAINT fk_category_product FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE product_seri (
	product_seri varchar(12),
	product_id INT,
	PRIMARY KEY(product_seri),
	CONSTRAINT fk_id_product FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE detail_order (
	order_id INT,
	product_seri varchar(12),
    PRIMARY KEY(order_id, product_seri),
	CONSTRAINT fk_order_id_detail_order FOREIGN KEY (order_id) REFERENCES orders(order_id),
	CONSTRAINT fk_product_seri_detail_order FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);
CREATE TABLE insurance (    
    insurance_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    employee_id varchar(5),
    customer_id varchar(5),
    product_seri varchar(12),
    status_product INT,
    equipment_replacement varchar(50),
    cost float,
    time_to_finish DATE,
    status_insurance INT,
    CONSTRAINT fk_order_id_insurance FOREIGN KEY (order_id) REFERENCES orders(order_id),
    CONSTRAINT fk_employee_id_insurance FOREIGN KEY (employee_id) REFERENCES employee(employee_id),
    CONSTRAINT fk_customer_id_insurance FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    CONSTRAINT fk_product_seri_insurance FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);
CREATE TABLE detail_good_receipt (
    good_receipt_id INT,
    product_id INT,
    product_seri varchar(12),
    price float,
    PRIMARY KEY(good_receipt_id,product_id,product_seri),
    CONSTRAINT fk_good_receipt_id_detail_good_receipt FOREIGN KEY (good_receipt_id) REFERENCES good_receipt(good_receipt_id),
    CONSTRAINT fk_product_id_detail_good_receipt FOREIGN KEY (product_id) REFERENCES product(product_id),
    CONSTRAINT fk_product_seri_detail_good_receipt FOREIGN KEY (product_seri) REFERENCES product_seri(product_seri)
);

CREATE TABLE task (
	task_id INT PRIMARY KEY AUTO_INCREMENT,
	task_name varchar(50) not null
);
CREATE TABLE activity (
	activity_id INT PRIMARY KEY AUTO_INCREMENT,
	activity_name varchar(50) not null
);
CREATE TABLE detail_task_role (
	role_id INT,
	task_id INT,
	activity_id INT,
    PRIMARY KEY(role_id, task_id, activity_id),
	CONSTRAINT fk_role_id_detail_task_role FOREIGN KEY (role_id) REFERENCES role(role_id),
	CONSTRAINT fk_task_id_detail_task_role FOREIGN KEY (task_id) REFERENCES task(task_id),
	CONSTRAINT fk_activity_id_detail_task_role FOREIGN KEY (activity_id) REFERENCES activity(activity_id)
);

CREATE TABLE `cart` (
  `cart_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `account_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int,
  CONSTRAINT fk_account_id_cart FOREIGN KEY (account_id) REFERENCES account(account_id),
  CONSTRAINT fk_product_id_cart FOREIGN KEY (product_id) REFERENCES product(product_id)
);


-- Thêm dữ liệu vào bảng supplier
INSERT INTO supplier (supplier_name, supplier_address, supplier_phone, supplier_email)
VALUES ('Công Ty TNHH Tin Học Kim Thiên Bảo', 'Việt Nam', '0907225889', 'letandanh999@gmail.com'),
       ('Công Ty TNHH Thế Giới Di Động', 'Việt Nam', '0283510010', 'lienhe@thegioididong.com'),
       ('Công Ty TNHH Thương Mại Công Nghệ Bạch Long', 'Việt Nam', '0869287135', 'marketing@bachlongmobile.com'),
       ('Công Ty TNHH Bao La', 'Việt Nam', '0283511906', 'baola@gmail.com'),
       ('Doanh Nghiệp Tư Nhân Ngọc An Khang', 'Việt Nam', '0909577752', 'ngoc0909577752@gmail.com'),
       ('Công Ty Cổ Phần Thế Giới Số', 'Việt Nam', '0208365777', 'nganlt@thegioiso.vn'),
       ('Công Ty TNHH Giải Pháp CNTT Hoàn Vũ', 'Việt Nam', '0976060324', 'hvtransco@gmail.com'),
       ('Công Ty TNHH Thương Mại Và Dịch Vụ Đồng Dung', 'Việt Nam', '0392549661', 'phukienthienlan@gmail.com');
       
-- Thêm các nhân viên bắt đầu từ NV01
INSERT INTO employee (employee_id, employee_name, employee_phone, employee_address, employee_email)
VALUES 
('NV01', 'Nguyễn Văn An', '0987654321', '123 Đường ABC', 'nguyenvanan@example.com'),
('NV02', 'Trần Thị Bình', '0123456789', '456 Đường XYZ', 'tranbinh@example.com'),
('NV03', 'Lê Văn Cường', '0912345678', '789 Đường DEF', 'levancuong@example.com'),
('NV04', 'Phạm Thị Dung', '0876543210', '101 Đường HIJ', 'phamthidung@example.com'),
('NV05', 'Hoàng Văn Đức', '0765432109', '234 Đường KLM', 'hoangvanduc@example.com'),
('NV06', 'Đinh Thị Lan', '0654321098', '567 Đường NOP', 'dinhthilan@example.com'),
('NV07', 'Ngô Văn Giang', '0543210987', '890 Đường QRS', 'ngovangiang@example.com'),
('NV08', 'Lý Thị Hương', '0432109876', '123 Đường TUV', 'lythihuong@example.com'),
('NV09', 'Vũ Văn Khánh', '0321098765', '456 Đường WXY', 'vuvankhanh@example.com'),
('NV10', 'Bùi Thị Kim', '0210987654', '789 Đường ZAB', 'buithikim@example.com');

-- Thêm các khách hàng bắt đầu từ KH01
INSERT INTO customer (customer_id, customer_name, customer_address, customer_phone, customer_email)
VALUES 
('KH01', 'Nguyễn Thị An', '123 Đường ABC', '0987654321', 'nguyenthian@example.com'),
('KH02', 'Trần Văn Bình', '456 Đường XYZ', '0123456789', 'tranbinh@example.com'),
('KH03', 'Lê Thị Cẩm', '789 Đường DEF', '0912345678', 'lethicam@example.com'),
('KH04', 'Phạm Văn Đức', '101 Đường HIJ', '0876543210', 'phamvanduc@example.com'),
('KH05', 'Hoàng Thị Hương', '234 Đường KLM', '0765432109', 'hoangthihuong@example.com'),
('KH06', 'Đinh Văn Kiên', '567 Đường NOP', '0654321098', 'dinhvankien@example.com'),
('KH07', 'Ngô Thị Lan', '890 Đường QRS', '0543210987', 'ngothilan@example.com'),
('KH08', 'Lý Văn Minh', '123 Đường TUV', '0432109876', 'lyvanminh@example.com'),
('KH09', 'Vũ Thị Ngọc', '456 Đường WXY', '0321098765', 'vuthingoc@example.com'),
('KH10', 'Bùi Văn Quân', '789 Đường ZAB', '0210987654', 'buivanquan@example.com');

-- Thêm dữ liệu vào bảng status-order
INSERT INTO status_order (status_order_name) VALUES
('chờ xử lý'),
('đã xử lý'),
('đã huỷ');

-- Thêm dữ liệu vào bảng category
INSERT INTO categories (category_name) VALUES
('iphone'),
('oppo'),
('redmi'),
('samsung'),
('lenovo'),
('sony');

-- Thêm dữ liệu vào bảng product
INSERT INTO product (category_id, product_name, product_ram, product_rom, product_battery, product_screen, product_made_in, product_year_produce, product_time_insurance, product_price, product_image, product_url, product_description)
VALUES
(1, 'iPhone 8', 3, 64, 1821, 4.7, 'Mỹ', 2017, 12, 15000000, 'Iphone-8.png', 'iphone-8', 'Apple iPhone 8 Plus đã thể hiện được sự đẳng cấp và sang trọng, chứng minh phong cách thiết kế hoàn toàn thời thượng từ nhà “Táo khuyết”. Vẫn là thiết kế nguyên khối với chất liệu kim loại nhôm, tuy nhiên iPhone 8 Plus lại mang đến làn gió mới trong các thiết kế nhờ mặt lưng được làm từ kính mang đến sự bóng bẩy, sang trọng. Mặt kính cường lực bo cong đã mang đến sự hiện đại và sang trọng hơn cho iPhone 8 Plus.'),
(1, 'iPhone 11', 4, 128, 3110, 6.1, 'Mỹ', 2019, 12, 22000000, 'Iphone-11.png', 'iphone-11', 'iPhone 11 sở hữu hiệu năng khá mạnh mẽ, ổn định trong thời gian dài nhờ được trang bị chipset A13 Bionic. Màn hình LCD 6.1 inch sắc nét cùng chất lượng hiển thị Full HD của máy cho trải nghiệm hình ảnh mượt mà và có độ tương phản cao. Hệ thống camera hiện đại được tích hợp những tính năng công nghệ mới kết hợp với viên Pin dung lượng 3110mAh, giúp nâng cao trải nghiệm của người dùng.'),
(1, 'iPhone 11 Pro', 4, 256, 3046, 5.8, 'Mỹ', 2019, 12, 30000000, 'Iphone-11-pro.png', 'iphone-11-pro', 'Những chiếc máy iPhone 11 Pro Max 64GB cũ đã qua sử dụng được chúng tôi thu lại từ khách hàng có nhu cầu bán lại, đổi trả cũng như tham gia các chương trình thu cũ đổi mới. Trong đó có nhiều sản phẩm vẫn còn thời gian bảo hành chính hãng dài và ngoại hình đẹp như mới, bạn có thể hoàn toàn an tâm khi sử dụng.'),
(1, 'iPhone 12', 4, 128, 2815, 6.1, 'Mỹ', 2020, 12, 27000000, 'Iphone-12.png', 'iphone-12', 'Dù Apple vừa giới thiệu dòng điện thoại iPhone 13 series tuy nhiên iPhone 12 vẫn đang là một trong những sự lựa chọn hàng đầu ở thời điểm hiện tại. Chiếc flagship năm 2020 của "Táo khuyết" đang nhận được rất nhiều sự quan tâm của người dùng bởi mức giá dễ tiếp cận hơn so với thời điểm ra mắt, đồng thời được trang bị cấu hình, màn hình, camera ấn tượng trong tầm giá.'),
(1, 'iPhone 12 Pro', 6, 256, 2815, 6.1, 'Mỹ', 2020, 12, 33000000, 'Iphone-12-pro.png', 'iphone-12-pro', 'SP được thu lại từ khách bán lại - thu cũ, ngoại hình đẹp như máy mới. Máy có thể đã qua bảo hành hãng hoặc sửa chữa thay thế linh kiện để đảm bảo sự ổn định khi dùng. Có nguồn gốc rõ ràng, xuất bán đầy đủ hoá đơn eVAT.'),
(1, 'iPhone 13', 4, 128, 4352, 6.1, 'Mỹ', 2021, 12, 27000000, 'Iphone-13-pro.png', 'iphone-13', 'Về kích thước, iPhone 13 sẽ có 4 phiên bản khác nhau và kích thước không đổi so với series iPhone 12 hiện tại. Nếu iPhone 12 có sự thay đổi trong thiết kế từ góc cạnh bo tròn (Thiết kế được duy trì từ thời iPhone 6 đến iPhone 11 Pro Max) sang thiết kế vuông vắn (đã từng có mặt trên iPhone 4 đến iPhone 5S, SE).'),
(1, 'iPhone 13 Pro', 6, 256, 3095, 6.1, 'Mỹ', 2021, 12, 36000000, 'Iphone-13-pro.png', 'iphone-13-pro', 'iPhone 12 ra mắt cách đây chưa lâu, thì những tin đồn mới nhất về iPhone 13 Pro Max đã khiến bao tín đồ công nghệ ngóng chờ. Cụm camera được nâng cấp, màu sắc mới, đặc biệt là màn hình 120Hz với phần notch được làm nhỏ gọn hơn chính là những điểm làm cho thu hút mọi sự chú ý trong năm nay.'),
(1, 'iPhone 14', 6, 256, 4000, 6.1, 'Mỹ', 2022, 12, 38000000, 'Iphone-14.png', 'iphone-14', 'iPhone 14 Pro Max sở hữu thiết kế màn hình Dynamic Island ấn tượng cùng màn hình OLED 6,7 inch hỗ trợ always-on display và hiệu năng vượt trội với chip A16 Bionic. Bên cạnh đó máy còn sở hữu nhiều nâng cấp về camera với cụm camera sau 48MP, camera trước 12MP dùng bộ nhớ RAM 6GB đa nhiệm vượt trội. Cùng phân tích chi tiết thông số siêu phẩm này ngay sau đây.'),
(2, 'Oppo A3s', 2, 16, 4230, 6.2, 'Trung Quốc', 2018, 12, 5000000, 'Oppo-A3s.png', 'oppo-a3s', 'Oppo từ lâu là một trong những hãng điện thoại thông minh có xu hướng tiếp cận tập trung vào đối tượng người dùng cá tính, năng động dựa vào ngôn ngữ thiết kế sản phẩm rất đặc trung của mình. Chúng ta có thế dễ dàng định hình ngôn ngữ này thông qua những sản phẩm đầy màu sắc với những họa tiết cực kỳ trẻ trung, năng động – Điển hình là chiếc Oppo A3s.'),
(2, 'Oppo A5s', 3, 32, 4230, 6.2, 'Trung Quốc', 2019, 12, 6000000, 'Oppo-A5s.png', 'oppo-a5s', 'Điện thoại OPPO A5s là một phiên bản khác của OPPO A15 trước đó với một số nâng cấp nhằm tăng cường trải nghiệm sử dụng. Thiết kế của máy vẫn mang vẻ ngoài cá tính, mỏng chỉ 7.9mm với mặt kính cường lực tạo nét sang trọng cho chiếc máy. OPPO A5s vẫn giữ nguyên jack cắm tai nghe 3.5mm cho người dùng tai nghe có dây truyền thống.'),
(2, 'Oppo A16k', 3, 32, 5000, 6.52, 'Trung Quốc', 2020, 12, 7000000, 'Oppo-A16k.png', 'oppo-a16k', 'Điện thoại Oppo A16K mặc dù sở hữu thiết kế đơn giản nhưng vẫn rất thanh lịch và thời trang với những đường nét hài hòa, hai cạnh bên vát cong, cảm giác khi cầm nắm trên tay cũng sẽ chắc chắn hơn. Máy có phần khung viền chắc chắn nên sẽ giúp máy có trọng lượng nhẹ nhưng vẫn cứng cáp.'),
(2, 'Oppo A55', 4, 64, 5000, 6.51, 'Trung Quốc', 2022, 12, 9000000, 'Oppo-A55.png', 'oppo-a55', 'OPPO A55 không chỉ sở hữu thiết kế trẻ trung, thời lượng sử dụng ấn tượng với viên pin 5000mAh mà còn đồng thời sở hữu một cấu hình ở mức khá ổn với chipset MediaTek Helio G35, màn hình IPS LCD hiển thị đẹp mắt. Đặc biệt, mẫu điện thoại tầm trung giá rẻ của OPPO này còn sở hữu cụm camera chất lượng để đáp ứng nhu cầu sống ảo của người dùng trẻ.'),
(2, 'Oppo Reno7', 6, 128, 4500, 6.43, 'Trung Quốc', 2023, 12, 12000000, 'Oppo-Reno-7.png', 'oppo-reno7', 'OPPO là thương hiệu điện thoại nổi tiếng với khả năng chụp hình đẹp và mẫu smartphone mới OPPO Reno7 cũng không ngoại lệ. Điện thoạikhông chỉ sở hữu thiết kế bắt mắt, camera chất lượng mà còn được trang bị một hiệu năng vượt trội.'),
(2, 'Oppo Reno8', 6, 256, 5000, 6.5, 'Trung Quốc', 2023, 12, 15000000, 'Oppo-Reno-8.png', 'oppo-reno8', 'OPPO Reno8 sở hữu thiết kế sang trọng, hiện đại nhưng cũng vô cùng độc đáo, bắt mắt. Phần mặt lưng của máy được hiệu chỉnh đặc biệt với hiệu ứng chuyển màu cực kỳ linh hoạt theo từng góc độ khác nhau.'),
(2, 'Oppo Reno10', 8, 256, 5000, 6.8, 'Trung Quốc', 2023, 12, 18000000, 'Oppo-Reno-10.png', 'oppo-reno10', 'Điện thoại OPPO Reno 10 sở hữu hiệu năng vô cùng mạnh mẽ khi được trang bị chipset MediaTek Dimensity 7050. Chất lượng hình ảnh của máy có độ sắc nét, mượt mà nhờ sở hữu tấm nền 3D AMOLED hiện đại với độ phân giải FHD+ 2412 × 1080 pixel cùng tần số quét 120Hz. Bên cạnh đó, Reno 10 còn sở hữu một vài ưu điểm khác như dung lượng Pin 5000mAh với sạc nhanh SUPERVOOC 67W cùng cụm camera 64MP sắc nét giúp nâng cao trải nghiệm của người dùng.'),
(2, 'Oppo Reno11', 8, 512, 5000, 6.8, 'Trung Quốc', 2023, 12, 20000000, 'Oppo-Reno-11.png', 'oppo-reno11', 'OPPO Reno11 F 5G cung cấp trải nghiệm hiển thị, xử lý siêu mượt mà với màn hình AMOLED 6.7 inch hiện đại cùng chipset MediaTek Dimensity 7050 mạnh mẽ. Hệ thống quay chụp trên thế hệ Reno11 F 5G này được cải thiện hơn thông qua cụm 3 camera với độ phân giải lần lượt là 64MP, 8MP và 2MP. Ngoài ra, cung cấp năng lượng cho thế hệ OPPO smartphone này là viên pin 5000mAh cùng sạc nhanh 67W, mang tới trải nghiệm liền mạch suốt ngày dài.'),
(2, 'Oppo Reno4', 8, 256, 4000, 6.4, 'Trung Quốc', 2020, 12, 14000000, 'Oppo-Reno4.png', 'oppo-reno4', 'OPPO Reno4 Pro có sự thay đổi lớn so với Reno 3 Pro, cả về thiết kế lẫn chất liệu. Thay vì có khung máy nhựa, máy sử dụng chất liệu nhôm nguyên khối và được bọc kính cường lực Gorilla Glass 6 ở cả hai mặt trước & sau, góp phần tăng độ cứng cáp lẫn nét sang trọng cho máy.'), 
(3, 'Redmi 10x', 4, 64, 5020, 6.53, 'Trung Quốc', 2020, 12, 5000000, 'Redmi-10x.png', 'redmi-10x', 'Trải nghiệm chất lượng hiển thị sắc nét, mượt mà - Màn hình 6.5" FullHD+, tần số quét 90 Hz cấu hình ổn định, sử dụng mượt mà - Chip Helio G88 mới, RAM 4 GB, camera cải tiến tối đa - Cụm 4 camera lên đến 50MP, chụp ảnh sắc nét, pin trâu, sử dụng cực lâu - Viên pin 5000 mAh, hỗ trợ sạc nhanh 18W, sạc ngược 9W'),
(3, 'Redmi 11', 4, 128, 5000, 6.67, 'Trung Quốc', 2022, 12, 6000000, 'Redmi-11.png', 'redmi-11', 'Xiaomi tự hào trang bị trên Mi 11X tấm nền Super AMOLED sống động, màu sắc tươi và có độ tương phản cao. Màn hình áp dụng công nghệ mới sẽ đem đến cho người dùng những trải nghiệm hình ảnh “mát” mắt nhất.'),
(3, 'Redmi 12c', 4, 128, 6000, 6.53, 'Trung Quốc', 2023, 12, 7000000, 'Redmi-12c.png', 'redmi-12c', 'Ổn định hiệu năng - Chip MediaTek Helio G85 mạnh mẽ xử lí tốt các tác vụ thường ngày, sử dụng đa nhiệm nhiều ứng dụng, thao tác cùng lúc tốt hơn - Hỗ trợ bộ nhớ mở rộng, giải trí thả ga - Màn hình 6.71" HD+ cho khung hình rõ nét, ảnh sắc nét với chế độ chụp đêm - Camera kép AI 50MP'),
(3, 'Redmi Note 8', 4, 64, 4000, 6.3, 'Trung Quốc', 2019, 12, 3000000, 'Redmi-Note-8.png', 'redmi-note-8', 'Redmi Note 8 phiên bản 128GB được cung cấp sức mạnh bởi chip Snapdragon 665 kết hợp 3GB RAM và 128GB bộ nhớ trong. Máy còn được trang bị cụm 4 camera sau 48MP, viên pin 4000 mAh hỗ trợ sạc nhanh 18W.'),
(3, 'Redmi Note 11', 6, 128, 5000, 6.43, 'Trung Quốc', 2021, 12, 4000000, 'Redmi-Note-11.png', 'redmi-note-11', 'Đón đầu thử thách, bứt phá mọi tựa game - Chip MediaTek Dimensity 920 5G 8 nhân siêu mạnh mẽ, không gian giải trí đỉnh cao - Màn hình AMOLED 6.67 inch sắc nét, tần số quét 120Hz mượt mà, sạc nhanh thần tốc, tràn đầy năng lượng - Dung lượng pin lớn 4500mAh, sạc nhanh đến 120W, trải nghiệm nhiếp ảnh cực đỉnh - Camera chính 108MP, hỗ trợ nhiều chế độ chụp linh hoạt'),
(3, 'Redmi Note 12', 8, 256, 5500, 6.6, 'Trung Quốc', 2022, 12, 4500000, 'Redmi-Note-12.png', 'redmi-note-12', 'Xiaomi Redmi Note 12 8GB 128GB tỏa sáng với diện mạo viền vuông cực thời thượng cùng hiệu suất mạnh mẽ nhờ sở hữu con chip Snapdragon 685 ấn tượng. Chất lượng hiển thị hình ảnh của Redmi Note 12 Vàng cũng khá sắc nét thông qua tấm nền AMOLED 120Hz hiện đại. Chưa hết, máy còn sở hữu cụm 3 camera với độ rõ nét lên tới 50MP cùng viên pin 5000mAh và s ạc nhanh 33W giúp đáp ứng được mọi nhu cầu sử dụng của người dùng.'),
(4, 'Samsung A03', 3, 32, 5000, 6.5, 'Hàn Quốc', 2021, 12, 5000000, 'Samsung-A03.png', 'samsung-a03', 'Nằm trong phân khúc giá rẻ, Samsung Galaxy A03 sở hữu thiết kế nổi bật cùng hiệu năng cực kỳ ổn định. Màn hình 6.5 inch được trang bị tấm nền PLS LCD mang tới chất lượng hình ảnh sắc nét, sống động. Cấu hình ổn định, có thể xử lý được những tác vụ không quá phức tạp nhờ được tích hợp chipset Unisoc T606.'),
(4, 'Samsung A13', 4, 64, 6000, 6.6, 'Hàn Quốc', 2021, 12, 7000000, 'Samsung-A13.png', 'samsung-a13', 'Thảo sức tận hưởng thế giới giải trí sống động - Màn hình TFT LCD, 6.6 inch, hiệu năng ổn định, ấn tượng - Chip Exynos 850 mạnh mẽ, xử lí tốt mọi tác vụ, camera nâng cấp với nhiều tính năng độc đáo - Cụm 4 camera 50MP, 5MP, 2MP và 2MP, thoải mái trải nghiệm với pin dung lượng 5000 mAh, sạc nhanh 15W'),
(4, 'Samsung A20s', 4, 64, 4000, 6.5, 'Hàn Quốc', 2019, 12, 6000000, 'Samsung-A20s.png', 'samsung-a20s', 'Samsung A20s là phiên bản kế nhiệm Galaxy A20 thuộc dòng Samsung Galaxy A vừa được Samsung cho ra mắt. Galaxy A20s được dự đoán sử dụng chip Exynos 7884, cụm camera kép được nâng cấp cũng như màn hình giọt nước. Đây cũng là mẫu smartphone được kỳ vọng sẽ giúp Samsung tăng thị phần trong phân khúc smartphone tầm trung.'),
(4, 'Samsung A23', 4, 128, 5000, 6.6, 'Hàn Quốc', 2022, 12, 8000000, 'Samsung-A23.png', 'samsung-a23', 'Samsung A23 5G được trang bị cấu hình vượt trội với con chip Snapdragon 695 5G cùng viên pin 5000 mAh thoải mái trải nghiệm. Màn hình 6.6 inch LCD mang lại khả năng hiển thị rõ nét. Điểm đặc biệt, mẫu điện thoại Samsung này còn được trang bị kết nối 5G đầy tiện lợi.'),
(4, 'Samsung A33', 6, 128, 6000, 6.5, 'Hàn Quốc', 2023, 12, 10000000, 'Samsung-A33.png', 'samsung-a33', 'Màn hình giải trí lớn, sắc nét từng chi tiết - 6.5 inch, Full HD+ cho hình ảnh sắc nét, chân thực, 4 camera hỗ trợ chụp ảnh chuyên nghiệp - Camera chính lến đến 64 MP ghi lại trọn vẹn chi tiết đáng giá, cấu hình ổn định, xử lí đa dạng tác vụ - Vi xử lý Dimensity 800U hỗ trợ 5G kết hợp cùng RAM 6 GB, thiết kế tối giản với nhiều lựa chọn màu sắc hấp dẫn giúp bạn bừng sáng phong cách sống'),
(4, 'Samsung Galaxy22', 8, 256, 4500, 6.7, 'Hàn Quốc', 2023, 12, 15000000, 'Samsung-galaxy-22.png', 'samsung-galaxy22', 'Điện thoại Samsung S22 Ultra phiên bản RAM 12GB cho cảm giác siêu mượt mà khi mở và đóng ứng dụng, đi kèm bộ nhớ trong 256GB cho bạn thoải mái lưu trữ những khung hình, thước phim chất lượng cao. Vi xử lý Qualcomm Snapdragon 8 Gen 1 hứa hẹn mang đến hiệu năng tuyệt đỉnh, xử lý mượt mà mọi tác vụ.'),
(4, 'Samsung GalaxyA6', 6, 128, 4000, 6.4, 'Hàn Quốc', 2018, 12, 9000000, 'Samsung-galaxy-A6.png', 'samsung-galaxyA6', 'Sau sự ra mắt của bộ đôi Samsung Galaxy A8, A8 Plus, hãng điện thoại Samsung không muốn dừng lại ở đó và đã tiếp tục cho ra mắt sản phẩm mới thuộc phân khúc tầm trung. Sản phẩm giữ nguyên thiết kế của dòng Samsung Galaxy A và tính năng giống với Galaxy A8 (2018), Samsung Galaxy A6 Chính hãng hứa hẹn sẽ được nhiều người hài lòng và sử dụng nhiều nhất trong các dòng Samsung Galaxy.'),
(4, 'Samsung Galaxy A50', 6, 128, 4000, 6.4, 'Hàn Quốc', 2018, 12, 9000000, 'Samsung-galaxy-A50.png', 'samsung-galaxy-a50', 'Là phiên bản tiền nhiệm của điện thoại Galaxy A50s, Galaxy A50 cũ được trang bị vi xử lý Exynos 9 kèm RAM 4GB và 64GB bộ nhớ trong, cụm 3 camera sau 25MP, camera trước 25MP, màn hình Super AMOLED 6.4 inch cùng viên pin 4000 mAh.'),
(4, 'Samsung Galaxy S21', 6, 128, 4000, 6.4, 'Hàn Quốc', 2018, 12, 9000000, 'Samsung-galaxy-s21.png', 'samsung-galaxy-s21', 'Samsung S21 sở hữu chipset Exynos 2100 mạnh mẽ có thể chơi mượt mà, RAM 8GB và ROM 128GB cho khả năng đa nhiệm và lưu trữ ổn định. Thêm vào đó cụm camera chất lượng, cho hình ảnh sắc nét: 12MP+12MP+8MP và camera selfie 32MP. Không chỉ vậy, các phiên bản màu sắc thanh lịch, thời thượng giúp sản phẩm nổi bật hơn giữa hàng loạt các thương hiệu khác.'),
(4, 'Samsung Galaxy Z', 6, 128, 4000, 6.4, 'Hàn Quốc', 2018, 12, 9000000, 'Samsung-galaxy-Z.png', 'samsung-galaxy-z', 'Samsung Galaxy Z có thiết kế màn hình rộng 6.7 inch và độ phân giải Full HD+ (1080 x 2640 Pixels), dung lượng RAM 8GB, bộ nhớ trong 256GB. Màn hình Dynamic AMOLED 2X của điện thoại này hiển thị rõ nét và sắc nét, mang đến trải nghiệm ấn tượng khi sử dụng.'),
(5, 'Lenovo K8', 3, 32, 4000, 5.2, 'Trung Quốc', 2017, 12, 7000000, 'Lenovo-k8.png', 'lenovo-k8', 'Phiên bản Lenovo k8 nổi bật với thiết kế gọn nhỏ, cấu hình mạnh mẽ đi kèm bút cảm ứng Lenovo Tab Pen cho phép người dùng viết, vẽ dễ dàng. Chính những đặc trưng này mà thiết bị là lựa chọn phù hợp cho mọi đối tượng từ học sinh, sinh viên đến dân văn phòng. '),
(5, 'Lenovo Phab', 3, 32, 4250, 6.98, 'Trung Quốc', 2016, 12, 9000000, 'Lenovo-Phab.png', 'lenovo-phab', 'Lenovo Phab lại có kích thước khá nặng cho người dùng cảm giác cầm nắm chắc chắn và cứng cáp. Máy được thiết kế từ nhôm, mặt lưng được bo cong về các cạnh cho máy ôm tay hơn khi sử dụng.'),
(5, 'Lenovo S660', 1, 8, 3000, 4.7, 'Trung Quốc', 2014, 12, 3500000, 'Lenovo-s660.png', 'lenovo-s660', 'Lenovo S660 khá lớn với chiều dài 137mm, chiều rộng 68.8 mm, dày 9.95 mm và nặng 151g song đem lại cảm giác khá chắc chắn khi cầm. Sản phẩm nổi bật với các góc cạnh được bo tròn khá mềm mại và logo Lenovo sáng bóng ở mặt sau. S660 được bao quanh bởi một lớp vỏ nhôm thời trang và sang trọng. Lớp vỏ kim loại không những giúp sản phẩm bền và chắc chắn hơn mà còn giúp chống bám vân tay khá hiệu quả.'),
(5, 'Lenovo S930', 1, 8, 3000, 6, 'Trung Quốc', 2013, 12, 4000000, 'Lenovo-s930.png', 'lenovo-s930', 'Là một thiết bị màn hình 6 inch, giải trí đa nhiệm thế nên sản phẩm được trang bị khá đầy đủ những tính năng hiện đại và cần thiết, đáng chú ý đó là hệ thống loa kép kết hợp cùng công nghệ âm thanh đã quá nổi tiếng đó là Dolby Digital Plus. Bên cạnh đó máy còn được trang bị chip lõi tứ, camera 8MP với rất nhiều hiệu ứng thú vị, hệ điều hành Android Jelly Bean 4.2 và hỗ trợ thêm tính năng hai sim hai sóng.'),
(5, 'Lenovo Vibe X2', 2, 32, 2300, 5, 'Trung Quốc', 2014, 12, 6000000, 'Lenovo-Vibe-x2.png', 'lenovo-vibe-x2', 'Lenovo Vibe X2 có tới 3 dải màu sắc ở mặt bên nhờ thiết kế từ nhiều lớp nhưng những gì thực sự đáng chú ý trên thiết bị này là vỏ kim loại đẹp mắt với độ mỏng chỉ 7.27mm và có rất nhiều màu như trắng, đỏ, vàng hay xám đậm.'),
(5, 'Lenovo Z5', 4, 128, 3300, 6.2, 'Trung Quốc', 2018, 12, 11000000, 'Lenovo-Z5.png', 'lenovo-z5', 'Lenovo Z5 được xem là sự lột xác hoàn hảo trong thiết kế đến từ chiếc "tai thỏ" phá cách trên một màn hình tràn viền đúng "chất" với tỉ lệ 19:9 thời thượng.'),
(5, 'Lenovo 0p70', 3, 16, 2500, 5, 'Trung Quốc', 2015, 12, 5000000, 'Lenovo0p70.png', 'lenovo-0p70', 'Điện thoại thông minh Lenovo P70 với thiết kế mạnh mẽ, các cạnh bo tròn mang đến sự thoải mái tuyệt đối trong cầm nắm, cấu hình tốt cùng kết nối 4G hiện đại.'),
(6, 'Sony Xperia 1', 6, 128, 3300, 6.5, 'Nhật Bản', 2019, 12, 10000000, 'Sony-Xperia-1.png', 'sony-xperia-1', 'Sony Xperia 1 - là phiên bản kế nhiệm người đàn anh Xperia XZ3, mang nhiều tính năng đặc biệt khi sở hữu những công nghệ lần đầu tiên có mặt trên một chiếc smartphone.'),
(6, 'Sony Xperia 5', 6, 128, 3140, 6.1, 'Nhật Bản', 2019, 12, 8000000, 'Sony-Xperia-5.png', 'sony-xperia-5', 'Mặc kệ các hãng smartphone khác đang làm các công nghệ màn hình khác nhau như "tai thỏ" hay "nốt ruồi" thì Sony vẫn giữ cho mình lối đi riêng và khác biệt hoàn toàn với những chiếc máy còn lại, và Sony Xperia 5 là một sản phẩm như vậy.'),
(6, 'Sony Xperia 10', 3, 64, 2870, 6, 'Nhật Bản', 2019, 12, 6000000, 'Sony-Xperia-10.png', 'sony-xperia-10', 'Sony Xperia 10 là mẫu smartphone tầm trung mới và được xem là phiên bản thu gọn của chiếc Sony Xperia 1 vừa ra mắt trước đó.'),
(6, 'Sony Xperia XZ2', 4, 64, 3180, 5.7, 'Nhật Bản', 2018, 12, 7000000, 'Sony-Xperia-XZ2.png', 'sony-xperia-xz2', 'Xperia XZ2 là chiếc flagship mới được Sony giới thiệu tại MWC 2018 với sự thay đổi lớn về thiết kế so với những người tiền nhiệm.'),
(6, 'Sony Xperia XZ3', 6, 64, 3300, 6, 'Nhật Bản', 2018, 12, 9000000, 'Sony-Xperia-XZ3.png', 'sony-xperia-xz3', 'Sony Xperia XZ3 được xem là sự hiện thân của Xperia XZ2 nhưng đã được Sony chau chuốt hơn về mặt thiết kế, hiệu năng cũng như duy trì những tính năng cao cấp từ người đàn anh của nó.');


-- Thêm dữ liệu vào bảng product_seri
-- iPhone serie         Quốc gia-tên sp-loại-phiên bản (00-> thường, 01-> pro)-0000 stt
INSERT INTO product_seri (product_id, product_seri)
VALUES 
(1, 'USIP08000001'),
(1, 'USIP08000002'),
(1, 'USIP08000003'),
(1, 'USIP08000004'),
(1, 'USIP08000005'),
(2, 'USIP11000001'),
(2, 'USIP11000002'),
(2, 'USIP11000003'),
(2, 'USIP11000004'),
(2, 'USIP11000005'),
(3, 'USIP11010001'),
(3, 'USIP11010002'),
(3, 'USIP11010003'),
(3, 'USIP11010004'),
(3, 'USIP11010005'),
(3, 'USIP11010006'),
(3, 'USIP11010007'),
(4, 'USIP12000001'),
(4, 'USIP12000002'),
(4, 'USIP12000003'),
(4, 'USIP12000004'),
(4, 'USIP12000005'),
(4, 'USIP12000006'),
(4, 'USIP12000007'),
(4, 'USIP12000008'),
(5, 'USIP12010001'),
(5, 'USIP12010002'),
(5, 'USIP12010003'),
(6, 'USIP13000001'),
(6, 'USIP13000002'),
(6, 'USIP13000003'),
(7, 'USIP13010001'),
(7, 'USIP13010002'),
(7, 'USIP13010003'),
(7, 'USIP13010004'),
(8, 'USIP14000001'),
(8, 'USIP14000002'),
(8, 'USIP14000003'),
(9, 'CNOPA3S00001'),
(9, 'CNOPA3S00002'),
(9, 'CNOPA3S00003'),
(10, 'CNOPA5S00001'),
(10, 'CNOPA5S00002'),
(10, 'CNOPA5S00003'),
(11, 'CNOPA16K0001'),
(11, 'CNOPA16K0002'),
(11, 'CNOPA16K0003'),
(12, 'CNOPA5500001'),
(12, 'CNOPA5500002'),
(12, 'CNOPA5500003'),
(12, 'CNOPA5500004'),
(13, 'CNOPRE070001'),
(13, 'CNOPRE070002'),
(13, 'CNOPRE070003'),
(13, 'CNOPRE070004'),
(14, 'CNOPRE080001'),
(14, 'CNOPRE080002'),
(14, 'CNOPRE080003'),
(14, 'CNOPRE080004'),
(15, 'CNOPRE100001'),
(15, 'CNOPRE100002'),
(15, 'CNOPRE100003'),
(15, 'CNOPRE100004'),
(16, 'CNOPRE110001'),
(16, 'CNOPRE110002'),
(16, 'CNOPRE110003'),
(16, 'CNOPRE110004'),
(17, 'CNOPRE040001'),
(17, 'CNOPRE040002'),
(17, 'CNOPRE040003'),
(18, 'CNRM100X0001'),
(18, 'CNRM100X0002'),
(18, 'CNRM100X0003'),
(18, 'CNRM100X0004'),
(19, 'CNRM11000001'),
(19, 'CNRM11000002'),
(19, 'CNRM11000003'),
(19, 'CNRM11000004'),
(20, 'CNRM120C0001'),
(20, 'CNRM120C0002'),
(20, 'CNRM120C0003'),
(20, 'CNRM120C0004'),
(21, 'CNRMNO080001'),
(21, 'CNRMNO080002'),
(21, 'CNRMNO080003'),
(21, 'CNRMNO080004'),
(22, 'CNRMNO110001'),
(22, 'CNRMNO110002'),
(22, 'CNRMNO110003'),
(22, 'CNRMNO110004'),
(23, 'CNRMNO120001'),
(23, 'CNRMNO120002'),
(23, 'CNRMNO120003'),
(24, 'KRSGNO080001'),
(24, 'KRSGNO080002'),
(24, 'KRSGNO080003'),
(24, 'KRSGNO080004'),
(25, 'KRSGNO110001'),
(25, 'KRSGNO110002'),
(25, 'KRSGNO110003'),
(25, 'KRSGNO110004'),
(26, 'KRSGNO120001'),
(26, 'KRSGNO120002'),
(26, 'KRSGNO120003'),
(27, 'KRSGA0300001'),
(27, 'KRSGA0300002'),
(27, 'KRSGA0300003'),
(27, 'KRSGA0300004'),
(28, 'KRSGA1300001'),
(28, 'KRSGA1300002'),
(28, 'KRSGA1300003'),
(28, 'KRSGA1300004'),
(29, 'KRSGA20S0001'),
(29, 'KRSGA20S0002'),
(29, 'KRSGA20S0003'),
(29, 'KRSGA20S0004'),
(30, 'KRSGA2300001'),
(30, 'KRSGA2300002'),
(30, 'KRSGA2300003'),
(30, 'KRSGA2300004'),
(31, 'KRSGA3300001'),
(31, 'KRSGA3300002'),
(31, 'KRSGA3300003'),
(31, 'KRSGA3300004'),
(32, 'KRSG22000001'),
(32, 'KRSG22000002'),
(32, 'KRSG22000003'),
(32, 'KRSG22000004'),
(33, 'KRSGA6000001'),
(33, 'KRSGA6000002'),
(33, 'KRSGA6000003'),
(33, 'KRSGA6000004'),
(34, 'CNLNK8000001'),
(34, 'CNLNK8000002'),
(34, 'CNLNK8000003'),
(34, 'CNLNK8000004'),
(35, 'CNLNPHAB0001'),
(35, 'CNLNPHAB0002'),
(35, 'CNLNPHAB0003'),
(35, 'CNLNPHAB0004'),
(36, 'CNLNS6600001'),
(36, 'CNLNS6600002'),
(36, 'CNLNS6600003'),
(36, 'CNLNS6600004'),
(37, 'CNLNS9300001'),
(37, 'CNLNS9300002'),
(37, 'CNLNS9300003'),
(37, 'CNLNS9300004'),
(38, 'CNLNVIX20001'),
(38, 'CNLNVIX20002'),
(38, 'CNLNVIX20003'),
(38, 'CNLNVIX20004'),
(39, 'CNLNZ5000001'),
(39, 'CNLNZ5000002'),
(39, 'CNLNZ5000003'),
(39, 'CNLNZ5000004'),
(40, 'CNLNOP700001'),
(40, 'CNLNOP700002'),
(40, 'CNLNOP700003'),
(40, 'CNLNOP700004'),
(41, 'JPSX01000001'),
(41, 'JPSX01000002'),
(41, 'JPSX01000003'),
(41, 'JPSX01000004'),
(42, 'JPSX05000001'),
(42, 'JPSX05000002'),
(42, 'JPSX05000003'),
(42, 'JPSX05000004'),
(43, 'JPSX10000001'),
(43, 'JPSX10000002'),
(43, 'JPSX10000003'),
(43, 'JPSX10000004'),
(44, 'JPSXXZ020001'),
(44, 'JPSXXZ020002'),
(44, 'JPSXXZ020003'),
(44, 'JPSXXZ020004'),
(45, 'JPSXXZ030001'),
(45, 'JPSXXZ030002'),
(45, 'JPSXXZ030003'),
(45, 'JPSXXZ030004');

-- Thêm dữ liệu vào bảng role
INSERT INTO role (role_name) VALUES
('admin'),
('employee'),
('customer');

-- Thêm dữ liệu vào bảng task
INSERT INTO task (task_name) VALUES
('account management'),
('customer management'),
('product management'),
('order management'),
('employee management'),
('role management'),
('import management'),
('statistical management'),
('insurance management');

-- Thêm dữ liệu vào bảng activity
INSERT INTO activity (activity_name) VALUES
('add'),
('edit'),
('delete'),
('search'),
('clients');

-- Thêm dữ liệu vào bảng detail_task_role
INSERT INTO detail_task_role (role_id, task_id, activity_id) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(2, 1, 1);

-- Thêm dữ liệu vào bảng good_receipt
INSERT INTO good_receipt (supplier_id, employee_id, date_good_receipt, total) VALUES
(1, 'NV01', NOW(), NULL),
(2, 'NV02', NOW(), NULL),
(3, 'NV03', NOW(), NULL),
(4, 'NV04', NOW(), NULL),
(5, 'NV05', NOW(), NULL),
(6, 'NV06', NOW(), NULL);

-- Thêm dữ liệu vào bảng detail_good_receipt
INSERT INTO detail_good_receipt (good_receipt_id, product_id, product_seri, price) VALUES
(1, 1, 'USIP08000001', 15000000),
(1, 1, 'USIP08000002', 15000000),
(1, 1, 'USIP08000003', 15000000),
(1, 1, 'USIP08000004', 15000000),
(1, 1, 'USIP08000005', 15000000),
(1, 1, 'USIP11000001', 22000000),
(1, 1, 'USIP11000002', 22000000),
(1, 1, 'USIP11000003', 22000000),
(1, 1, 'USIP11000004', 22000000),
(1, 1, 'USIP11000005', 22000000),
(1, 2, 'USIP11000001', 22000000),
(1, 2, 'USIP11000002', 22000000),
(1, 2, 'USIP11000003', 22000000),
(1, 2, 'USIP11000004', 22000000),
(1, 2, 'USIP11000005', 22000000),
(1, 3, 'USIP11010001', 30000000),
(1, 3, 'USIP11010002', 30000000),
(1, 3, 'USIP11010003', 30000000),
(1, 3, 'USIP11010004', 30000000),
(1, 3, 'USIP11010005', 30000000),
(1, 3, 'USIP11010006', 30000000),
(1, 3, 'USIP11010007', 30000000),
(1, 4, 'USIP12000001', 27000000),
(1, 4, 'USIP12000002', 27000000),
(1, 4, 'USIP12000003', 27000000),
(1, 4, 'USIP12000004', 27000000),
(1, 4, 'USIP12000005', 27000000),
(1, 4, 'USIP12000006', 27000000),
(1, 4, 'USIP12000007', 27000000),
(1, 4, 'USIP12000008', 27000000),
(1, 5, 'USIP12010001', 33000000),
(1, 5, 'USIP12010002', 33000000),
(1, 5, 'USIP12010003', 33000000),
(1, 6, 'USIP13000001', 27000000),
(1, 6, 'USIP13000002', 27000000),
(1, 6, 'USIP13000003', 27000000),
(1, 7, 'USIP13010001', 36000000),
(1, 7, 'USIP13010002', 36000000),
(1, 7, 'USIP13010003', 36000000),
(1, 7, 'USIP13010004', 36000000),
(1, 8, 'USIP14000001', 38000000),
(1, 8, 'USIP14000002', 38000000),
(1, 8, 'USIP14000003', 38000000),
(1, 9, 'CNOPA3S00001', 5000000),
(1, 9, 'CNOPA3S00002', 5000000),
(1, 9, 'CNOPA3S00003', 5000000),
(1, 10, 'CNOPA5S00001', 6000000),
(1, 10, 'CNOPA5S00002', 6000000),
(1, 10, 'CNOPA5S00003', 6000000),
(1, 11, 'CNOPA16K0001', 7000000),
(1, 11, 'CNOPA16K0002', 7000000),
(1, 11, 'CNOPA16K0003', 7000000),
(1, 12, 'CNOPA5500001', 9000000),
(1, 12, 'CNOPA5500002', 9000000),
(1, 12, 'CNOPA5500003', 9000000),
(1, 12, 'CNOPA5500004', 9000000),
(1, 13, 'CNOPRE070001', 12000000),
(1, 13, 'CNOPRE070002', 12000000),
(1, 13, 'CNOPRE070003', 12000000),
(1, 13, 'CNOPRE070004', 12000000),
(1, 14, 'CNOPRE080001', 15000000),
(1, 14, 'CNOPRE080002', 15000000),
(1, 14, 'CNOPRE080003', 15000000),
(1, 14, 'CNOPRE080004', 15000000),
(1, 15, 'CNOPRE100001', 27000000),
(1, 15, 'CNOPRE100002', 27000000),
(1, 15, 'CNOPRE100003', 27000000),
(1, 15, 'CNOPRE100004', 27000000),
(1, 16, 'CNOPRE110001', 36000000),
(1, 16, 'CNOPRE110002', 36000000),
(1, 16, 'CNOPRE110003', 36000000),
(1, 16, 'CNOPRE110004', 36000000),
(1, 17, 'CNOPRE040001', 27000000),
(1, 17, 'CNOPRE040002', 27000000),
(1, 17, 'CNOPRE040003', 27000000),
(1, 18, 'CNRM100X0001', 8000000),
(1, 18, 'CNRM100X0002', 8000000),
(1, 18, 'CNRM100X0003', 8000000),
(1, 18, 'CNRM100X0004', 8000000),
(1, 19, 'CNRM11000001', 12000000),
(1, 19, 'CNRM11000002', 12000000),
(1, 19, 'CNRM11000003', 12000000),
(1, 19, 'CNRM11000004', 12000000),
(1, 20, 'CNRM120C0001', 15000000),
(1, 20, 'CNRM120C0002', 15000000),
(1, 20, 'CNRM120C0003', 15000000),
(1, 20, 'CNRM120C0004', 15000000),
(1, 21, 'CNRMNO080001', 5000000),
(1, 21, 'CNRMNO080002', 5000000),
(1, 21, 'CNRMNO080003', 5000000),
(1, 21, 'CNRMNO080004', 5000000),
(1, 22, 'CNRMNO110001', 6000000),
(1, 22, 'CNRMNO110002', 6000000),
(1, 22, 'CNRMNO110003', 6000000),
(1, 22, 'CNRMNO110004', 6000000),
(1, 23, 'CNRMNO120001', 7000000),
(1, 23, 'CNRMNO120002', 7000000),
(1, 23, 'CNRMNO120003', 7000000),
(1, 24, 'KRSGNO080001', 8000000),
(1, 24, 'KRSGNO080002', 8000000),
(1, 24, 'KRSGNO080003', 8000000),
(1, 24, 'KRSGNO080004', 8000000),
(1, 25, 'KRSGNO110001', 12000000),
(1, 25, 'KRSGNO110002', 12000000),
(1, 25, 'KRSGNO110003', 12000000),
(1, 25, 'KRSGNO110004', 12000000),
(1, 26, 'KRSGNO120001', 15000000),
(1, 26, 'KRSGNO120002', 15000000),
(1, 26, 'KRSGNO120003', 15000000),
(1, 27, 'KRSGA0300001', 38000000),
(1, 27, 'KRSGA0300002', 38000000),
(1, 27, 'KRSGA0300003', 38000000),
(1, 27, 'KRSGA0300004', 38000000),
(1, 28, 'KRSGA1300001', 38000000),
(1, 28, 'KRSGA1300002', 38000000),
(1, 28, 'KRSGA1300003', 38000000),
(1, 28, 'KRSGA1300004', 38000000),
(1, 29, 'KRSGA20S0001', 38000000),
(1, 29, 'KRSGA20S0002', 38000000),
(1, 29, 'KRSGA20S0003', 38000000),
(1, 29, 'KRSGA20S0004', 38000000),
(1, 30, 'KRSGA2300001', 38000000),
(1, 30, 'KRSGA2300002', 38000000),
(1, 30, 'KRSGA2300003', 38000000),
(1, 30, 'KRSGA2300004', 38000000),
(1, 31, 'KRSGA3300001', 38000000),
(1, 31, 'KRSGA3300002', 38000000),
(1, 31, 'KRSGA3300003', 38000000),
(1, 31, 'KRSGA3300004', 38000000),
(1, 32, 'KRSG22000001', 38000000),
(1, 32, 'KRSG22000002', 38000000),
(1, 32, 'KRSG22000003', 38000000),
(1, 32, 'KRSG22000004', 38000000),
(1, 33, 'KRSGA6000001', 38000000),
(1, 33, 'KRSGA6000002', 38000000),
(1, 33, 'KRSGA6000003', 38000000),
(1, 33, 'KRSGA6000004', 38000000),
(1, 34, 'CNLNK8000001', 38000000),
(1, 34, 'CNLNK8000002', 38000000),
(1, 34, 'CNLNK8000003', 38000000),
(1, 34, 'CNLNK8000004', 38000000),
(1, 35, 'CNLNPHAB0001', 38000000),
(1, 35, 'CNLNPHAB0002', 38000000),
(1, 35, 'CNLNPHAB0003', 38000000),
(1, 35, 'CNLNPHAB0004', 38000000),
(1, 36, 'CNLNS6600001', 38000000),
(1, 36, 'CNLNS6600002', 38000000),
(1, 36, 'CNLNS6600003', 38000000),
(1, 36, 'CNLNS6600004', 38000000),
(1, 37, 'CNLNS9300001', 38000000),
(1, 37, 'CNLNS9300002', 38000000),
(1, 37, 'CNLNS9300003', 38000000),
(1, 37, 'CNLNS9300004', 38000000),
(1, 38, 'CNLNVIX20001', 38000000),
(1, 38, 'CNLNVIX20002', 38000000),
(1, 38, 'CNLNVIX20003', 38000000),
(1, 38, 'CNLNVIX20004', 38000000),
(1, 39, 'CNLNZ5000001', 38000000),
(1, 39, 'CNLNZ5000002', 38000000),
(1, 39, 'CNLNZ5000003', 38000000),
(1, 39, 'CNLNZ5000004', 38000000),
(1, 40, 'CNLNOP700001', 38000000),
(1, 40, 'CNLNOP700002', 38000000),
(1, 40, 'CNLNOP700003', 38000000),
(1, 40, 'CNLNOP700004', 38000000),
(1, 41, 'JPSX01000001', 38000000),
(1, 41, 'JPSX01000002', 38000000),
(1, 41, 'JPSX01000003', 38000000),
(1, 41, 'JPSX01000004', 38000000),
(1, 42, 'JPSX05000001', 38000000),
(1, 42, 'JPSX05000002', 38000000),
(1, 42, 'JPSX05000003', 38000000),
(1, 42, 'JPSX05000004', 38000000),
(1, 43, 'JPSX10000001', 38000000),
(1, 43, 'JPSX10000002', 38000000),
(1, 43, 'JPSX10000003', 38000000),
(1, 43, 'JPSX10000004', 38000000),
(1, 44, 'JPSXXZ020001', 38000000),
(1, 44, 'JPSXXZ020002', 38000000),
(1, 44, 'JPSXXZ020003', 38000000),
(1, 44, 'JPSXXZ020004', 38000000),
(1, 45, 'JPSXXZ030001', 38000000),
(1, 45, 'JPSXXZ030002', 38000000),
(1, 45, 'JPSXXZ030003', 38000000),
(1, 45, 'JPSXXZ030004', 38000000);

-- Thêm dữ liệu vào bảng account

INSERT INTO account (username, password, role_id, status_account) VALUES
('KH01', 'kh01abc', 3, 1),
('admin', 'admin', 1, 1),
('NV01', 'NV01abc',2, 1),
('NV02', 'NV02abc',2, 1),
('NV03', 'NV03abc',2, 1),
('NV04', 'NV04abc',2, 1),
('NV05', 'NV05abc',2, 1),
('NV06', 'NV06abc',2, 1);

ALTER TABLE product_seri
ADD COLUMN status INT;

UPDATE product_seri
SET status = 1;

