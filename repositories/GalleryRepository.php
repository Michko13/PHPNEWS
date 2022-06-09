<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/services/DatabaseService.php';

class GalleryRepository
{
    public function add_image($title, $location)
    {
        $sql = 'INSERT INTO image SET title = :title, location = :location';

        $params = [
            ':title' => $title,
            ':location' => $location,
        ];

        return DatabaseService::get_instance()->insert($sql, $params);
    }

    public function get_all_images()
    {
        $sql = 'SELECT * FROM image';

        return DatabaseService::get_instance()->select($sql);
    }

    public function get_one_page_of_gallery($page)
    {
        $sql = 'SELECT * FROM image LIMIT 16 OFFSET ' . max($page * 16 - 16, 0);

        return DatabaseService::get_instance()->select($sql);
    }

    public function get_amount_of_pages_in_gallery()
    {
        $sql = 'SELECT Count(*) as count FROM image';

        $count = DatabaseService::get_instance()->selectOne($sql)['count'];
        $amountOfPages = (int)floor($count / 16) ;
        if($count % 16 != 0) {
            $amountOfPages++;
        }

        return $amountOfPages;
    }
}