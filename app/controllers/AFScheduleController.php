<?php

class AFScheduleController extends Controller
{
    private $flightScheduleModel;
    private $flightRouteModel;
    private $airlineUserModel;
    private $airlineModel;
    private $airportModel;
    private $aircraftModel;

    public function __construct()
    {
        global $db;
        $this->flightScheduleModel = new FlightSchedule($db);
        $this->flightRouteModel = new FlightRoute($db);
        $this->airlineUserModel = new AirlineUser($db);
        $this->airlineModel = new Airline($db);
        $this->airportModel = new Airport($db);
        $this->aircraftModel = new Aircraft($db);
    }

    /** Show all schedules (no airline restriction, view all) */
    public function index()
    {
        $filters = [];

        $searchParams = [
            'id' => 'id',
            'schedule_user' => 'schedule_user',
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

        $schedules = $this->flightScheduleModel->all($filters, $limit, $offset) ?: [];
        $total = $this->flightScheduleModel->count($filters);
        $pages = ceil($total / $limit);

        $flightRoutes = $this->flightRouteModel->all() ?: [];
        $airlineUsers = $this->airlineUserModel->all() ?: [];
        $airlines = $this->airlineModel->all() ?: [];
        $airports = $this->airportModel->all() ?: [];
        $aircrafts = $this->aircraftModel->all() ?: [];

        require __DIR__ . '/../views/airline/flightschedules/index.php';
    }

    /** Store new schedule (restricted to logged-in airline’s routes) */
    public function store()
    {
        $aid = $_SESSION['aid'] ?? null;

        $route = $this->flightRouteModel->find($_POST['frid']);
        if (!$route || $route['aid'] != $aid) {
            die("Unauthorized action: Route does not belong to your airline.");
        }

        $data = [
            'auid' => $_SESSION['user_id'] ?? null, // standardized
            'frid' => $_POST['frid'] ?? null,
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled'
        ];

        $this->flightScheduleModel->create($data);
        Flash::set('success', 'Flight schedule created successfully!');
        header("Location: /airline/flight-schedules");
        exit;
    }

    /** Update schedule (only if belongs to logged-in airline’s route) */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule) die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action: Cannot edit another airline’s schedule.");
        }

        $data = [
            'frid' => $_POST['frid'] ?? $schedule['frid'],
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled'
        ];

        $this->flightScheduleModel->update($id, $data);
        Flash::set('success', 'Flight schedule updated successfully!');
        header("Location: /airline/flight-schedules");
        exit;
    }

    /** Delete schedule (only if belongs to logged-in airline’s route) */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule) die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action: Cannot delete another airline’s schedule.");
        }

        $this->flightScheduleModel->delete($id);
        Flash::set('success', 'Flight schedule deleted successfully!');
        header("Location: /airline/flight-schedules");
        exit;
    }
}
