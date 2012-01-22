CREATE TABLE feedback (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255),
    `email` VARCHAR(255),
    `topic` VARCHAR(255),
    `feeling` INT,
    `feedback` TEXT
) DEFAULT CHARSET=utf8;