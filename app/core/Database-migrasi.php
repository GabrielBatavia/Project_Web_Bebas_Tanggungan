<?php
require_once __DIR__ . '/../config/Database.php';

class Database {
    private $conn; // Koneksi database
    private $stmt;

    public function __construct() {
        // Menggunakan konfigurasi dari file config
        global $servername, $uid, $password, $database;

        // Koneksi ke database T-SQL
        $connection = [
            "Database" => $database,
            "UID" => $uid,
            "PWD" => $password,
            "Encrypt" => "Optional", // Enkripsi opsional
            "TrustServerCertificate" => true // Jika sertifikat tidak tepercaya
        ];

        // Menghubungkan ke database
        $this->conn = sqlsrv_connect($servername, $connection);

        if (!$this->conn) {
            die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika gagal
        }
    }

    // Query ke database
    public function query($sql) {
        $this->stmt = sqlsrv_query($this->conn, $sql);
        if (!$this->stmt) {
            die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
        }
    }

    // Bind parameter ke query (tidak langsung seperti PDO)
    public function bind($param, $value) {
        // T-SQL tidak memerlukan bind parameter seperti PDO, jadi tidak perlu implementasi ini
        // Untuk kasus seperti query yang lebih kompleks, kamu bisa memodifikasi query langsung
    }

    // Eksekusi query
    public function execute() {
        // Tidak perlu eksekusi khusus untuk sqlsrv_query karena query langsung dieksekusi
        return $this->stmt;
    }

    // Ambil semua hasil query
    public function resultSet() {
        $results = [];
        while ($row = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }

    // Ambil satu hasil dari query
    public function single() {
        return sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC);
    }

    // Tutup koneksi setelah penggunaan (optional)
    public function close() {
        sqlsrv_close($this->conn);
    }
}
?>
