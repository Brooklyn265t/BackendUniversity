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

create table user (
  User_ID INT(4) NOT NULL AUTO_INCREMENT,
  name VARCHAR(25) NOT NULL,
  surname VARCHAR(30) NOT NULL,
  phone VARCHAR(11) NOT NULL,
  PRIMARY KEY (User_ID));

create table pdf (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(128) NOT NULL,
  mimetype VARCHAR(64) NOT NULL,
  data MEDIUMBLOB NOT NULL
);

INSERT INTO coffee (Coffee_ID, name) VALUES
(1, 'Exprsso'),
(2, 'Americano'),
(3, 'Capuchino'),
(4, 'NOCOFFEE');

INSERT INTO prices (Prices_ID, price, Coffee_ID) VALUES
(1, 200, 1),
(2, 400, 2),
(3, 300, 3);

INSERT INTO user (User_ID, name, surname, phone) VALUES
(1, 'Alex', 'Ivanov','80000000000'),
(2, 'Ana', 'Petrova','80000000001'),
(3, 'Nikita', 'Sidorov','80000000002');
