<?php
class Surat {
    public $nomorSurat;
    public $jenisSurat;
    public $tanggalPembuatan;
    public $statusDisetujui;

    public function __construct($nomorSurat, $jenisSurat, $tanggalPembuatan) {
        $this->nomorSurat = $nomorSurat;
        $this->jenisSurat = $jenisSurat;
        $this->tanggalPembuatan = $tanggalPembuatan;
        $this->statusDisetujui = false;
    }

    public function setujuiSurat() {
        $this->statusDisetujui = true;
    }

    public function isDisetujui() {
        return $this->statusDisetujui;
    }
}
?>
