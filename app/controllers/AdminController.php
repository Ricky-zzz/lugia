<?php
class AdminController extends Controller {
    public function dashboard() {
        $title = "Admin Dashboard - Lugia";

        // 1) Instantiate model with your PDO
        $airlineModel = new Airline($GLOBALS['db']);

        // 2) (Optional) Read filters/paging from query string
        $filters = [
            'iata'         => trim($_GET['iata'] ?? ''),
            'icao'         => trim($_GET['icao'] ?? ''),
            'airline_name' => trim($_GET['airline'] ?? ''),
            'callsign'     => trim($_GET['callsign'] ?? ''),
            'region'       => trim($_GET['region'] ?? ''),
        ];
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 25;
        $offset = ($page - 1) * $limit;

        // 3) Get data
        $airlines = $airlineModel->all($filters, $limit, $offset);
        $total    = $airlineModel->count($filters);
        $pages    = (int)ceil($total / $limit);

        // 4) Pass to view
        $this->view("admin/dashboard", compact('title','airlines','filters','page','pages','total'));
    }
}
