--------------------------------------------------------
--  DDL for Trigger TRIG_ACEESSLOGID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_ACEESSLOGID_PK" 
BEFORE INSERT ON access_log
FOR EACH ROW
BEGIN
SELECT ACCESSLOGID_SEQ.nextval into :new.Access_log_id from dual;
end;

/
ALTER TRIGGER "TRIG_ACEESSLOGID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_ADMINID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_ADMINID_PK" 
BEFORE INSERT ON admin
FOR EACH ROW
BEGIN
SELECT ADMINID_SEQ.nextval into :new.Admin_id from dual;
end;

/
ALTER TRIGGER "TRIG_ADMINID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_BASKETID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_BASKETID_PK" 
BEFORE INSERT ON basket
FOR EACH ROW
BEGIN
SELECT BASKETID_SEQ.nextval into :new.Basket_id from dual;
end;

/
ALTER TRIGGER "TRIG_BASKETID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_BASKETPRODUCTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_BASKETPRODUCTID_PK" 
BEFORE INSERT ON basket_product
FOR EACH ROW
BEGIN
SELECT BASKETPRODUCTID_SEQ.nextval into :new.Basket_product_id from dual;
end;

/
ALTER TRIGGER "TRIG_BASKETPRODUCTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_COLLECTIONSLOTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_COLLECTIONSLOTID_PK" 
BEFORE INSERT ON collection_slot
FOR EACH ROW
BEGIN
SELECT COLLECTIONSLOTID_SEQ.nextval into :new.Collection_slot_id from dual;
end;

/
ALTER TRIGGER "TRIG_COLLECTIONSLOTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_CUSTOMERID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_CUSTOMERID_PK" 
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
SELECT CUSTOMERID_SEQ.nextval into :new.Customer_id from dual;
end;

/
ALTER TRIGGER "TRIG_CUSTOMERID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_DISCOUNTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_DISCOUNTID_PK" 
BEFORE INSERT ON discount
FOR EACH ROW
BEGIN
SELECT DISCOUNTID_SEQ.nextval into :new.Discount_id from dual;
end;

/
ALTER TRIGGER "TRIG_DISCOUNTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_INVOICEID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_INVOICEID_PK" 
BEFORE INSERT ON invoice
FOR EACH ROW
BEGIN
SELECT INVOICEID_SEQ.nextval into :new.Invoice_id from dual;
end;

/
ALTER TRIGGER "TRIG_INVOICEID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_PAYMENTDETAILID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_PAYMENTDETAILID_PK" 
BEFORE INSERT ON payment_detail
FOR EACH ROW
BEGIN
SELECT PAYMENTDETAILID_SEQ.nextval into :new.Payment_detail_id from dual;
end;

/
ALTER TRIGGER "TRIG_PAYMENTDETAILID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_PRODUCTCOMMENTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_PRODUCTCOMMENTID_PK" 
BEFORE INSERT ON product_comment
FOR EACH ROW
BEGIN
SELECT PRODUCTCOMMENTID_SEQ.nextval into :new.Product_comment_id from dual;
end;

/
ALTER TRIGGER "TRIG_PRODUCTCOMMENTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_PRODUCTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_PRODUCTID_PK" 
BEFORE INSERT ON product
FOR EACH ROW
BEGIN
SELECT PRODUCTID_SEQ.nextval into :new.Product_id from dual;
end;

/
ALTER TRIGGER "TRIG_PRODUCTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_PRODUCTTYPEID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_PRODUCTTYPEID_PK" 
BEFORE INSERT ON product_type
FOR EACH ROW
BEGIN
SELECT PRODUCTTYPEID_SEQ.nextval into :new.Product_type_id from dual;
end;

/
ALTER TRIGGER "TRIG_PRODUCTTYPEID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_SHOPCOMMENTID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_SHOPCOMMENTID_PK" 
BEFORE INSERT ON shop_comment
FOR EACH ROW
BEGIN
SELECT SHOPCOMMENTID_SEQ.nextval into :new.Shop_comment_id from dual;
end;

/
ALTER TRIGGER "TRIG_SHOPCOMMENTID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_SHOPID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_SHOPID_PK" 
BEFORE INSERT ON shop
FOR EACH ROW
BEGIN
SELECT SHOPID_SEQ.nextval into :new.Shop_id from dual;
end;

/
ALTER TRIGGER "TRIG_SHOPID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_TRADERID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_TRADERID_PK" 
BEFORE INSERT ON trader
FOR EACH ROW
BEGIN
SELECT TRADERID_SEQ.nextval into :new.Trader_id from dual;
end;

/
ALTER TRIGGER "TRIG_TRADERID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_TRADERTYPEID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_TRADERTYPEID_PK" 
BEFORE INSERT ON trader_type
FOR EACH ROW
BEGIN
SELECT TRADERTYPEID_SEQ.nextval into :new.Trader_type_id from dual;
end;

/
ALTER TRIGGER "TRIG_TRADERTYPEID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_USERID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_USERID_PK" 
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
SELECT USERID_SEQ.nextval into :new.User_id from dual;
end;

/
ALTER TRIGGER "TRIG_USERID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRIG_VALIDATIONTOKENID_PK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "TRIG_VALIDATIONTOKENID_PK" 
BEFORE INSERT ON validation_token
FOR EACH ROW
BEGIN
SELECT VALIDATIONTOKENID_SEQ.nextval into :new.Validation_token_id from dual;
end;

/
ALTER TRIGGER "TRIG_VALIDATIONTOKENID_PK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger INVOICE_CS_UPDATE
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "INVOICE_CS_UPDATE" 
AFTER
insert on "INVOICE"
for each row
begin
UPDATE collection_slot SET Remaining_orders = Remaining_orders - 1 WHERE 
Collection_slot_id = :NEW.Collection_slot_id;
end;

/
ALTER TRIGGER "INVOICE_CS_UPDATE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger BASKET_PRODUCT_UPDATE_STOCK
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "BASKET_PRODUCT_UPDATE_STOCK" AFTERupdate on "BASKET_PRODUCT"for each row WHEN (NEW.Trx_completed = 'Y') begin
UPDATE product SET Stock_available = Stock_available - :new.PRODUCT_QUANTITY WHERE Product_id = :new.Product_id;
end;

/
ALTER TRIGGER "BASKET_PRODUCT_UPDATE_STOCK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger COLLECTION_SLOT_T1
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "COLLECTION_SLOT_T1" 
BEFORE
insert on "COLLECTION_SLOT"
for each row
 WHEN (NEW.REMAINING_ORDERS IS NULL) begin
SELECT :NEW.MAXIMUM_ORDERS into :new.REMAINING_ORDERS from dual;
end;

/
ALTER TRIGGER "COLLECTION_SLOT_T1" ENABLE;