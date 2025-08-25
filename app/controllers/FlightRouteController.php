<?php

class FlightRouteController extends Controller
{
    private $flightRouteModel;
    private $airlineModel;
    private $airportModel;
    private $aircraftModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->flightRouteModel = new FlightRoute($db);
        $this->airlineModel = new Airline($db);
        $this->airportModel = new Airport($db);
        $this->aircraftModel = new Aircraft($db);
    }

    /** List all flight routes with filters + pagination */
    public function index()
    {
        $filters = [
            'id' => $_GET['id'] ?? '',   // ✅ added this
            'aid' => $_GET['aid'] ?? '',
            'oapid' => $_GET['oapid'] ?? '',
            'dapid' => $_GET['dapid'] ?? '',
            'acid' => $_GET['acid'] ?? '',
            'round_trip' => $_GET['round_trip'] ?? ''
        ];


        // Get all routes without pagination first
        $routes = $this->flightRouteModel->all($filters);

        // Debug output
        echo "<!-- Debug: Number of routes found: " . count($routes) . " -->\n";
        echo "<!-- Debug: SQL Query: " . $this->flightRouteModel->getLastQuery() . " -->\n";

        $total = $this->flightRouteModel->count($filters);
        echo "<!-- Debug: Total count: " . $total . " -->\n";

        // dropdown data
        $airlines = $this->airlineModel->all();
        $airports = $this->airportModel->all();
        $aircrafts = $this->aircraftModel->all();

        require __DIR__ . '/../views/admin/flightroutes/index.php';
    }

    /** Store new flight route */
    public function store()
    {
        // In FlightRouteController::store
        $data = [
            'aid' => $_POST['aid'] ?? null,
            'oapid' => $_POST['oapid'] ?? null,
            'dapid' => $_POST['dapid'] ?? null,
            'round_trip' => isset($_POST['round_trip']) ? (int) $_POST['round_trip'] : 0,
            'acid' => $_POST['acid'] ?? null,
        ];


        $this->flightRouteModel->create($data);
        Flash::set('success', 'Flight route created successfully!');
        header("Location: /admin/flight-routes");
        exit;
    }

    /** Update flight route */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $data = [
            'aid' => $_POST['aid'] ?? null,
            'oapid' => $_POST['oapid'] ?? null,
            'dapid' => $_POST['dapid'] ?? null,
            'round_trip' => isset($_POST['round_trip']) ? (int)$_POST['round_trip'] : 0,
            'acid' => $_POST['acid'] ?? null,
        ];

        $this->flightRouteModel->update($id, $data);
        Flash::set('success', 'Flight route updated successfully!');
        header("Location: /admin/flight-routes");
        exit;
    }

    /** Delete flight route */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $this->flightRouteModel->delete($id);
        Flash::set('success', 'Flight route deleted successfully!');
        header("Location: /admin/flight-routes");
        exit;
    }
}
