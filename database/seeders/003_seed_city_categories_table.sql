-- São Paulo tem todas as categorias
INSERT INTO city_categories (city_id, category_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4);

-- Rio de Janeiro tem apenas categorias de luxo e executiva
INSERT INTO city_categories (city_id, category_id) VALUES
(2, 2), (2, 3);

-- Belo Horizonte tem uma categoria econômica
INSERT INTO city_categories (city_id, category_id) VALUES
(3, 1);

-- Porto Alegre não tem categorias associadas, então não inserimos nada para Porto Alegre

-- Categoria Compartilhada não está associada a Porto Alegre explicitamente
