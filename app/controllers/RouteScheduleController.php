<?php
require_once __DIR__ . '/../models/SeatService.php';

class RouteScheduleController extends Controller
{
    private $pdo;                  // ✅ Add this
    private $flightScheduleModel;
    private $flightRouteModel;
    private $seatService;

    public function __construct()
    {
        global $db;
        $this->pdo = $db;           
        $this->flightScheduleModel = new FlightSchedule($this->pdo);
        $this->flightRouteModel = new FlightRoute($this->pdo);
        $this->seatService = new SeatService($this->pdo);
    }



    /** List schedules for a given route */
    public function index()
    {
        $frid = $_GET['frid'] ?? null;
        if (!$frid)
            die("Missing route ID");

        $route = $this->flightRouteModel->find($frid);
        if (!$route)
            die("Route not found");

        // restrict view to airline that owns the route
        $aid = $_SESSION['aid'] ?? null;
        if ($route['aid'] != $aid) {
            die("Unauthorized: You can only manage your airline’s routes.");
        }

        $filters = ['frid' => $frid];
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (!empty($_GET['date_departure_from'])) {
            $filters['date_departure_from'] = $_GET['date_departure_from'];
        }
        if (!empty($_GET['date_departure_to'])) {
            $filters['date_departure_to'] = $_GET['date_departure_to'];
        }
        if (!empty($_GET['date_arrival_from'])) {
            $filters['date_arrival_from'] = $_GET['date_arrival_from'];
        }
        if (!empty($_GET['date_arrival_to'])) {
            $filters['date_arrival_to'] = $_GET['date_arrival_to'];
        }

        // pagination
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $schedules = $this->flightScheduleModel->all($filters, $limit, $offset) ?: [];
        $total = $this->flightScheduleModel->count($filters);
        $pages = ceil($total / $limit);

        require __DIR__ . '/../views/airline/routeschedules/index.php';
    }

    /** Store new schedule for this route */
    public function store()
    {
        $frid = $_POST['frid'] ?? null;

        if (!$frid || !is_numeric($frid)) {
            Flash::set('error', 'Invalid route ID');
            header("Location: /airline/flight-routes");
            exit;
        }

        // Fetch the route, including the aircraft ID
        $route = $this->flightRouteModel->find((int) $frid);
        $aid = $_SESSION['aid'] ?? null;

        if (!$route || $route['aid'] != $aid) {
            die("Unauthorized: Route does not belong to your airline.");
        }

        $data = [
            'auid' => $_SESSION['user_id'] ?? null,
            'frid' => (int) $frid,
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled',
            'first_price' => $_POST['first_price'] ?? null,
            'business_price' => $_POST['business_price'] ?? null,
            'economy_price' => $_POST['economy_price'] ?? null
        ];

        // Use FlightSchedule::create() to get the inserted ID
        $scheduleId = $this->flightScheduleModel->createAndGetId($data);

        if ($scheduleId) {
            // Ensure aircraft ID exists and pass integers to SeatService
            $aircraftId = $route['acid'] ?? null;
            if (!empty($aircraftId)) {
                $this->seatService->generateSeats((int) $scheduleId, (int) $aircraftId);
            }
        }

        Flash::set('success', 'Schedule created!');
        header("Location: /airline/flight-routes/schedules?frid=$frid");
        exit;
    }


    /** Update schedule */
    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule)
            die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action.");
        }

        $data = [
            'frid' => $schedule['frid'],
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled',
            'first_price' => $_POST['first_price'] ?? null,
            'business_price' => $_POST['business_price'] ?? null,
            'economy_price' => $_POST['economy_price'] ?? null
        ];

        $this->flightScheduleModel->update($id, $data);

        if (!empty($_POST['acid']) && $_POST['acid'] != $route['acid']) {
            // delete old seats
            $this->seatService->deleteSeatsBySchedule($id);
            // regenerate seats
            $this->seatService->generateSeats($id, $_POST['acid']);
        }

        Flash::set('success', 'Schedule updated!');
        header("Location: /airline/flight-routes/schedules?frid=" . $schedule['frid']);
        exit;
    }

    /** Delete schedule */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        $frid = $_GET['frid'] ?? null;
        if (!$id)
            die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule)
            die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action.");
        }

        // ✅ Also delete seats for this schedule
        $this->seatService->deleteSeatsBySchedule($id);

        $this->flightScheduleModel->delete($id);
        Flash::set('success', 'Schedule deleted!');
        header("Location: /airline/flight-routes/schedules?frid=" . ($frid ?? $schedule['frid']));
        exit;
    }

    public function viewSeats()
    {
        $fid = $_GET['fid'] ?? null;
        if (!$fid)
            die("Missing flight ID");

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 15; // seats per page
        $offset = ($page - 1) * $limit;

        $seatService = new SeatService($this->pdo);
        $allSeats = $seatService->getSeatsBySchedule((int) $fid);

        // Paginate array manually
        $seats = array_slice($allSeats, $offset, $limit);
        $totalSeats = count($allSeats);
        $totalPages = ceil($totalSeats / $limit);

        $scheduleModel = new FlightSchedule($this->pdo);
        $schedule = $scheduleModel->find((int) $fid);

        require __DIR__ . '/../views/airline/routeschedules/seats.php';
    }
}


