<?php
// app/core/Database.php

require_once __DIR__ . '/../config/Database.php';

class Database {
    public $dbh; // Properti PDO yang dapat diakses secara publik
    private $stmt;

    public function __construct() {
        global $servername, $uid, $password, $database;

        try {
            // Membuat DSN untuk SQL Server
            $dsn = "sqlsrv:Server=$servername;Database=$database";
            
            // Opsi PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mengaktifkan exception untuk error handling
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch mode asosiatif
            ];

            // Membuat instance PDO
            $this->dbh = new PDO($dsn, $uid, $password, $options);
            // echo 'Koneksi berhasil<br>'; // Opsional: bisa dihapus atau dikomentari setelah koneksi berhasil
        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    /**
     * Menyiapkan query SQL
     *
     * @param string $sql Query SQL dengan placeholder
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Mengikat parameter ke query
     *
     * @param string $param Nama parameter (misalnya: :nim)
     * @param mixed $value Nilai yang akan diikat
     * @param int|null $type Tipe data PDO
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Menjalankan query
     *
     * @return bool Status eksekusi
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Mengambil semua hasil query
     *
     * @return array Hasil query sebagai array asosiatif
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Mengambil satu hasil dari query
     *
     * @return array|null Hasil query sebagai array asosiatif atau null jika tidak ada
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Menghitung jumlah baris yang terpengaruh
     *
     * @return int Jumlah baris
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}
?>
