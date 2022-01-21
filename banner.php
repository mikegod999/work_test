<?php
include 'config.php';

Class Banner {
    private $image_url;
    private $db;

    public function __construct($image_url){
        $this->image_url = $image_url;
        $this->db = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }

    private function sendUserInfoToDatabase(){
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $view_date = date('Y-m-d H:i:s');
        $page_url  = $_GET['page'];

        if(!empty($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = md5($_SERVER['HTTP_USER_AGENT']);
        } else {
            $user_agent = md5('unknown');
        }

        $check_user = $this->db->query("SELECT * FROM user_fields WHERE ip_address = '" . $ip_address .
            "' AND page_url = '" . $page_url .
            "' AND user_agent = '" . $user_agent . "'")->fetch_assoc();

        if(!$check_user){
            $this->db->query("INSERT INTO user_fields SET ip_address = '" . $ip_address .
                "', page_url = '" . $page_url .
                "', user_agent = '" . $user_agent .
                "', view_date = '" . $view_date .
                "', views_count = 1"
            );
        } else {
            $this->db->query("UPDATE user_fields SET views_count = views_count + 1, view_date = '". $view_date .
                "' WHERE ip_address = '" . $ip_address .
                "' AND page_url = '" . $page_url .
                "' AND user_agent = '" . $user_agent . "'"
            );
        }
    }

    public function readImageFile(){
        if (file_exists($this->image_url) && readfile($this->image_url)) {
            $this->sendUserInfoToDatabase();
            exit;
        }
    }
}

$banner = new Banner('family-2.jpg');
$banner->readImageFile();