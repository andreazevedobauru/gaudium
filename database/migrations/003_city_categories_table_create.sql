CREATE TABLE city_categories (
    city_id INT UNSIGNED,
    category_id INT UNSIGNED,
    PRIMARY KEY (city_id, category_id),
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
