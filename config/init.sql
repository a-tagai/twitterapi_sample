-- MySQL

CREATE DATABASE loginApp;

USE loginApp;

CREATE TABLE users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

DESC users;
