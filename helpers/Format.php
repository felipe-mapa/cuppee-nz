<?php
    class Format{
            public function validation($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data; // here i return this $data variable so we can use this.
       }

       public function textShorten($text, $limit = 400){
            $text = $text. "";
            $text = substr($text, 0, $limit);
            $text = $text."..";
            return $text; 
        }
    }   

?>