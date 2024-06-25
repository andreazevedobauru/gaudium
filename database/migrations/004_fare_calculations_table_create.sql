CREATE TABLE fare_calculations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date_time DATETIME NOT NULL,
    city_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    origin_address VARCHAR(200) NOT NULL,
    destination_address VARCHAR(200) NOT NULL,
    distance DECIMAL(10,2) NOT NULL,
    duration TIME NOT NULL,
    fare_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
