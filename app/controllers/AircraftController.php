<?php
class AircraftController
{
    private $aircraftModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->aircraftModel = new Aircraft($db);
    }

    /** List aircraft with filters + pagination */
    public function index()
    {
        $filters = [
            'iata'  => $_GET['iata'] ?? null,
            'icao'  => $_GET['icao'] ?? null,
            'model' => $_GET['model'] ?? null,
        ];

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $aircrafts = $this->aircraftModel->all($filters, $perPage, $offset);
        $total = $this->aircraftModel->count($filters);
        $pages = ceil($total / $perPage);

        require __DIR__ . '/../views/admin/aircraft/index.php';
    }

    /** Handle form submit for new aircraft */
    public function store()
    {
        $data = [
            'iata'  => $_POST['iata'] ?? null,
            'icao'  => $_POST['icao'] ?? null,
            'model' => $_POST['model'] ?? null,
        ];

        $this->aircraftModel->create($data);
        Flash::set('success', 'Aircraft created successfully!');
        header("Location: /admin/aircraft");
        exit;
    }

    /** Handle update */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $data = [
            'iata'  => $_POST['iata'] ?? null,
            'icao'  => $_POST['icao'] ?? null,
            'model' => $_POST['model'] ?? null,
        ];

        $this->aircraftModel->update($id, $data);
        Flash::set('success', 'Aircraft updated successfully!');
        header("Location: /admin/aircraft");
        exit;
    }

    /** Delete aircraft */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $this->aircraftModel->delete($id);
        Flash::set('success', 'Aircraft deleted successfully!');
        header("Location: /admin/aircraft");
        exit;
    }
}
