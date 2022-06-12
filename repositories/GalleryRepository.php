<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/services/DatabaseService.php';

class GalleryRepository
{
    public function save_image_to_disk($file, $title)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $randomName = bin2hex(random_bytes(8)) . ".jpg";

        if($extension == 'png') {
            $image = imagecreatefrompng($file['tmp_name']);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagealphablending($bg, TRUE);
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            imagedestroy($image);
            $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file
            imagejpeg($bg, $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/uploads/' . $randomName, $quality);
            imagedestroy($bg);
        } else {
            move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/PHPNEWS/uploads/' . $randomName);
        }

        return $this->add_image($title, 'uploads/' . $randomName);
    }

    public function add_image($title, $location)
    {
        $sql = 'INSERT INTO image 
                SET title = :title, location = :location';

        $params = [
            ':title' => $title,
            ':location' => $location,
        ];

        return DatabaseService::get_instance()->insert($sql, $params);
    }

    public function get_one_page_of_gallery($page)
    {
        $sql = 'SELECT * FROM image 
                LIMIT 16 OFFSET ' . max($page * 16 - 16, 0);

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

    public function delete_image($image_id)
    {
        $sql = 'SELECT location FROM image
                WHERE id = :id';

        $params = [
            ':id' => $image_id
        ];

        unlink(DatabaseService::get_instance()->selectOne($sql, $params)['location']);

        $sql = 'DELETE FROM image
                WHERE id = :id';

        return DatabaseService::get_instance()->delete($sql, $params);
    }

    public function image_article_usages($image_id)
    {
        $sql = 'SELECT id FROM article 
                WHERE title_image_id = :id';

        $params = [
            ':id' => $image_id
        ];

        return DatabaseService::get_instance()->select($sql, $params);
    }

    public function image_author_usages($image_id)
    {
        $sql = 'SELECT id FROM author 
                WHERE image_id = :id';

        $params = [
            ':id' => $image_id
        ];

        return DatabaseService::get_instance()->select($sql, $params);
    }
}