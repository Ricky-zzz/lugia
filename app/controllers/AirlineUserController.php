<?php

class AirlineUserController extends Controller
{
    private $airlineUserModel;
    private $airlineModel; // <-- new

    public function __construct()
    {
        global $db; // from config.php
        $this->airlineUserModel = new AirlineUser($db);
        $this->airlineModel = new Airline($db); // <-- load Airline model too
    }

    /** List airline users with filters + pagination */
    public function index()
    {
        $filters = [
            'user' => $_GET['user'] ?? null,
            'type' => $_GET['type'] ?? null,
            'aid' => $_GET['aid'] ?? null,
        ];

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $users = $this->airlineUserModel->all($filters, $perPage, $offset);
        $total = $this->airlineUserModel->count($filters);
        $pages = ceil($total / $perPage);

        // ✅ fetch airlines for dropdown
        $airlines = $this->airlineModel->all();

        // ✅ pass data to view
        $airlineUsers = $users;
        require __DIR__ . '/../views/admin/airlineusers/index.php';
    }

    /** Handle form submit for new airline user */
    public function store()
    {
        $data = [
            'user' => $_POST['user'] ?? null,
            'pass' => $_POST['pass'] ?? null, // plain text for now
            'type' => $_POST['type'] ?? null,
            'aid' => $_POST['aid'] ?? null,
        ];

        $this->airlineUserModel->create($data);
        Flash::set('success', 'Airline user created successfully!');
        header("Location: /admin/airline-users");
        exit;
    }

    /** Handle update */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $data = [
            'user' => $_POST['user'] ?? null,
            'type' => $_POST['type'] ?? null,
            'aid' => $_POST['aid'] ?? null,
        ];

        // Only include password if a new value was entered
        if (!empty($_POST['pass'])) {
            $data['pass'] = $_POST['pass'];
        }


        $this->airlineUserModel->update($id, $data);
        Flash::set('success', 'Airline user updated successfully!');
        header("Location: /admin/airline-users");
        exit;
    }

    /** Delete airline user */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id)
            die("Missing ID");

        $this->airlineUserModel->delete($id);
        Flash::set('success', 'Airline user deleted successfully!');
        header("Location: /admin/airline-users");
        exit;
    }

    /** Airline User Dashboard (untouched) */
    public function dashboard()
    {
        $this->view("airline/dashboard");
        exit;
    }
}
