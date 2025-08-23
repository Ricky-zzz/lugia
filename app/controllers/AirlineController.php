<?php
class AirlineController {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

public function index() {
    $filters = [
        'iata'         => $_GET['iata'] ?? null,
        'icao'         => $_GET['icao'] ?? null,
        'airline_name' => $_GET['airline_name'] ?? null,
        'callsign'     => $_GET['callsign'] ?? null,
        'region'       => $_GET['region'] ?? null,
    ];

    $airlineModel = new Airline($this->db);
    $airlines = $airlineModel->all($filters);

    require __DIR__ . '/../views/admin/airlines/index.php';
}

}
