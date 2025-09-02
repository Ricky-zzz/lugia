<?php

class RouteScheduleController extends Controller
{
    private $flightScheduleModel;
    private $flightRouteModel;

    public function __construct()
    {
        global $db;
        $this->flightScheduleModel = new FlightSchedule($db);
        $this->flightRouteModel    = new FlightRoute($db);
    }

    /** List schedules for a given route */
    public function index()
    {
        $frid = $_GET['frid'] ?? null;
        if (!$frid) die("Missing route ID");

        $route = $this->flightRouteModel->find($frid);
        if (!$route) die("Route not found");

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
        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $schedules = $this->flightScheduleModel->all($filters, $limit, $offset) ?: [];
        $total     = $this->flightScheduleModel->count($filters);
        $pages     = ceil($total / $limit);

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

        $route = $this->flightRouteModel->find((int)$frid);
        $aid = $_SESSION['aid'] ?? null;

        if (!$route || $route['aid'] != $aid) {
            die("Unauthorized: Route does not belong to your airline.");
        }

        $data = [
            'auid' => $_SESSION['user_id'] ?? null,
            'frid' => (int)$frid,  // Cast to integer
            'date_departure' => $_POST['date_departure'] ?? null,
            'time_departure' => $_POST['time_departure'] ?? null,
            'date_arrival' => $_POST['date_arrival'] ?? null,
            'time_arrival' => $_POST['time_arrival'] ?? null,
            'status' => $_POST['status'] ?? 'scheduled',
        ];

        $this->flightScheduleModel->create($data);
        Flash::set('success', 'Schedule created!');
        header("Location: /airline/flight-routes/schedules?frid=$frid");
        exit;
    }

    /** Update schedule */
    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule) die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid   = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action.");
        }

        $data = [
            'frid'          => $schedule['frid'],
            'date_departure'=> $_POST['date_departure'] ?? null,
            'time_departure'=> $_POST['time_departure'] ?? null,
            'date_arrival'  => $_POST['date_arrival'] ?? null,
            'time_arrival'  => $_POST['time_arrival'] ?? null,
            'status'        => $_POST['status'] ?? 'scheduled',
        ];

        $this->flightScheduleModel->update($id, $data);
        Flash::set('success', 'Schedule updated!');
        header("Location: /airline/flight-routes/schedules?frid=" . $schedule['frid']);
        exit;
    }

    /** Delete schedule */
    public function destroy()
    {
        $id   = $_GET['id'] ?? null;
        $frid = $_GET['frid'] ?? null;
        if (!$id) die("Missing ID");

        $schedule = $this->flightScheduleModel->find($id);
        if (!$schedule) die("Schedule not found");

        $route = $this->flightRouteModel->find($schedule['frid']);
        $aid   = $_SESSION['aid'] ?? null;

        if ($route['aid'] != $aid) {
            die("Unauthorized action.");
        }

        $this->flightScheduleModel->delete($id);
        Flash::set('success', 'Schedule deleted!');
        header("Location: /airline/flight-routes/schedules?frid=" . ($frid ?? $schedule['frid']));
        exit;
    }
}
