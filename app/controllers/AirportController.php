<?php
class AirportController
{
    private $airportModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->airportModel = new Airport($db);
    }

    /** List airports with filters + pagination */
    public function index()
    {
        $filters = [
            'iata'           => $_GET['iata'] ?? null,
            'icao'           => $_GET['icao'] ?? null,
            'airport_name'   => $_GET['airport_name'] ?? null,
            'location_serve' => $_GET['location_serve'] ?? null,
            'time'           => $_GET['time'] ?? null,
            'dst'            => $_GET['dst'] ?? null,
        ];

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $airports = $this->airportModel->all($filters, $perPage, $offset);
        $total = $this->airportModel->count($filters);
        $pages = ceil($total / $perPage);

        require __DIR__ . '/../views/admin/airports/index.php';
    }

    /** Handle form submit for new airport */
    public function store()
    {
        $data = [
            'iata'           => $_POST['iata'] ?? null,
            'icao'           => $_POST['icao'] ?? null,
            'airport_name'   => $_POST['airport_name'] ?? null,
            'location_serve' => $_POST['location_serve'] ?? null,
            'time'           => $_POST['time'] ?? null,
            'dst'            => $_POST['dst'] ?? null,
        ];

        $this->airportModel->create($data);
        Flash::set('success', 'Airport created successfully!');
        header("Location: /admin/airports");
        exit;
    }

    /** Handle update */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $data = [
            'iata'           => $_POST['iata'] ?? null,
            'icao'           => $_POST['icao'] ?? null,
            'airport_name'   => $_POST['airport_name'] ?? null,
            'location_serve' => $_POST['location_serve'] ?? null,
            'time'           => $_POST['time'] ?? null,
            'dst'            => $_POST['dst'] ?? null,
        ];

        $this->airportModel->update($id, $data);
        Flash::set('success', 'Airport updated successfully!');
        header("Location: /admin/airports");
        exit;
    }

    /** Delete airport */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $this->airportModel->delete($id);
        Flash::set('success', 'Airport deleted successfully!');
        header("Location: /admin/airports");
        exit;
    }
}
