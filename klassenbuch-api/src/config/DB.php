<?php
    class DB {
    
        private $dbuser = ''; 
        private $dbpass = ''; 
        private $connect_string = 'mysql:host=;dbname=;charset=utf8';

        public function connect() {
            $connection = new PDO($this->connect_string, $this->dbuser, $this->dbpass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        }

        public static function create_insert_query($table, $json) {
            $query = 'INSERT INTO ' . $table . ' ';
            $field_list = '';
            $value_list = '';

            // Felder in json suchen, uuid und created_at, updated_at ignorieren
            $delim = '(';
            foreach ($json as $key => $val) {
                if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

                } else {
                    $field_list .= $delim;
                    $field_list .= $key;
                    $value_list .= $delim;
                    $value_list .= ':';
                    $value_list .= $key;
                    $delim = ', ';
                }
            }
            // created_at und created_by ergänzen
            $field_list .= $delim;
            $field_list .= 'created_at';
            $value_list .= $delim;
            $value_list .= "'" . date("Y-m-d H:i:s") ."'";

            $field_list .= $delim;
            $field_list .= 'created_by';
            $value_list .= $delim;
            $value_list .= "'" . $_SESSION['user_iserv'] . "'";

            // Teile zusammensetzen
            $query .= $field_list;
            $query .= ') VALUES ';
            $query .= $value_list;
            $query .= ')';

            return $query;
        }

        public static function create_update_query($table, $json) {
            $query = 'UPDATE ' . $table . ' SET ';
            $field_list = '';

            // Felder in json suchen, uuid und created_at, updated_at ignorieren
            $delim = '';
            foreach ($json as $key => $val) {
                if ($key === 'id' or $key === 'created_at' or $key === 'updated_at' or $key === 'created_by' or $key === 'updated_by') {

                } else {
                    $field_list .= $delim;
                    $field_list .= $key;
                    $field_list .= ' = ';
                    $field_list .= ':';
                    $field_list .= $key;
                    $delim = ', ';
                }
            }
            // updated_at und updated_by ergänzen
            $field_list .= $delim;
            $field_list .= "updated_at = '" . date("Y-m-d H:i:s") . "'";
            $field_list .= $delim;
            $field_list .= "updated_by = '" . $_SESSION['user_iserv'] . "'";
            
            // UPDATE-TIMESTAMP wird durch die Datenbank geaendert
            // $field_list .= $delim;
            // $field_list .= 'updated_at = CURRENT_TIMESTAMP';

            $query .= $field_list;
            $query .= ' WHERE id = :id';

            return $query;
        }
    }