<?php
require_once "../app/core/Controller.php";
require_once "../app/models/Tanggungan.php";

class DashboardController extends Controller {
    private $tanggungan;

    public function __construct($db) {
        $this->tanggungan = new Tanggungan($db);
    }

    public function index() {
        $result = $this->tanggungan->getAllTanggungan();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $this->view("dashboard/index", ['tanggungan' => $data]);
    }
}
?>
