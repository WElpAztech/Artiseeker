CREATE DATABASE Artiseeker;
    
USE Artiseeker;

CREATE TABLE users (
    id INT AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE genshin_uids (
    user_id INT,
    genshin_uid VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

/* TRUNCATE TABLE genshin_uids; */