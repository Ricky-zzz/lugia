<?php
class Airline {
    /** @var PDO */
    private $pdo;

    public function __construct($pdo) {
        // $pdo is your PDO connection from Database::getInstance(...)
        $this->pdo = $pdo;
    }

    /**
     * Basic list with optional filters + paging.
     * Start simple; you can expand later.
     */
    public function all(array $filters = [], int $limit = 100, int $offset = 0, string $orderBy = 'airline_name', string $orderDir = 'ASC'): array {
        $sql = "SELECT id, iata, icao, airline_name, callsign, region, comments
                FROM tblairline";
        $where = [];
        $params = [];

        // Optional filters (wire later if you want)
        if (!empty($filters['iata'])) {
            $where[] = "iata LIKE :iata";
            $params[':iata'] = $filters['iata'] . '%';
        }
        if (!empty($filters['icao'])) {
            $where[] = "icao LIKE :icao";
            $params[':icao'] = $filters['icao'] . '%';
        }
        if (!empty($filters['airline_name'])) {
            $where[] = "airline_name LIKE :airline_name";
            $params[':airline_name'] = '%' . $filters['airline_name'] . '%';
        }
        if (!empty($filters['callsign'])) {
            $where[] = "callsign LIKE :callsign";
            $params[':callsign'] = '%' . $filters['callsign'] . '%';
        }
        if (!empty($filters['region'])) {
            $where[] = "region LIKE :region";
            $params[':region'] = '%' . $filters['region'] . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        // Safe sort
        $allowedOrder = ['id','iata','icao','airline_name','callsign','region'];
        if (!in_array($orderBy, $allowedOrder, true)) {
            $orderBy = 'airline_name';
        }
        $orderDir = strtoupper($orderDir) === 'DESC' ? 'DESC' : 'ASC';
        $sql .= " ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(array $filters = []): int {
        $sql = "SELECT COUNT(*) FROM tblairline";
        $where = [];
        $params = [];

        if (!empty($filters['iata'])) {
            $where[] = "iata LIKE :iata";
            $params[':iata'] = $filters['iata'] . '%';
        }
        if (!empty($filters['icao'])) {
            $where[] = "icao LIKE :icao";
            $params[':icao'] = $filters['icao'] . '%';
        }
        if (!empty($filters['airline_name'])) {
            $where[] = "airline_name LIKE :airline_name";
            $params[':airline_name'] = '%' . $filters['airline_name'] . '%';
        }
        if (!empty($filters['callsign'])) {
            $where[] = "callsign LIKE :callsign";
            $params[':callsign'] = '%' . $filters['callsign'] . '%';
        }
        if (!empty($filters['region'])) {
            $where[] = "region LIKE :region";
            $params[':region'] = '%' . $filters['region'] . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }
}
