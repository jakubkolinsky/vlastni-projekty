-- Active: 1717575850197@@127.0.0.1@3306@ukolnicek
CREATE DATABASE ukolnicek DEFAULT CHARSET utf8mb4;

CREATE TABLE poznamky (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nazev VARCHAR(255) NOT NULL,
    poznamka VARCHAR(255) NOT NULL
);

SHOW TABLES;