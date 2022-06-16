<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/services/DatabaseService.php';

class AuthorRepository
{
    public function does_author_exist($author_id)
    {
        $sql = 'SELECT null FROM author
                WHERE id = :id';

        $params = [
            ':id' => $author_id
        ];

        return DatabaseService::get_instance()->exists($sql, $params);
    }

    public function get_all_authors()
    {
        $sql = 'SELECT author.*, COUNT(article.id) AS article_count,
                image.location AS profile_image,
                image.id AS profile_image_id
                FROM author
                LEFT JOIN article ON article.author_id = author.id
                INNER JOIN image ON image.id = author.image_id
                GROUP BY author.id';

        return DatabaseService::get_instance()->select($sql);
    }

    public function get_author_name($id)
    {
        $sql = 'SELECT firstname, lastname FROM author WHERE id = :id';

        $params = [
            ':id' => $id
        ];

        return DatabaseService::get_instance()->selectOne($sql, $params);
    }

    public function add_author($username, $password, $firstname, $lastname, $bio, $image_id)
    {
        $sql = 'INSERT INTO author 
                SET username = :username, password = :password, firstname = :firstname,
                lastname = :lastname, bio = :bio, image_id = :image_id, is_admin = :is_admin';

        $params = [
            ':username' => $username,
            ':password' => $password,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':bio' => $bio,
            ':image_id' => $image_id,
            ':is_admin' => '0'
        ];

        return DatabaseService::get_instance()->insert($sql, $params);
    }

    public function edit_author($id, $username, $password, $firstname, $lastname, $bio, $image_id)
    {
        $sql = 'UPDATE author 
                SET username = :username, firstname = :firstname,
                lastname = :lastname, bio = :bio, image_id = :image_id';

        if($password != null) {
            $sql = $sql . ', password = :password';
        }

        $sql = $sql . ' WHERE id = :id';

        $params = [
            ':id' => $id,
            ':username' => $username,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':bio' => $bio,
            ':image_id' => $image_id,
        ];

        if($password != null) {
            $params += [':password' => $password];
        }

        return DatabaseService::get_instance()->insert($sql, $params);
    }
}