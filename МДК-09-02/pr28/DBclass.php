<?php
class DBclass {
    private string $server;
    private string $user;
    private string $pass;
    private string $dbname;
    private ?mysqli $db = null;

    public function __construct(string $server, string $user, string $pass, string $dbname) {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->openConnection();
    }

    public function openConnection(): bool {
        if ($this->db == null) {
            $this->db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($this->db->connect_error) {
                error_log("Ошибка подключения к базе данных: " . $this->db->connect_error);
                return false;
            }
            if (!$this->db->set_charset("utf8")) {
                error_log("Ошибка установки кодировки UTF8: " . $this->db->error);
                return false;
            }
            return true;
        } else {
            return true;
        }
    }

    public function query(string $sql): mysqli_result|bool {
        if ($this->db == null) {
            error_log("Соединение с базой данных не установлено.");
            return false;
        }

        $result = $this->db->query($sql); 

        if ($result == false) {
            error_log("Ошибка выполнения запроса: " . $this->db->error . " (SQL: " . $sql . ") ");
            return false;
        }
        return $result;
    }

    public function getLastError(): ?string {
        return $this->db ? $this->db->error : null;
    }

    public function escapeString(string $string): string {
        if ($this->db == null) {
            error_log("Соединение с базой данных не установлено");
            return $string;
        }
        return $this->db->real_escape_string($string);
    }

    public function closeConnection(): void {
        if ($this->db !== null) {
            $this->db->close();
            $this->db = null; 
        }
    }

    public function __destruct() {
        $this->closeConnection();
    }

    public function getLastInsertId(): ?int {
        return $this->db ? $this->db->insert_id : null;
    }

    public function getAffectedRows(): ?int {
        return $this->db ? $this->db->affected_rows : null;
    }
}
?>