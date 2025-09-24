CREATE TABLE
  `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `full_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(15) NULL,
    `password` VARCHAR(255) NOT NULL,
    `address` TEXT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_email` (`email`),
    UNIQUE KEY `uq_phone_number` (`phone_number`)
  );

CREATE TABLE
  `categories` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `category_name` VARCHAR(255) NOT NULL,
    `image_url` VARCHAR(255),
    UNIQUE KEY `uq_category_name` (`category_name`),
  );

CREATE TABLE
  `products` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `image_url` VARCHAR(255),
    `stock_quantity` INT NOT NULL DEFAULT 0,
    `category_id` INT,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
    INDEX `idx_product_name` (`product_name`)
  );

CREATE TABLE
  `orders` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT,
    `total_amount` DECIMAL(12, 2) NOT NULL,
    `status` ENUM ('pending', 'shipping', 'completed', 'cancelled') DEFAULT 'pending',
    `shipping_address` TEXT NOT NULL,
    `shipping_phone` VARCHAR(15) NOT NULL,
    `note` TEXT,
    `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    INDEX `idx_user_id` (`user_id`)
  );

CREATE TABLE
  `order_details` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `order_id` INT,
    `product_id` INT,
    `quantity` INT NOT NULL,
    `price_at_purchase` DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
  );

CREATE TABLE
  `reviews` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `product_id` INT,
    `user_id` INT,
    `rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
    `comment` TEXT,
    `review_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
  );