DROP TABLE ProductCategory CASCADE CONSTRAINTS;
DROP TABLE Discount CASCADE CONSTRAINTS;
DROP TABLE CollectionSlot CASCADE CONSTRAINTS;
DROP TABLE Review CASCADE CONSTRAINTS;
DROP TABLE WishlistProduct CASCADE CONSTRAINTS;
DROP TABLE CartProduct CASCADE CONSTRAINTS;
DROP TABLE OrderDetail CASCADE CONSTRAINTS;
DROP TABLE Product CASCADE CONSTRAINTS;
DROP TABLE OrderProduct CASCADE CONSTRAINTS;
DROP TABLE PaymentType CASCADE CONSTRAINTS;
DROP TABLE Payment CASCADE CONSTRAINTS;
DROP TABLE ProductReport CASCADE CONSTRAINTS;
DROP TABLE Report CASCADE CONSTRAINTS;
DROP TABLE Wishlist CASCADE CONSTRAINTS;
DROP TABLE Shop CASCADE CONSTRAINTS;
DROP TABLE Admin_ CASCADE CONSTRAINTS;
DROP TABLE Trader CASCADE CONSTRAINTS;
DROP TABLE Customer CASCADE CONSTRAINTS;
DROP TABLE User_ CASCADE CONSTRAINTS;
DROP TABLE Cart CASCADE CONSTRAINTS;

--1. CART TABLE
CREATE TABLE Cart(
    cart_id NUMBER(4),
    item_quantity NUMBER NOT NULL
);

ALTER TABLE Cart
ADD CONSTRAINT pk_cart_id PRIMARY KEY(cart_id);

--2. USER TABLE
CREATE TABLE User_(
    user_id NUMBER(5), 
    username VARCHAR2(16) UNIQUE NOT NULL, 
    email VARCHAR2(200) UNIQUE NOT NULL, 
    password_ VARCHAR2(500) NOT NULL, 
    user_role VARCHAR2(8) NOT NULL,
    first_name VARCHAR2(80) NOT NULL, 
    last_name VARCHAR2(200) NOT NULL, 
    gender CHAR, 
    address_ VARCHAR2(300), 
    date_of_birth DATE NOT NULL, 
    profile_picture BLOB
);

ALTER TABLE User_
ADD CONSTRAINT pk_user_id PRIMARY KEY(user_id);

ALTER TABLE User_
ADD CONSTRAINT check_user_role CHECK(user_role in ('Admin', 'Trader', 'Customer'));

ALTER TABLE User_
ADD CONSTRAINT check_user_gender CHECK(gender in ('M', 'F', 'O'));

--3. ADMIN TABLE
CREATE TABLE Admin_(
    admin_id NUMBER(5)
);

ALTER TABLE Admin_
ADD CONSTRAINT fk_admin_id FOREIGN KEY(admin_id)
REFERENCES User_(user_id);

ALTER TABLE Admin_
ADD CONSTRAINT pk_admin_id PRIMARY KEY(admin_id);

--4. TRADER TABLE
CREATE TABLE Trader(
    trader_id NUMBER(5),
    date_joined DATE NOT NULL,
    date_updated DATE,
    verification_code NUMBER(6) NOT NULL,
    is_verified NUMBER NOT NULL,
    is_approved NUMBER NOT NULL
);

ALTER TABLE Trader
ADD CONSTRAINT fk_trader_id FOREIGN KEY(trader_id)
REFERENCES User_(user_id);

ALTER TABLE Trader
ADD CONSTRAINT pk_trader_id PRIMARY KEY(trader_id);

ALTER TABLE Trader
ADD CONSTRAINT check_trader_verification CHECK(is_verified in (0, 1));

ALTER TABLE Trader
ADD CONSTRAINT check_trader_approval CHECK(is_approved in (0, 1));

--5. CUSTOMER TABLE
CREATE TABLE Customer(
    customer_id NUMBER(5),
    date_joined DATE NOT NULL,
    date_updated DATE,
    verification_code NUMBER(6) NOT NULL,
    is_verified NUMBER NOT NULL,
    cart_id NUMBER(4)
);

ALTER TABLE Customer
ADD CONSTRAINT fk_customer_id FOREIGN KEY(customer_id)
REFERENCES User_(user_id);

ALTER TABLE Customer
ADD CONSTRAINT fk_customer_cart_id FOREIGN KEY(cart_id)
REFERENCES Cart(cart_id);

ALTER TABLE Customer
ADD CONSTRAINT pk_customer_id PRIMARY KEY(customer_id);

ALTER TABLE Customer
ADD CONSTRAINT check_customer_verification CHECK(is_verified in (0, 1));

--6. SHOP TABLE
CREATE TABLE Shop (
    shop_id NUMBER(5),
    shop_name VARCHAR2(40) NOT NULL,
    address VARCHAR2(60), 
    date_updated DATE,
    is_approved NUMBER NOT NULL,
    trader_id NUMBER(5)
);

