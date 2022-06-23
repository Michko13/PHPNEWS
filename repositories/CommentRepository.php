<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/services/DatabaseService.php';

class CommentRepository
{
    public function get_article_comments($article_id)
    {
        $sql = 'SELECT * FROM comment 
                WHERE comment.article_id = :id';

        $params = [
            ':id' => $article_id
        ];

        return DatabaseService::get_instance()->select($sql, $params);
    }

    public function add_comment($article_id, $username, $content, $date_added)
    {
        $sql = 'INSERT INTO 
                comment SET article_id = :id, username = :username, content = :content, date_added = :date_added';

        $params = [
            ':id' => $article_id,
            ':username' => $username,
            ':content' => $content,
            'date_added' => $date_added
        ];

        return DatabaseService::get_instance()->insert($sql, $params);
    }

    public function delete_comment($comment_id)
    {
        $sql = 'DELETE FROM comment 
                WHERE id = :id';

        $params = [
            ':id' => $comment_id
        ];

        return DatabaseService::get_instance()->delete($sql, $params);
    }
}