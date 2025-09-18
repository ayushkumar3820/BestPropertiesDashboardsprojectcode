<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbsetup extends CI_Controller {

    public function create_chat_table()
    {
        $this->load->database();

        $query = "
        CREATE TABLE IF NOT EXISTS `chat` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `property_id` INT(11) NOT NULL,
          `user_id` INT(11) NOT NULL,
          `message` TEXT NOT NULL,
          `status` TINYINT(1) NOT NULL DEFAULT 0,
          `r_date` DATETIME NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        if ($this->db->query($query)) {
            echo "Chat table created successfully!";
        } else {
            echo " Error creating chat table!";
        }
    }
}