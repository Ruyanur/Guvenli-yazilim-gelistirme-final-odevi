CREATE DATABASE kullanici_sistemi;

USE kullanici_sistemi;

CREATE TABLE kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kullanici_adi VARCHAR(50) NOT NULL,
    sifre VARCHAR(255) NOT NULL
);

INSERT INTO kullanicilar (kullanici_adi, sifre) VALUES ('admin', MD5('password'));
select*from kullanici_sistemi.kullanicilar;