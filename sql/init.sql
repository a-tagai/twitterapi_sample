-- MySQL

CREATE DATABASE loginApp;

USE loginApp;

CREATE TABLE users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),

  tw_user_id bigint unique,
  tw_user_name varchar(15),
  tw_access_token varchar(255),
  tw_access_token_secret varchar(255),

  created datetime,
  modified datetime
);

DESC users;
