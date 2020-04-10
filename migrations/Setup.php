<?php
namespace migrations;

class Setup
{
    protected $db;
    public function __construct()
    {
        $this->db = new \engine\DbOperations;
    }

    public function index()
    {
        $this->users();
        $this->posts();
        $this->comments();
        $this->categories();
        $this->pages();
        $this->controllers();
    }

    private function users()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'email' => 'VARCHAR(50) NOT NULL UNIQUE KEY',
            'username' => 'VARCHAR(30) NOT NULL',
            'password' => 'VARCHAR(128) NOT NULL',
            'role' => 'VARCHAR(15) NOT NULL',
            'reg_date' => 'TIMESTAMP',
            'active' => 'INT(11) NOT NULL DEFAULT 0'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }

    private function posts()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'category' => 'INT(11) NOT NULL',
            'title' => 'VARCHAR(90) NOT NULL',
            'author' => 'VARCHAR(64) NOT NULL',
            'date' => 'DATE',
            'banner' => 'VARCHAR(60)',
            'content' => 'TEXT',
            'tags' => 'VARCHAR(255)',
            'comments' => 'INT(11) NOT NULL',
            'likes' => 'INT(11) NOT NULL',
            'status' => 'INT(1) NOT NULL'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }

    private function comments()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'author' => 'VARCHAR(64) NOT NULL',
            'date' => 'DATE',
            'content' => 'TEXT',
            'likes' => 'INT(11) NOT NULL',
            'status' => 'INT(1) NOT NULL'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }

    private function categories()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(64) NOT NULL UNIQUE KEY'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }

    private function pages()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(64) NOT NULL',
            'short_content' => 'VARCHAR(512) NULL',
            'content' => 'TEXT NULL',
            'method' => 'INT(11) NOT NULL',
            'active' => 'INT(1) NOT NULL DEFAULT 1',
            'header' => 'INT(1) NOT NULL DEFAULT 0',
            'menu' => 'INT(1) NOT NULL DEFAULT 0',
            'footer' => 'INT(1) NOT NULL DEFAULT 0'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }

    private function controllers()
    {
        $fields = array(
            'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(64) NOT NULL UNIQUE KEY'
        );
        $this->db->createTable(__FUNCTION__, $fields);
    }
}
