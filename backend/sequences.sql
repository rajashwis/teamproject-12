DROP SEQUENCE seq_cart_id;
DROP SEQUENCE seq_user_id;
DROP SEQUENCE seq_product_id;
DROP SEQUENCE seq_wishlistproduct_id;
DROP SEQUENCE seq_cartproduct_id;
DROP SEQUENCE seq_orderdetail_id;
DROP SEQUENCE seq_orderproduct_id;
DROP SEQUENCE seq_shop_id;
DROP SEQUENCE seq_category_id;
DROP SEQUENCE seq_wishlist_id;
DROP SEQUENCE seq_discount_id;

CREATE SEQUENCE seq_cart_id
    MINVALUE 1
    MAXVALUE 999
    INCREMENT BY 1
    START WITH 4
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_user_id
    MINVALUE 0001
    MAXVALUE 9999
    INCREMENT BY 1
    START WITH 0001
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_product_id
    MINVALUE 00001
    MAXVALUE 99999
    INCREMENT BY 1
    START WITH 0001
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_wishlistproduct_id
    MINVALUE 111
    MAXVALUE 9999
    INCREMENT BY 1
    START WITH 111
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_cartproduct_id
    MINVALUE 200
    MAXVALUE 9999
    INCREMENT BY 1
    START WITH 200
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_orderdetail_id
    MINVALUE 11111
    MAXVALUE 99999
    INCREMENT BY 1
    START WITH 11111
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_orderproduct_id
    MINVALUE 1
    MAXVALUE 9999
    INCREMENT BY 1
    START WITH 1
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_shop_id
    MINVALUE 2222
    MAXVALUE 5555
    INCREMENT BY 1
    START WITH 2222
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_category_id
    MINVALUE 444
    MAXVALUE 5555
    INCREMENT BY 1
    START WITH 444
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_wishlist_id
    MINVALUE 1111
    MAXVALUE 99999
    INCREMENT BY 1
    START WITH 1111
    NOCACHE
    NOCYCLE;
    
CREATE SEQUENCE seq_discount_id
    MINVALUE 1
    MAXVALUE 999
    INCREMENT BY 1
    START WITH 1
    NOCACHE
    NOCYCLE;