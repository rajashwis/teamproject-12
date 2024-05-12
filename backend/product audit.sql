------------------
---------PRODUCT
-----------------
DROP TABLE AUDIT_PRODUCT_RECORD; 

CREATE TABLE AUDIT_PRODUCT_RECORD (
    audit_id NUMBER(5) PRIMARY KEY,
    audit_user VARCHAR2(200),
    audit_date DATE,
    audit_action VARCHAR2(6),
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

CREATE OR REPLACE TRIGGER trig_product_audit
    AFTER INSERT OR DELETE OR UPDATE ON PRODUCT
    FOR EACH ROW
        DECLARE
            v_audit_id AUDIT_PRODUCT_RECORD.audit_id%TYPE;
            v_audit_action AUDIT_PRODUCT_RECORD.audit_action%TYPE;

        BEGIN

            SELECT MAX(NVL(audit_id,0)) + 1 INTO v_audit_id FROM AUDIT_PRODUCT_RECORD;

            IF v_audit_id IS NULL THEN
                v_audit_id := 1;
            END IF;

            IF inserting THEN
                v_audit_action := 'INSERT';
            ELSIF updating THEN
                v_audit_action := 'UPDATE';
            ELSIF deleting THEN
                v_audit_action := 'DELETE';
            ELSE
                v_audit_action := NULL;
            END IF;

            IF v_audit_action IN ('DELETE','UPDATE') THEN

                INSERT INTO audit_product_record VALUES (
                    v_audit_id,
                    UPPER(v('APP_USER')), 
                    SYSDATE, 
                    v_audit_action,
                    :OLD.product_id,
                    :OLD.product_name,
                    :OLD.description_, 
                    :OLD.price, 
                    :OLD.quantity_per_item, 
                    :OLD.stock_available, 
                    :OLD.min_order, 
                    :OLD.max_order, 
                    :OLD.allergy_information, 
                    :OLD.product_image, 
                    :OLD.date_added, 
                    :OLD.date_updated, 
                    :OLD.is_approved, 
                    :OLD.shop_id, 
                    :OLD.category_id, 
                    :OLD.discount_id
                );

            ELSE
                INSERT INTO audit_product_record VALUES (
                    v_audit_id,
                    UPPER(v('APP_USER')), 
                    SYSDATE, 
                    v_audit_action,
                    :NEW.product_id,
                    :NEW.product_name,
                    :NEW.description_, 
                    :NEW.price, 
                    :NEW.quantity_per_item, 
                    :NEW.stock_available, 
                    :NEW.min_order, 
                    :NEW.max_order, 
                    :NEW.allergy_information, 
                    :NEW.product_image, 
                    :NEW.date_added, 
                    :NEW.date_updated, 
                    :NEW.is_approved, 
                    :NEW.shop_id, 
                    :NEW.category_id, 
                    :NEW.discount_id
                );

            END IF;

        END;