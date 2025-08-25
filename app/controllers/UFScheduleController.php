<?php

class UFScheduleController extends Controller
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

    /** User view: list + filters only */
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

        // Use a trimmed-down view for users
        require __DIR__ . '/../views/user/flightschedules/index.php';
    }
}
