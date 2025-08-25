<?php
class UserController
{
    private $userModel;

    public function __construct()
    {
        global $db; // from config.php
        $this->userModel = new User($db);
    }

    /** List users with filters + pagination */
    public function index()
    {
        $filters = [
            'user' => $_GET['user'] ?? null,
            'role' => $_GET['role'] ?? null,
        ];

        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $users = $this->userModel->all($filters, $perPage, $offset);
        $total = $this->userModel->count($filters);
        $pages = ceil($total / $perPage);

        require __DIR__ . '/../views/admin/users/index.php';
    }

    /** Handle form submit for new user */
    public function store()
    {
        $data = [
            'user' => $_POST['user'] ?? null,
            'pass' => $_POST['pass'] ?? null,
            'role' => $_POST['role'] ?? null,
        ];

        $this->userModel->create($data);
        Flash::set('success', 'User created successfully!');
        header("Location: /admin/users");
        exit;
    }

    /** Handle update */
    public function update()
    {
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $data = [
            'user' => $_POST['user'] ?? null,
            'pass' => $_POST['pass'] ?? null,
            'role' => $_POST['role'] ?? null,
        ];

        $this->userModel->update($id, $data);
        Flash::set('success', 'User updated successfully!');
        header("Location: /admin/users");
        exit;
    }

    /** Delete user */
    public function destroy()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) die("Missing ID");

        $this->userModel->delete($id);
        Flash::set('success', 'User deleted successfully!');
        header("Location: /admin/users");
        exit;
    }

    /** Optional: User dashboard */
    public function dashboard()
    {
        require __DIR__ . '/../views/user/dashboard.php';
        exit;
    }
}
