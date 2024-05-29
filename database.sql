create database furniture_shop;
create table products (name varchar (50) primary key);
create table features (feature_name varchar (50) primary key);
create table product_features (id serial primary key, product_name varchar (50) references products (name), product_feature varchar (50) references features (feature_name), feature_value varchar (100));