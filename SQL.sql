



DROP TRIGGER IF EXISTS kontrol_rol_limit;




DELIMITER //

CREATE TRIGGER kontrol_rol_limit
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    IF (NEW.role = 'editör' AND (SELECT COUNT(*) FROM users WHERE role = 'editör') > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir admin kullanıcısı olabilir.';
     END IF;
    IF (NEW.role = 'editor' AND (SELECT COUNT(*) FROM users WHERE role = 'editor') > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir editor kullanıcısı olabilir.';
    END IF;
END//

DELIMITER ;

-- Mevcut tabloyu yedekleyin (Opsiyonel)
CREATE TABLE users_backup AS SELECT * FROM users;

-- Mevcut tabloyu düşürün
DROP TABLE IF EXISTS users;

-- Yeni tabloyu oluşturun
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    yas INT,
    meslek VARCHAR(255),
    hobiler TEXT,
    email TEXT,
    role ENUM('admin', 'editor', 'viewer') NOT NULL
);






-- Step 1: Drop the foreign key constraint from the products table
ALTER TABLE products DROP FOREIGN KEY products_ibfk_1;

-- Step 2: Drop the users table
DROP TABLE `user_management`.`users`;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM users
WHERE kullanici_id NOT IN (SELECT id FROM users);

ALTER TABLE products ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (kullanici_id) REFERENCES users(id) ON DELETE CASCADE;
SET SQL_SAFE_UPDATES = 1;

select*from users
ALTER TABLE products DROP FOREIGN KEY products_ibfk_1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    yas INT,
    meslek VARCHAR(255),
    hobiler TEXT,
    email TEXT,
    role ENUM('admin', 'editor', 'viewer') NOT NULL
);
ALTER TABLE products ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (kullanici_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE products ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (kullanici_id) REFERENCES users(id) ON DELETE CASCADE;

DELIMITER //

CREATE TRIGGER kontrol_rol_limit ONCE_INSERT ON users
FOR EACH ROW
BEGIN
    IF (NEW.role = 'admin' AND (SELECT COUNT(*) FROM users WHERE role = 'admin') > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir admin kullanıcısı olabilir.';
    END IF;
    IF (NEW.role = 'editor' AND (SELECT COUNT(*) FROM users WHERE role = 'editor') > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir editor kullanıcısı olabilir.';
    END IF;
END//

DELIMITER ;

DELIMITER //

CREATE TRIGGER kontrol_rol_limit_guncelleme ONCE_UPDATE ON users
FOR EACH ROW
BEGIN
    IF (NEW.role = 'admin' AND (SELECT COUNT(*) FROM users WHERE role = 'admin' AND id != OLD.id) > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir admin kullanıcısı olabilir.';
    END IF;
    IF (NEW.role = 'editor' AND (SELECT COUNT(*) FROM users WHERE role = 'editor' AND id != OLD.id) > 0) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir editor kullanıcısı olabilir.';
    END IF;
END//

DELIMITER ;

drop table users;
select*from users;
TRUNCATE TABLE users;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kullanici_id INT NOT NULL,
    urun_adi VARCHAR(255) NOT NULL,
    fiyat DECIMAL(10, 2) NOT NULL,
    kategori VARCHAR(255),
    stok INT,
    aciklama TEXT,
    eklenme_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kullanici_id) REFERENCES users(id) ON DELETE CASCADE
);
select*from products;


SELECT kullanici_id 
FROM products 
WHERE kullanici_id NOT IN (SELECT id FROM users);


DELETE FROM products 
WHERE kullanici_id NOT IN (SELECT id FROM users);




DELIMITER //

CREATE TRIGGER kontrol_rol_limit
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    DECLARE admin_count INT;
    DECLARE editor_count INT;

    -- Admin sayısını kontrol et
    SELECT COUNT(*) INTO admin_count FROM users WHERE role = 'admin';
    IF (NEW.role = 'admin' AND admin_count >= 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir admin kullanıcısı olabilir.';
    END IF;

    -- Editor sayısını kontrol et
    SELECT COUNT(*) INTO editor_count FROM users WHERE role = 'editor';
    IF (NEW.role = 'editor' AND editor_count >= 1) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sadece bir editor kullanıcısı olabilir.';
    END IF;
END;
//

DELIMITER ;

-- 1. Yabancı anahtar kısıtlamasını kaldır
ALTER TABLE products DROP FOREIGN KEY products_ibfk_1;

-- 2. users tablosunu boşalt
TRUNCATE TABLE users;

-- 3. Yabancı anahtar kısıtlamasını tekrar ekle
ALTER TABLE products ADD CONSTRAINT products_ibfk_1 FOREIGN KEY (kullanici_id) REFERENCES users(id) ON DELETE CASCADE;


select*from db.users;
CREATE TABLE db.users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
   
);