select*from user_management.products
ALTER TABLE users
MODIFY COLUMN role ENUM('admin', 'editor', 'viewer', 'bos') NOT NULL;

update products
 set stok='3'
 where id =8;
 
 CREATE TABLE satin_almalar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kullanici_id INT NOT NULL,
    urun_id INT NOT NULL,
    satinalma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kullanici_id) REFERENCES users(id),
    FOREIGN KEY (urun_id) REFERENCES products(id)
);
