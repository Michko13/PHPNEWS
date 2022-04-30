<?php

include_once 'DatabaseManager.php';

class CategoryRepository
{
    public function does_category_exist($category_id)
    {
        $sql = 'SELECT null FROM category WHERE id = :id';

        $params = [
            ':id' => $category_id
        ];

        return DatabaseManager::get_instance()->exists($sql, $params);
    }

    public function get_all_categories()
    {
        $sql = 'SELECT * FROM category';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function get_category_name($category_id)
    {
        $sql = 'SELECT name FROM category WHERE id = :id';

        $params = [
            ':id' => $category_id
        ];

        return DatabaseManager::get_instance()->selectOne($sql, $params)['name'];
    }

    public function get_all_categories_name()
    {
        $sql = 'SELECT id, name FROM category';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function get_categories_for_administration()
    {
        $sql = 'SELECT category.*, COUNT(article.id) AS article_count FROM category
                LEFT JOIN article on article.category_id = category.id
                GROUP BY category.id';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function add_category($name, $description)
    {
        $sql = 'INSERT INTO category SET name = :name, description = :description';

        $params = [
            ':name' => $name,
            ':description' => $description,
        ];

        return DatabaseManager::get_instance()->insert($sql, $params);
    }

    public function delete_category($category_id)
    {
        $sql = 'DELETE FROM category WHERE id = :id';

        $params = [
            ':id' => $category_id
        ];

        return DatabaseManager::get_instance()->delete($sql, $params);
    }

    public function get_article_count_by_category($category_id)
    {
        $sql = 'SELECT COUNT(article.id) AS article_count FROM article WHERE article.category_id = :id';

        $params = [
            ':id' => $category_id
        ];

        return DatabaseManager::get_instance()->selectOne($sql, $params);
    }

    public function edit_category($category_id, $name, $description)
    {
        $sql = 'UPDATE category SET name = :name, description = :description WHERE id = :id';

        $params = [
            ':id' => $category_id,
            ':name' => $name,
            ':description' => $description
        ];

        return DatabaseManager::get_instance()->update($sql, $params);
    }
}