DROP DATABASE IF EXISTS hotels;

CREATE DATABASE IF NOT EXISTS hotels
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_general_ci;

USE hotels;

DROP TABLE IF EXISTS `cache`;

CREATE TABLE IF NOT EXISTS `cache` (
    offer_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    hotel_id INT NOT NULL,
    hotel_name VARCHAR(255) NOT NULL,
    price DECIMAL(4,2) NOT NULL,
    source VARCHAR(5) NOT NULL,
    country_id INT NOT NULL,
    country VARCHAR(50) NOT NULL,
    city_id INT NOT NULL,
    city VARCHAR(100) NOT NULL,
    zip VARCHAR(50) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    latitude VARCHAR(100) NOT NULL,
    longitude VARCHAR(100) NOT NULL,
    star INT DEFAULT 0,
    `image` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET GLOBAL event_scheduler = ON;
DROP EVENT IF EXISTS delete_offers;

CREATE EVENT delete_offers
ON SCHEDULE EVERY 20 MINUTE
DO DELETE FROM `cache`;