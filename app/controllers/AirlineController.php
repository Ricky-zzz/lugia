<?php
class AirlineController
{
    private $airlineModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->airlineModel = new Airline($db);
    }

    /** List airlines with filters + pagination */
    public function index()
    {
        $filters = [
            'iata' => $_GET['iata'] ?? null,
            'icao' => $_GET['icao'] ?? null,
            'airline_name' => $_GET['airline_name'] ?? null,
            'callsign' => $_GET['callsign'] ?? null,
            'region' => $_GET['region'] ?? null,
        ];

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $airlines = $this->airlineModel->all($filters, $perPage, $offset);
        $total = $this->airlineModel->count($filters);
        $pages = ceil($total / $perPage);

        require __DIR__ . '/../views/admin/airlines/index.php';
    }

    /** Handle form submit for new airline */
    public function store()
    {
        $data = [
            'iata' => $_POST['iata'] ?? null,
            'icao' => $_POST['icao'] ?? null,
            'airline_name' => $_POST['airline_name'] ?? null,
            'callsign' => $_POST['callsign'] ?? null,
            'region' => $_POST['region'] ?? null,
            'comments' => $_POST['comments'] ?? null,
        ];

        $this->airlineModel->create($data);
        Flash::set('success', 'Airline created successfully!');
        header("Location: /admin/airlines");
        exit;
    }

    /** Handle update */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $data = [
            'iata' => $_POST['iata'] ?? null,
            'icao' => $_POST['icao'] ?? null,
            'airline_name' => $_POST['airline_name'] ?? null,
            'callsign' => $_POST['callsign'] ?? null,
            'region' => $_POST['region'] ?? null,
            'comments' => $_POST['comments'] ?? null,
        ];

        $this->airlineModel->update($id, $data);
        Flash::set('success', 'Airline updated successfully!');
        header("Location: /admin/airlines");
        exit;
    }


    /** Delete airline */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $this->airlineModel->delete($id);
        Flash::set('success', 'Airline deleted successfully!');
        header("Location: /admin/airlines");
        exit;
    }
}
