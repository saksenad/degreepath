DROP DATABASE degreepath;

CREATE DATABASE degreepath;
USE degreepath;

CREATE TABLE courses (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  subject varchar(255) NOT NULL,
  course_number int NOT NULL,
  name varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE term_availability (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  term_code int(10) NOT NULL,
  course_id varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE enrollments (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  course_id int(10) unsigned NOT NULL,
  user_id varchar(255) NOT NULL,
  term_code varchar(255) NOT NULL,
  PRIMARY KEY (id)
);
