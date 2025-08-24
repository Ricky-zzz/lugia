<?php

class FlightScheduleController extends Controller
{
    private $flightScheduleModel;
    private $flightRouteModel;
    private $airlineUserModel;
    private $airlineModel;
    private $airportModel;
    private $aircraftModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->flightScheduleModel = new FlightSchedule($db);
        $this->flightRouteModel = new FlightRoute($db);
        $this->airlineUserModel = new AirlineUser($db);
        $this->airlineModel = new Airline($db);
        $this->airportModel = new Airport($db);
        $this->aircraftModel = new Aircraft($db);
    }

    /** List all flight schedules with filters + pagination */
    public function index()
    {
        // Build filters from GET
        $filters = [];

        // Exact or partial match filters
        $searchParams = [
            'id' => 'id',
            'schedule_user' => 'schedule_user', // partial match
            'frid' => 'frid',
            'status' => 'status',
            'date_departure_from' => 'date_departure_from',
            'date_departure_to' => 'date_departure_to',
            'date_arrival_from' => 'date_arrival_from',
            'date_arrival_to' => 'date_arrival_to'
        ];

        foreach ($searchParams as $key => $field) {
            if (!empty($_GET[$key])) {
                $filters[$field] = trim($_GET[$key]);
            }
        }

        // Pagination
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        // Fetch filtered schedules
        $schedules = $this->flightScheduleModel->all($filters, $limit, $offset) ?: [];

        // Total count for pagination
        $total = $this->flightScheduleModel->count($filters);
        $pages = ceil($total / $limit);

        // Dropdowns for filters / modals
        $flightRoutes = $this->flightRouteModel->all() ?: [];
        $airlineUsers = $this->airlineUserModel->all() ?: [];
        $airlines = $this->airlineModel->all() ?: [];
        $airports = $this->airportModel->all() ?: [];
        $aircrafts = $this->aircraftModel->all() ?: [];

        // Load view
        require __DIR__ . '/../views/admin/flightschedules/index.php';
    }
    /** Store new flight schedule */
    public function store()
    {
        $data = [
            'auid' => $_POST['auid'] ?? null,
            'frid' => $_POST['frid'] ?? null,
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled'
        ];

        $this->flightScheduleModel->create($data);
        Flash::set('success', 'Flight schedule created successfully!');
        header("Location: /admin/flight-schedules");
        exit;
    }

    /** Update flight schedule */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $data = [
            'auid' => $_POST['auid'] ?? null,
            'frid' => $_POST['frid'] ?? null,
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled'
        ];

        $this->flightScheduleModel->update($id, $data);
        Flash::set('success', 'Flight schedule updated successfully!');
        header("Location: /admin/flight-schedules");
        exit;
    }

    /** Delete flight schedule */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $this->flightScheduleModel->delete($id);
        Flash::set('success', 'Flight schedule deleted successfully!');
        header("Location: /admin/flight-schedules");
        exit;
    }
}
