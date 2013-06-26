<?php
    class MySQL
    {
        public $mysql;

        public $affected_rows;

        public function __construct($host, $user, $pass, $db)
        {
            $this->mysql = new MySQLi($host, $user, $pass, $db);
            if (! $this->mysql)
            {
                die('Verbindung zur Datenbank nicht möglich!<br /><br /><hr />Fehler: ' . $this->mysql->connect_error);
            }
            $this->mysql->query('SET CHARACTER SET \'utf8\'');
        }

        public function __destruct()
        {
            $this->mysql->close();
        }

        public function PushData($query, $types, array $params)
        {
            $command = $this->mysql->prepare($query)
                or die('Konnte MySQL-Befehl nicht ausführen!<br /><br /><hr />Fehler: ' . $this->mysql->error);

            array_unshift($params, $types);
            call_user_func_array(array($command, 'bind_param'), $params);

            $command->execute();
        }

        public function GetData($query, $types = NULL, array $params = NULL)
        {
            $command = $this->mysql->prepare($query)
                or die('Konnte MySQL-Befehl nicht ausführen!<br /><br /><hr />Fehler: ' . $this->mysql->error);
            if ($types && $params)
            {
                array_unshift($params, $types);
                call_user_func_array(array($command, "bind_param"), $params);
            }
            $command->execute();
            $this->affected_rows = $this->mysql->affected_rows;

            $meta = $command->result_metadata();
            while ($field = $meta->fetch_field())
            {
                $cufa_params[] = &$col[$field->name];
            }

            call_user_func_array(array($command, "bind_result"), $cufa_params);

            while ($command->fetch())
            {
                foreach($col as $index => $value)
                {
                    $row[$index] = $value;
                }
                $result[] = (object) $row;
            }
            if (isset($result))
            {
                $this->affected_rows = count($result);
                return $result;
            } 
            else
            {
                return null;
            }
        }

        public function CountTable($Table)
        {
            $Table = $this->mysql->real_escape_string($Table);
            $query = "SELECT * FROM `$Table`";
            $this->GetData($query);
            return $this->affected_rows;
        }
    }
?>