ALTER TABLE Shop
ADD CONSTRAINT fk_shop_trader_id FOREIGN KEY(trader_id)
REFERENCES Trader(trader_id);

ALTER TABLE Shop
ADD CONSTRAINT pk_shop_id PRIMARY KEY(shop_id);

ALTER TABLE Shop
ADD CONSTRAINT check_shop_approval CHECK(is_approved in (0, 1));

--7. WISHLIST TABLE
CREATE TABLE Wishlist(
    wishlist_id NUMBER(5),
    customer_id NUMBER(5)
);

ALTER TABLE Wishlist
ADD CONSTRAINT fk_wishlist_customer_id FOREIGN KEY(customer_id)
REFERENCES Customer(customer_id);

ALTER TABLE Wishlist
ADD CONSTRAINT pk_wishlist_id PRIMARY KEY(wishlist_id);

--8. PRODUCT CATEGORY TABLE
CREATE TABLE ProductCategory(
    category_id NUMBER(4), 
    category_name VARCHAR2(500) NOT NULL,
    trader_id NUMBER(5)
);

ALTER TABLE PRODUCTCATEGORY 
ADD CONSTRAINT fk_category_trader_id FOREIGN KEY(trader_id)
REFERENCES Trader(trader_id);

ALTER TABLE ProductCategory
ADD CONSTRAINT pk_product_category_id PRIMARY KEY(category_id);

--9. DISCOUNT TABLE
CREATE TABLE Discount(
    discount_id NUMBER(4), 
    discount_percentage NUMBER(3,2) NOT NULL, 
    start_date DATE NOT NULL, 
    end_date DATE, 
    description_ VARCHAR2(700), 
    discount_image BLOB,
    trader_id NUMBER(5)
);

ALTER TABLE Discount
ADD CONSTRAINT fk_discount_trader_id FOREIGN KEY(trader_id)
REFERENCES Trader(trader_id);

ALTER TABLE Discount
ADD CONSTRAINT pk_product_discount_id PRIMARY KEY(discount_id);

--10. PRODUCT TABLE
CREATE TABLE Product(
    product_id NUMBER(5),
    product_name VARCHAR2(200) NOT NULL,
    description_ VARCHAR2 (3000), 
    price NUMBER(5) NOT NULL, 
    quantity_per_item NUMBER(3), 
    stock_available NUMBER(5) NOT NULL, 
    min_order NUMBER(3), 
    max_order NUMBER(3), 
    allergy_information VARCHAR2(3000), 
    product_image BLOB, 
    date_added DATE, 
    date_updated DATE, 
    is_approved NUMBER NOT NULL, 
    shop_id NUMBER(4), 
    category_id NUMBER(4), 
    discount_id NUMBER(4)
);

ALTER TABLE Product
ADD CONSTRAINT fk_product_shop_id FOREIGN KEY(shop_id)
REFERENCES Shop(shop_id);

ALTER TABLE Product
ADD CONSTRAINT fk_product_discount_id FOREIGN KEY(discount_id)
REFERENCES Discount(discount_id);

ALTER TABLE Product
ADD CONSTRAINT fk_product_category_id FOREIGN KEY(category_id)
REFERENCES ProductCategory(category_id);

ALTER TABLE Product
ADD CONSTRAINT pk_product_id PRIMARY KEY(product_id);

ALTER TABLE Product
ADD CONSTRAINT check_product_approval CHECK(is_approved in (0, 1));

--11. WISHLIST PRODUCT TABLE
CREATE TABLE WishlistProduct(
    wishlist_product_id NUMBER(4),
    wishlist_id NUMBER(4),
    product_id NUMBER(5)
);

ALTER TABLE WishlistProduct
ADD CONSTRAINT fk_wishlist_id FOREIGN KEY(wishlist_id)
REFERENCES Wishlist(wishlist_id);

ALTER TABLE WishlistProduct
ADD CONSTRAINT fk_wishlist_product_id FOREIGN KEY(product_id)
REFERENCES Product(product_id);

ALTER TABLE WishlistProduct
ADD CONSTRAINT pk_wishlist_product_id PRIMARY KEY(wishlist_product_id);

--12. CART PRODUCT TABLE
CREATE TABLE CartProduct(
    cart_product_id NUMBER(4),
    cart_id NUMBER(4),
    product_id NUMBER(5),
    product_quantity NUMBER(4)
);

ALTER TABLE CartProduct
ADD CONSTRAINT fk_cart_id FOREIGN KEY(cart_id)
REFERENCES Cart(cart_id);

ALTER TABLE CartProduct
ADD CONSTRAINT fk_cart_product_id FOREIGN KEY(product_id)
REFERENCES Product(product_id);

ALTER TABLE CartProduct
ADD CONSTRAINT pk_cart_product_id PRIMARY KEY(cart_product_id);

--13. COLLECTION SLOT TABLE
CREATE TABLE CollectionSlot(
    collection_slot_id NUMBER(4),
    day_of_week VARCHAR(10) NOT NULL,
    time_ DATE NOT NULL,
    order_quantity NUMBER(2)
);

