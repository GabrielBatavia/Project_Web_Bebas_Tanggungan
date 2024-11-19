<?php
class Tanggungan {
    public $jenis;
    public $deskripsi;
    public $statusLunas;

    public function __construct($jenis, $deskripsi) {
        $this->jenis = $jenis;
        $this->deskripsi = $deskripsi;
        $this->statusLunas = false;
    }

    public function setLunas() {
        $this->statusLunas = true;
    }

    public function isLunas() {
        return $this->statusLunas;
    }
}
?>
