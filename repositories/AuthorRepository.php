<?php

require_once 'DatabaseManager.php';

class AuthorRepository
{
    public function does_author_exist($author_id)
    {
        $sql = 'SELECT null FROM author WHERE id = :id';

        $params = [
            ':id' => $author_id
        ];

        return DatabaseManager::get_instance()->exists($sql, $params);
    }

    public function get_all_authors()
    {
        $sql = 'SELECT author.*, COUNT(article.id) as article_count
                FROM author LEFT JOIN article on article.author_id = author.id
                GROUP BY author.id';

        return DatabaseManager::get_instance()->select($sql);
    }

    public function get_author_name($id)
    {
        $sql = 'SELECT name, surname FROM author WHERE id = :id';

        $params = [
            ':id' => $id
        ];

        return DatabaseManager::get_instance()->selectOne($sql, $params);
    }

    public function add_author($username, $password, $name, $surname, $bio, $picture)
    {
        $sql = 'INSERT INTO author SET username = :username, password = :password, 
                       name = :name, surname = :surname, bio = :bio, picture = :picture, is_admin = :is_admin';

        $params = [
            ':username' => $username,
            ':password' => $password,
            ':name' => $name,
            ':surname' => $surname,
            ':bio' => $bio,
            ':picture' => $picture,
            ':is_admin' => '0'
        ];

        return DatabaseManager::get_instance()->insert($sql, $params);
    }

    public function edit_author($username, $name, $surname, $bio, $picture)
    {
        $sql = 'UPDATE author SET username = :username, name = :name, surname = :surname, bio = :bio, picture = :picture WHERE id = :id';

        $params = [
            'id' => $_SESSION['id'],
            ':username' => $username,
            ':name' => $name,
            ':surname' => $surname,
            ':bio' => $bio,
            ':picture' => $picture
        ];

        $result = DatabaseManager::get_instance()->update($sql, $params);

        if($result > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['surname'] = $surname;
            $_SESSION['bio'] = $bio;
            $_SESSION['picture'] = $picture;
        }

        return $result;
    }
}