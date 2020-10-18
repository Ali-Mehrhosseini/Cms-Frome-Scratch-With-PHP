<?php

namespace DataBase;
require_once(realpath(dirname(__FILE__) . "/DataBase.php"));


class CreateDB extends DataBase
{
private $createTableQueries = array(
        "CREATE TABLE `categories` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(200) COLLATE utf8_persian_ci NOT NULL, 
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`)
        )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `users` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `username` VARCHAR(150) COLLATE utf8_persian_ci NOT NULL ,
            `email` VARCHAR(200) COLLATE utf8_persian_ci NOT NULL ,
            `password` VARCHAR(200) COLLATE utf8_persian_ci NOT NULL ,
            `permission` ENUM('user','admin') COLLATE utf8_persian_ci NOT NULL  DEFAULT 'user',
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY  `email` (`email`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `articles` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `title` VARCHAR(255) NOT NULL,
            `summary` TEXT COLLATE utf8_persian_ci NOT NULL,
            `body` TEXT COLLATE utf8_persian_ci NOT NULL,
            `view`  INT(11) NOT NULL DEFAULT '0',
            `user_id` INT(11) NOT NULL,
            `cat_id` INT(11) NOT NULL,
            `image` VARCHAR(200) NOT NULL COLLATE utf8_persian_ci,
            `status` enum('disable','enable') NOT NULL COLLATE utf8_persian_ci DEFAULT 'disable',
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `comments` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `user_id` INT(11) NOT NULL,
            `comments` TEXT NOT NULL COLLATE utf8_persian_ci,
            `article_id` INT(11) NOT NULL,
            `status` enum('disable','enable') COLLATE utf8_persian_ci NOT NULL DEFAULT 'disable',
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `websetting` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `title` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
            `description` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
            `keywords` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
            `logo` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
            `icon` TEXT COLLATE utf8_persian_ci DEFAULT NULL,
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",

        "CREATE TABLE `menus` (
            `id` INT(11) NOT NULL AUTO_INCREMENT ,
            `name` VARCHAR(200) NOT NULL COLLATE utf8_persian_ci,
            `url` VARCHAR(300) NOT NULL COLLATE utf8_persian_ci,
            `parent_id` int(11) NOT NULL COLLATE utf8_persian_ci,
            `create_at` DATETIME NOT NULL,
            `updated_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;",


        );


private $tableInitializes = array(
    ['table'=>'users','fields'=>['username','email','password','permission'], 'values'=>['ali','ali.mehr1344@gmail.com',
    '123456789','admin']]
);  

public function run(){
    foreach($this->createTableQueries as $createTableQuerie){
        $this->createTable($createTableQuerie);
    }
    foreach($this->tableInitializes as $tableInitialize){
        $this->insert($tableInitialize["table"],$tableInitialize["fields"],$tableInitialize["values"]);
    }
}


}
