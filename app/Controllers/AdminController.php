<?php
require_once '../models/Tanggungan.php';
require_once '../models/Surat.php';

class AdminController {
    public function setLunasTanggungan($tanggungan) {
        $tanggungan->setLunas();
    }

    public function setujuiSurat($surat) {
        $surat->setujuiSurat();
    }
}
?>
