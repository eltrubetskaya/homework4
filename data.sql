-- CREATE DATABASE db_homework_4 DEFAULT CHARACTER SET utf8;
-- GRANT USAGE ON *.* TO veta@localhost IDENTIFIED BY 'veta';
-- GRANT ALL ON db_homework_4.* TO veta@localhost;
-- GRANT SUPER ON *.* TO 'veta'@'localhost';

USE db_homework_4;

CREATE TABLE university (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  univer_name VARCHAR (255) NOT NULL,
  city VARCHAR (30) NOT NULL,
  site VARCHAR(60) NOT NULL
) ENGINE=InnoDB CHARACTER SET=UTF8;

CREATE TABLE students (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR (30) NOT NULL,
  last_name VARCHAR (30) NOT NULL,
  email VARCHAR(60) NOT NULL,
  tel VARCHAR(30) NOT NULL
) ENGINE=InnoDB CHARACTER SET=UTF8;

CREATE TABLE department (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  d_name CHAR (30) NOT NULL,
  univer_id INT NOT NULL,
  FOREIGN KEY (univer_id) REFERENCES university(id)
          ON UPDATE CASCADE
          ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;

CREATE TABLE disciplines(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  disc_name CHAR (30) NOT NULL,
  department_id INT NOT NULL,
  FOREIGN KEY (department_id) REFERENCES department(id)
          ON UPDATE CASCADE
          ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;

CREATE TABLE teacher (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR (30) NOT NULL,
  last_name VARCHAR (30) NOT NULL,
  department_id INT NOT NULL,
  FOREIGN KEY (department_id) REFERENCES department(id)
          ON UPDATE CASCADE
          ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;

CREATE TABLE homework (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  hw_name VARCHAR (60) NOT NULL,
  status TINYINT(1) NOT NULL,
  disciplines_id INT NOT NULL,
  teacher_id INT NOT NULL,
  student_id INT NOT NULL,
  FOREIGN KEY (disciplines_id) REFERENCES disciplines(id)
          ON UPDATE CASCADE
          ON DELETE RESTRICT,
  FOREIGN KEY (teacher_id) REFERENCES teacher(id)
          ON UPDATE CASCADE,
  FOREIGN KEY (student_id) REFERENCES students(id)
          ON UPDATE CASCADE
          ON DELETE RESTRICT
) ENGINE=InnoDB CHARACTER SET=UTF8;