ALTER TABLE CollectionSlot
ADD CONSTRAINT pk_collection_slot_id PRIMARY KEY(collection_slot_id);

--14. ORDER DETAIL TABLE
CREATE TABLE OrderDetail(
    order_id NUMBER(5),
    order_date DATE NOT NULL,
    quantity NUMBER(5) NOT NULL,
    is_paid NUMBER NOT NULL,
    cart_id NUMBER(4),
    customer_id NUMBER(5),
    collection_slot_id NUMBER(4)
);

ALTER TABLE OrderDetail
ADD CONSTRAINT fk_order_cart_id FOREIGN KEY (cart_id)
REFERENCES Cart(cart_id);

ALTER TABLE OrderDetail
ADD CONSTRAINT fk_order_customer_id FOREIGN KEY(customer_id)
REFERENCES Customer(customer_id);

ALTER TABLE OrderDetail
ADD CONSTRAINT fk_collection_slot_id FOREIGN KEY(collection_slot_id)
REFERENCES CollectionSlot(collection_slot_id);

ALTER TABLE OrderDetail
ADD CONSTRAINT pk_order_detail_id PRIMARY KEY(order_id);

ALTER TABLE OrderDetail
ADD CONSTRAINT check_order_payment CHECK(is_paid in (0, 1));

--15. ORDER PRODUCT TABLE
CREATE TABLE OrderProduct (
    order_product_id NUMBER(5),
    order_id NUMBER(5),
    product_id NUMBER(5),
    item_quantity NUMBER(5)
);

ALTER TABLE OrderProduct
ADD CONSTRAINT fk_product_order_id FOREIGN KEY(order_id)
REFERENCES OrderDetail(order_id);

ALTER TABLE OrderProduct
ADD CONSTRAINT fk_product_id FOREIGN KEY(product_id)
REFERENCES Product(product_id);

ALTER TABLE OrderProduct
ADD CONSTRAINT pk_order_product_id PRIMARY KEY(order_product_id);

--16.  PAYMENT TYPE TABLE
CREATE TABLE PaymentType (
    payment_type_id NUMBER(6),
    payment_type VARCHAR2(100) NOT NULL
);

ALTER TABLE PaymentType
ADD CONSTRAINT pk_payment_type_id PRIMARY KEY(payment_type_id);

--17. PAYMENT TABLE
CREATE TABLE Payment (
    payment_id NUMBER(5),
    payment_amount NUMBER(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    order_id NUMBER(5),
    payment_type_id NUMBER(6),
    customer_id NUMBER(5)
);

ALTER TABLE Payment 
ADD CONSTRAINT fk_payment_order_id FOREIGN KEY(order_id)
REFERENCES OrderDetail(order_id);

ALTER TABLE Payment
ADD CONSTRAINT fk_payment_type_id FOREIGN KEY (payment_type_id)
REFERENCES PaymentType(payment_type_id);

ALTER TABLE Payment
ADD CONSTRAINT fk_payment_customer_id FOREIGN KEY(customer_id)
REFERENCES Customer(customer_id);

ALTER TABLE Payment
ADD CONSTRAINT pk_payment_id PRIMARY KEY(payment_id);

--18. REVIEW TABLE
CREATE TABLE Review(
    review_id NUMBER(4), 
    rating NUMBER(1,1), 
    comment_ VARCHAR2(1000), 
    review_date DATE NOT NULL, 
    customer_id NUMBER(5) NOT NULL, 
    product_id NUMBER(5) NOT NULL
);

ALTER TABLE Review
ADD CONSTRAINT fk_review_customer_id FOREIGN KEY(customer_id)
REFERENCES Customer(customer_id);

ALTER TABLE Review
ADD CONSTRAINT fk_review_product_id FOREIGN KEY(product_id)
REFERENCES Product(product_id);

ALTER TABLE Review
ADD CONSTRAINT pk_review_id PRIMARY KEY(review_id);

ALTER TABLE Review
ADD CONSTRAINT check_review_rating CHECK(rating >= 0 AND rating <= 5);

--19. REPORT TABLE
CREATE TABLE Report (
    report_id NUMBER(6),
    user_id NUMBER(5)
);

ALTER TABLE Report
ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id)
REFERENCES User_(user_id);

ALTER TABLE Report
ADD CONSTRAINT pk_report_id PRIMARY KEY(report_id);

--20.PRODUCT REPORT TABLE
CREATE TABLE ProductReport(
    product_report_id NUMBER(5), 
    product_id NUMBER(5),
    report_id NUMBER(6)
);

ALTER TABLE ProductReport
ADD CONSTRAINT fk_report_id FOREIGN KEY(report_id)
REFERENCES Report(report_id);

ALTER TABLE ProductReport
ADD CONSTRAINT fk_report_product_id FOREIGN KEY(product_id)
REFERENCES Product(product_id);

ALTER TABLE ProductReport
ADD CONSTRAINT pk_product_report_id PRIMARY KEY(product_report_id);