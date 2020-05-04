create or replace TRIGGER trig_userid_pk
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
SELECT USERID_SEQ.nextval into :new.User_id from dual;
end;

create or replace TRIGGER trig_customerid_pk
BEFORE INSERT ON customer
FOR EACH ROW
BEGIN
SELECT CUSTOMERID_SEQ.nextval into :new.Customer_id from dual;
end;

create or replace TRIGGER trig_adminid_pk
BEFORE INSERT ON admin
FOR EACH ROW
BEGIN
SELECT ADMINID_SEQ.nextval into :new.Admin_id from dual;
end;

create or replace TRIGGER trig_traderid_pk
BEFORE INSERT ON trader
FOR EACH ROW
BEGIN
SELECT TRADERID_SEQ.nextval into :new.Trader_id from dual;
end;

create or replace TRIGGER trig_aceesslogid_pk
BEFORE INSERT ON access_log
FOR EACH ROW
BEGIN
SELECT ACCESSLOGID_SEQ.nextval into :new.Access_log_id from dual;
end;

create or replace TRIGGER trig_tradertypeid_pk
BEFORE INSERT ON trader_type
FOR EACH ROW
BEGIN
SELECT TRADERTYPEID_SEQ.nextval into :new.Trader_type_id from dual;
end;

create or replace TRIGGER trig_shopid_pk
BEFORE INSERT ON shop
FOR EACH ROW
BEGIN
SELECT SHOPID_SEQ.nextval into :new.Shop_id from dual;
end;

create or replace TRIGGER trig_producttypeid_pk
BEFORE INSERT ON product_type
FOR EACH ROW
BEGIN
SELECT PRODUCTTYPEID_SEQ.nextval into :new.Product_type_id from dual;
end;

create or replace TRIGGER trig_productid_pk
BEFORE INSERT ON product
FOR EACH ROW
BEGIN
SELECT PRODUCTID_SEQ.nextval into :new.Product_id from dual;
end;

create or replace TRIGGER trig_productcommentid_pk
BEFORE INSERT ON product_comment
FOR EACH ROW
BEGIN
SELECT PRODUCTCOMMENTID_SEQ.nextval into :new.Product_comment_id from dual;
end;

create or replace TRIGGER trig_shopcommentid_pk
BEFORE INSERT ON shop_comment
FOR EACH ROW
BEGIN
SELECT SHOPCOMMENTID_SEQ.nextval into :new.Shop_comment_id from dual;
end;

create or replace TRIGGER trig_basketid_pk
BEFORE INSERT ON basket
FOR EACH ROW
BEGIN
SELECT BASKETID_SEQ.nextval into :new.Basket_id from dual;
end;

create or replace TRIGGER trig_discountid_pk
BEFORE INSERT ON discount
FOR EACH ROW
BEGIN
SELECT DISCOUNTID_SEQ.nextval into :new.Discount_id from dual;
end;

create or replace TRIGGER trig_basketproductid_pk
BEFORE INSERT ON basket_product
FOR EACH ROW
BEGIN
SELECT BASKETPRODUCTID_SEQ.nextval into :new.Basket_product_id from dual;
end;

create or replace TRIGGER trig_collectionslotid_pk
BEFORE INSERT ON collection_slot
FOR EACH ROW
BEGIN
SELECT COLLECTIONSLOTID_SEQ.nextval into :new.Collection_slot_id from dual;
end;

create or replace TRIGGER trig_invoiceid_pk
BEFORE INSERT ON invoice
FOR EACH ROW
BEGIN
SELECT INVOICEID_SEQ.nextval into :new.Invoice_id from dual;
end;

create or replace TRIGGER trig_paymentdetailid_pk
BEFORE INSERT ON payment_detail
FOR EACH ROW
BEGIN
SELECT PAYMENTDETAILID_SEQ.nextval into :new.Payment_detail_id from dual;
end;

