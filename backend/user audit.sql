DROP TABLE AUDIT_TRADER_RECORD;
DROP TABLE AUDIT_CUSTOMER_RECORD;
DROP TABLE AUDIT_PRODUCT_RECORD;

------------------
---------TRADER
-----------------
CREATE TABLE AUDIT_TRADER_RECORD (
    audit_id NUMBER(5),
    audit_user VARCHAR2(200),
    audit_date DATE,
    audit_action VARCHAR2(6),
    trader_id NUMBER(5), 
    user_name VARCHAR2(16) NOT NULL, 
    email VARCHAR2(200) NOT NULL, 
    password_ VARCHAR2(16) NOT NULL, 
    first_name VARCHAR2(80) NOT NULL, 
    last_name VARCHAR2(200) NOT NULL, 
    gender CHAR, 
    address VARCHAR2(300), 
    date_of_birth DATE NOT NULL, 
    profile_picture BLOB
);

------------------
---------CUSTOMER
-----------------
CREATE TABLE AUDIT_CUSTOMER_RECORD (
    audit_id NUMBER(5),
    audit_user VARCHAR2(200),
    audit_date DATE,
    audit_action VARCHAR2(6),
    customer_id NUMBER(5), 
    user_name VARCHAR2(16) NOT NULL, 
    email VARCHAR2(200) NOT NULL, 
    password_ VARCHAR2(16) NOT NULL, 
    first_name VARCHAR2(80) NOT NULL, 
    last_name VARCHAR2(200) NOT NULL, 
    gender CHAR, 
    address VARCHAR2(300), 
    date_of_birth DATE NOT NULL, 
    profile_picture BLOB
);

CREATE OR REPLACE TRIGGER trig_user_audit
    AFTER INSERT OR DELETE OR UPDATE ON USER_
    FOR EACH ROW
        DECLARE
            v_audit_id AUDIT_CUSTOMER_RECORD.audit_id%TYPE;
            v_audit_action AUDIT_TRADER_RECORD.audit_action%TYPE;
            v_user_role VARCHAR2(40);
        BEGIN
            v_user_role := :OLD.user_role;

            IF v_user_role = 'Trader' THEN
                SELECT MAX(NVL(audit_id,0)) + 1 INTO v_audit_id FROM AUDIT_TRADER_RECORD;
            ELSIF v_user_role = 'Customer' THEN
                SELECT MAX(NVL(audit_id,0)) + 1 INTO v_audit_id FROM AUDIT_TRADER_RECORD;
            END IF;

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

                IF v_user_role = 'Customer' THEN

                    INSERT INTO AUDIT_CUSTOMER_RECORD VALUES (
                        v_audit_id, UPPER(v('APP_USER')), SYSDATE, v_audit_action,:OLD.user_id, :OLD.user_name, :OLD.email, :OLD.password_, :OLD.first_name, 
                        :OLD.last_name, :OLD.gender, :OLD.address, :OLD.date_of_birth, :OLD.profile_picture
                    );
                ELSE
                    INSERT INTO AUDIT_TRADER_RECORD VALUES (
                        v_audit_id, UPPER(v('APP_USER')), SYSDATE, v_audit_action,:OLD.user_id, :OLD.user_name, :OLD.email, :OLD.password_, :OLD.first_name, 
                        :OLD.last_name, :OLD.gender, :OLD.address, :OLD.date_of_birth, :OLD.profile_picture
                    );

                END IF;
                

            ELSE
                IF v_user_role = 'Trader' THEN
                    INSERT INTO AUDIT_TRADER_RECORD VALUES (
                            v_audit_id, UPPER(v('APP_USER')), SYSDATE, v_audit_action,:NEW.user_id, :NEW.user_name, :NEW.email, :NEW.password_, :NEW.first_name, 
                            :NEW.last_name, :NEW.gender, :NEW.address, :NEW.date_of_birth, :NEW.profile_picture
                        );
                
                ELSE
                    INSERT INTO AUDIT_CUSTOMER_RECORD VALUES (
                            v_audit_id, UPPER(v('APP_USER')), SYSDATE, v_audit_action,:NEW.user_id, :NEW.user_name, :NEW.email, :NEW.password_, :NEW.first_name, 
                            :NEW.last_name, :NEW.gender, :NEW.address, :NEW.date_of_birth, :NEW.profile_picture
                        );

                END IF;

         
            END IF;

        END;