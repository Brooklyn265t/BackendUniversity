create database if not exists coffeeprice;

use coffeeprice;
create table coffee (
  Coffee_ID INT(4) NOT NULL AUTO_INCREMENT,
  name VARCHAR(25) NOT NULL,
  PRIMARY KEY (Coffee_ID));

create table prices (
  Prices_ID INT(4) NOT NULL AUTO_INCREMENT,
  price INT(6) NOT NULL,
  Coffee_ID INT(4) NOT NULL,
  PRIMARY KEY (Prices_ID),
  FOREIGN KEY (Coffee_ID) REFERENCES coffee (Coffee_ID));

INSERT INTO coffee (Coffee_ID, name) VALUES
(1, 'Exprsso'),
(2, 'Americano'),
(3, 'Capuchino');

INSERT INTO prices (Prices_ID, price, Coffee_ID) VALUES
(1, 200, 1),
(2, 400, 2),
(3, 300, 3);
