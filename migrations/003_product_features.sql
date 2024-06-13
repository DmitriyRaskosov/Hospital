create table product_features 
(
id serial primary key, 
product_name integer references products (id), 
product_feature integer references features (id), 
feature_value varchar (100)
);