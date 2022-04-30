<?php

include_once 'DatabaseManager.php';

class CommentRepository
{
    public function get_article_comments($article_id)
    {
        $sql = 'SELECT * FROM comment WHERE comment.article_id = :id';

        $params = [
            ':id' => $article_id
        ];

        return DatabaseManager::get_instance()->select($sql, $params);
    }

    public function add_comment($article_id, $username, $content, $date_added)
    {
        $sql = 'INSERT INTO comment SET article_id = :id, username = :username, content = :content, date_added = :date_added';

        $params = [
            ':id' => $article_id,
            ':username' => $username,
            ':content' => $content,
            'date_added' => $date_added
        ];

        return DatabaseManager::get_instance()->insert($sql, $params);
    }

    public function delete_comment($comment_id)
    {
        $sql = 'DELETE FROM comment where id = :id';

        $params = [
            ':id' => $comment_id
        ];

        return DatabaseManager::get_instance()->delete($sql, $params);
    }
}