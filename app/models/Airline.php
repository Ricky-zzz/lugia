<?php
require_once __DIR__ . '/BaseModel.php';

class Airline extends BaseModel {
    public function __construct($pdo) {
        parent::__construct($pdo, "tblairline");
    }

    /**
     * Override all() to keep your custom filtering + paging
     */
    public function all(array $filters = [], int $limit = 100, int $offset = 0, string $orderBy = 'airline_name', string $orderDir = 'ASC'): array {
        $sql = "SELECT id, iata, icao, airline_name, callsign, region, comments
                FROM {$this->table}";
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

    /**
     * Count airlines with filters (for pagination)
     */
    public function count(array $filters = []): int {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
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

    /**
     * Insert a new airline
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->table} (iata, icao, airline_name, callsign, region, comments)
                VALUES (:iata, :icao, :airline_name, :callsign, :region, :comments)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':iata'         => $data['iata'] ?? null,
            ':icao'         => $data['icao'] ?? null,
            ':airline_name' => $data['airline_name'] ?? null,
            ':callsign'     => $data['callsign'] ?? null,
            ':region'       => $data['region'] ?? null,
            ':comments'     => $data['comments'] ?? null,
        ]);
    }

    /**
     * Update an airline
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} 
                   SET iata = :iata, icao = :icao, airline_name = :airline_name, 
                       callsign = :callsign, region = :region, comments = :comments
                 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'           => $id,
            ':iata'         => $data['iata'] ?? null,
            ':icao'         => $data['icao'] ?? null,
            ':airline_name' => $data['airline_name'] ?? null,
            ':callsign'     => $data['callsign'] ?? null,
            ':region'       => $data['region'] ?? null,
            ':comments'     => $data['comments'] ?? null,
        ]);
    }
}
