createdb fund_db -E UTF-8 -U postgres
createdb -U postgres fund_db


CREATE TABLE prices(
id serial primary key,
ms_code varchar(255),
price_date date,
price int
);
