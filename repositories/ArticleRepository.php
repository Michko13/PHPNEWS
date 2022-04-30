<?php

include_once 'DatabaseManager.php';

class ArticleRepository
{
    public function does_article_exist($article_id)
    {
        $sql = 'SELECT null FROM article WHERE id = :id';

        $params = [
            ':id' => $article_id
        ];

        return DatabaseManager::get_instance()->exists($sql, $params);
    }

    public function get_article_author($author_id)
    {
        $sql = 'SELECT author_id FROM article WHERE id = :id';

        $params = [
            ':id' => $author_id
        ];

        return DatabaseManager::get_instance()->selectOne($sql, $params)['author_id'];
    }

    public function get_articles_for_home_page()
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.title_image, article.perex, article.date_added,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, 
                category.id AS category_id, category.name AS category_name
                FROM article 
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                WHERE article.is_published = 1
                ORDER BY article.id DESC';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function get_article($article_id)
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.title_image, article.perex, article.content, article.date_added, article.is_published,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, author.picture as author_picture,
                category.id AS category_id, category.name AS category_name
                FROM article
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                WHERE article.id = :id';
        $params = [
            ':id' => $article_id
        ];

        return DatabaseManager::get_instance()->selectOne($sql, $params);
    }

    public function get_articles_by_category($category_id, $limit = null)
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.title_image, article.perex, article.date_added,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, 
                category.id AS category_id, category.name AS category_name
                FROM article 
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                WHERE category.id = :id
                ORDER BY article.date_added DESC';

        $params = [
            ':id' => $category_id,
        ];

        if (is_numeric($limit)) {
            $sql .= ' LIMIT ' . $limit;
        }

        return DatabaseManager::get_instance()->select($sql, $params);
    }

    public function get_articles_by_author($author_id)
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.title_image, article.perex, article.date_added,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, 
                category.id AS category_id, category.name AS category_name
                FROM article 
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                WHERE author.id = :id
                ORDER BY article.date_added DESC';

        $params = [
            ':id' => $author_id
        ];

        return DatabaseManager::get_instance()->select($sql, $params);
    }

    public function get_recommended_articles($category_id, $limit = null)
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.title_image, article.perex, article.date_added,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, 
                category.id AS category_id, category.name AS category_name
                FROM article 
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                ORDER BY category_id=:id DESC';

        $params = [
            ':id' => $category_id,
        ];

        if (is_numeric($limit)) {
            $sql .= ' LIMIT ' . $limit;
        }

        return DatabaseManager::get_instance()->select($sql, $params);
    }

    public function get_articles_for_administration()
    {
        $sql = 'SELECT article.id AS article_id, article.title, article.date_added, article.is_published,
                author.id AS author_id, author.name AS author_name, author.surname AS author_surname, 
                category.id AS category_id, category.name AS category_name
                FROM article 
                INNER JOIN author ON author.id = article.author_id
                INNER JOIN category ON category.id = article.category_id
                ORDER BY article.date_added DESC';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function delete_article($article_id)
    {
        $sql = 'SELECT title_image FROM article WHERE id = :id';

        $params = [
            ':id' => $article_id
        ];

        unlink(DatabaseManager::get_instance()->selectOne($sql, $params)['title_image']);

        $sql = 'DELETE FROM article WHERE id = :id';

        return DatabaseManager::get_instance()->delete($sql, $params);
    }

    public function add_article($title, $title_image, $perex, $author_id, $category_id, $content, $date_added, $is_published)
    {
        $sql = 'INSERT INTO article VALUES (default, :title, :title_image, :perex, :author_id , :category_id, :content, :date_added, :is_published)';

        $params = [
            ':title' => $title,
            ':title_image' => $title_image,
            ':perex' => $perex,
            ':author_id' => $author_id,
            ':category_id' => $category_id,
            ':content' => $content,
            ':date_added' => $date_added,
            ':is_published' => $is_published
        ];

        return DatabaseManager::get_instance()->insert($sql, $params);
    }

    public function edit_article($id, $title, $title_image, $perex, $category_id, $content, $is_published)
    {
        $sql = 'UPDATE article SET title = :title, title_image = :title_image, perex = :perex, 
                   category_id = :category_id, content = :content, is_published = :is_published
                WHERE id = :id';

        $params = [
            ':id' => $id,
            ':title' => $title,
            ':title_image' => $title_image,
            ':perex' => $perex,
            ':category_id' => $category_id,
            ':content' => $content,
            ':is_published' => $is_published
        ];

        return DatabaseManager::get_instance()->update($sql, $params);
    }
}