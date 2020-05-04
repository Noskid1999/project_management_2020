DROP TABLE users CASCADE CONSTRAINTS;
DROP TABLE customer CASCADE CONSTRAINTS;
DROP TABLE admin CASCADE CONSTRAINTS;
DROP TABLE trader CASCADE CONSTRAINTS;
DROP TABLE access_log CASCADE CONSTRAINTS;
DROP TABLE trader_type CASCADE CONSTRAINTS;
DROP TABLE shop CASCADE CONSTRAINTS;
DROP TABLE product_type CASCADE CONSTRAINTS;
DROP TABLE product CASCADE CONSTRAINTS;
DROP TABLE product_comment CASCADE CONSTRAINTS;
DROP TABLE shop_comment CASCADE CONSTRAINTS;
DROP TABLE basket CASCADE CONSTRAINTS;
DROP TABLE discount CASCADE CONSTRAINTS;
DROP TABLE basket_product CASCADE CONSTRAINTS;
DROP TABLE collection_slot CASCADE CONSTRAINTS;
DROP TABLE invoice CASCADE CONSTRAINTS;
DROP TABLE payment_detail CASCADE CONSTRAINTS;


CREATE TABLE users(
    User_id int PRIMARY KEY,
    First_name VARCHAR(50) NOT NULL,
    Last_name VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Address VARCHAR(50),
    Phone_number VARCHAR(15),
    Is_verified varchar(1) not null
);

CREATE TABLE customer(
    Customer_id int PRIMARY KEY,
    User_id int REFERENCES users(User_id)
);

CREATE TABLE admin(
    Admin_id int PRIMARY KEY,
    User_id int REFERENCES users(User_id)
);

CREATE TABLE trader(
    Trader_id int PRIMARY KEY,
    User_id int REFERENCES users(User_id)
);


CREATE TABLE access_log(
    Access_log_id int PRIMARY KEY,
    User_id int REFERENCES users(User_id),
    Admin_id int REFERENCES admin(Admin_id),
    Access_time TIMESTAMP,
    Activity VARCHAR(150)
);

CREATE TABLE trader_type(
    Trader_type_id int PRIMARY KEY,
    Trader_id int REFERENCES Trader(Trader_id),
    Type VARCHAR(50) NOT NULL,
    Description VARCHAR(150)
);

CREATE TABLE shop(
    Shop_id int PRIMARY KEY,
    Trader_type_id int REFERENCES trader_type(Trader_type_id),
    Shop_name VARCHAR(100) NOT NULL
); 

CREATE TABLE product_type(
    Product_type_id int PRIMARY KEY,
    Shop_id int REFERENCES shop(shop_id),
    Type VARCHAR(50) NOT NULL,
    Description VARCHAR(150)
);


CREATE TABLE product(
    Product_id int PRIMARY KEY,
    Product_type_id int REFERENCES product_type(Product_type_id),
    Product_name VARCHAR(50) NOT NULL,
    Description VARCHAR(150),
    Product_price NUMERIC(10,2) NOT NULL,
    Quantity_per_item int NOT NULL,
    Stock_available VARCHAR(1) NOT NULL,
    Min_order int NOT NULL,
    Max_order int NOT NULL,
    Allergy_information VARCHAR(150)
);
    
CREATE TABLE product_comment(
    Product_comment_id int PRIMARY KEY,
    Product_id int REFERENCES product(Product_id),
    User_id int REFERENCES users(User_id),
    Reply_of INT REFERENCES product_comment(Product_comment_id),
    Product_comment VARCHAR(150)
);
    
CREATE TABLE shop_comment(
    Shop_comment_id int PRIMARY KEY,
    Shop_id int REFERENCES product(Product_id),
    User_id int REFERENCES users(User_id),
    Reply_of INT REFERENCES product_comment(Product_comment_id),
    Product_comment VARCHAR(150)
); 

CREATE TABLE basket(
    Basket_ID int PRIMARY KEY,
    Customer_ID int REFERENCES customer(Customer_id)
);
  

CREATE TABLE discount(
    Discount_id int PRIMARY KEY,
    Discount_amount NUMERIC(3,2),
    Description LONG VARCHAR
);

CREATE TABLE basket_product(
    Basket_product_id int PRIMARY KEY,
    Basket_id int REFERENCES basket(Basket_id) not null,
    Product_id int REFERENCES product(Product_id) not null,
    Added_to_basket_time TIMESTAMP,
    Product_price NUMERIC(10,2) not null,
    Discount_id int REFERENCES discount(Discount_id)
);


CREATE TABLE collection_slot(
    Collection_slot_id int PRIMARY KEY,
    Added_by int  not null REFERENCES admin(Admin_id),
    Start_time timestamp not null,
    End_time timestamp not null,
    Maximum_orders INT NOT NULL
);

CREATE TABLE invoice(
    Invoice_id int PRIMARY KEY,
    Discount_id int REFERENCES discount(Discount_id),
    Invoice_time TIMESTAMP not null,
    Total_amount NUMERIC(10,2) not null,
    Delivery_status varchar(1)
);

CREATE TABLE payment_detail(
    Payment_detail_id int PRIMARY KEY,
    Basket_product_id int REFERENCES basket_product(Basket_product_id) not null,
    Payment_identification VARCHAR(50),
    Invoice_id int REFERENCES invoice(Invoice_id) not null,
    Payment_type VARCHAR(10) not null
);



