<?php

 class Database
 {
     public $host;
     public $password;
     public $user;
     public $database;
     public $link;
     public $query;
     public $result;
     public $rows;

     public function Database()
     {
         include 'database_connect.php'; 
  
         $this->host = $hostname;     // ชื่อโฮสต์
         $this->password = $password;      // รหัสผ่าน
         $this->user = $user;          // ชื่อผู้ใช้
         $this->database = $dbname;      // ชื่อฐานข้อมูล
         $this->rows = 0;
     }

     public function OpenLink()
     {
         $this->link = @mysql_connect($this->host, $this->user, $this->password) or die(print 'Class Database: Error while connecting to DB (link)');
         @mysql_query("SET NAMES utf8");
         @mysql_query("SET charracter_set_results=utf8");
         @mysql_query("SET charracter_set_client=utf8");
         @mysql_query("SET charracter_set_connection=utf8");
         
     }

     public function SelectDB()
     {
         @mysql_select_db($this->database, $this->link) or die(print 'Class Database: Error while selecting DB');
     }

     public function CloseDB()
     {
         mysql_close();
     }

     public function Query($query)
     {
         $this->OpenLink();
         $this->SelectDB();
         $this->query = $query;

         $this->result = mysql_query($query, $this->link) or die(print 'Class Database: Error while executing Query');

        if (ereg('SELECT', $query)) {
            $this->rows = mysql_num_rows($this->result);
        }

         $this->CloseDB();
     }
 }
