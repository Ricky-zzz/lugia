<?php

class UserFlightRouteController extends Controller
{
    private $flightRouteModel;
    private $airlineModel;
    private $airportModel;
    private $aircraftModel;

    public function __construct()
    {
        global $db;
        $this->flightRouteModel = new FlightRoute($db);
        $this->airlineModel = new Airline($db);
        $this->airportModel = new Airport($db);
        $this->aircraftModel = new Aircraft($db);
    }

    /** List all flight routes with filters + pagination */
    public function index()
    {
        $filters = [
            'id' => $_GET['id'] ?? '',
            'aid' => $_GET['aid'] ?? '',
            'oapid' => $_GET['oapid'] ?? '',
            'dapid' => $_GET['dapid'] ?? '',
            'acid' => $_GET['acid'] ?? '',
            'round_trip' => $_GET['round_trip'] ?? ''
        ];

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $routes = $this->flightRouteModel->all($filters, $limit, $offset);
        $total = $this->flightRouteModel->count($filters);
        $pages = ceil($total / $limit);

        // For dropdowns or display names
        $airlines = $this->airlineModel->all();
        $airports = $this->airportModel->all();
        $aircrafts = $this->aircraftModel->all();

        require __DIR__ . '/../views/user/flightroutes/index.php';
    }
}
