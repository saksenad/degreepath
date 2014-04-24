DROP DATABASE IF EXISTS degreepath;

CREATE DATABASE degreepath;
USE degreepath;

CREATE TABLE courses (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  subject varchar(255) NOT NULL,
  course_number varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  credit_hours int(10) unsigned NOT NULL,
  GPA float NOT NULL,
  prereqs varchar(1023) NOT NULL,
  course_CRN int(11) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE term_availability (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  term_code int(10) NOT NULL,
  course_id varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE user_semesters (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  term_code int(10) NOT NULL,
  PRIMARY KEY (id) 
);

CREATE TABLE user_subjects (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  subject varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  major varchar(255), 
  minor varchar(255),
  matriculation int(10),
  username varchar(255),
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE enrollments (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  course_id int(10) unsigned NOT NULL,
  user_id int(10) NOT NULL,
  term_code varchar(255) NOT NULL,
  PreReqSatisfied BOOL NOT NULL DEFAULT TRUE,
  PRIMARY KEY (id)
);
