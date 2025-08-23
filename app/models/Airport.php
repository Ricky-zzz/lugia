<?php
require_once __DIR__ . '/BaseModel.php';

class Airport extends BaseModel {
    public function __construct($pdo) {
        parent::__construct($pdo, "tblairport");
    }

    /**
     * Fetch all airports with optional filters, pagination, and ordering
     */
    public function all(array $filters = [], int $limit = 100, int $offset = 0, string $orderBy = 'airport_name', string $orderDir = 'ASC'): array {
        $sql = "SELECT id, iata, icao, airport_name, location_serve, time, dst FROM {$this->table}";
        $where = [];
        $params = [];

        // Only add to $params if the filter exists
        if (!empty($filters['iata'])) {
            $where[] = "iata LIKE :iata";
            $params[':iata'] = $filters['iata'] . '%';
        }
        if (!empty($filters['icao'])) {
            $where[] = "icao LIKE :icao";
            $params[':icao'] = $filters['icao'] . '%';
        }
        if (!empty($filters['airport_name'])) {
            $where[] = "airport_name LIKE :airport_name";
            $params[':airport_name'] = '%' . $filters['airport_name'] . '%';
        }
        if (!empty($filters['location_serve'])) {
            $where[] = "location_serve LIKE :location_serve";
            $params[':location_serve'] = '%' . $filters['location_serve'] . '%';
        }
        if (!empty($filters['time'])) {
            $where[] = "time = :time";
            $params[':time'] = $filters['time'];
        }
        if (!empty($filters['dst'])) {
            $where[] = "dst = :dst";
            $params[':dst'] = $filters['dst'];
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $allowedOrder = ['id','iata','icao','airport_name','location_serve','time','dst'];
        if (!in_array($orderBy, $allowedOrder, true)) $orderBy = 'airport_name';
        $orderDir = strtoupper($orderDir) === 'DESC' ? 'DESC' : 'ASC';
        $sql .= " ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        // Bind only the parameters that exist
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count airports (for pagination) with filters
     */
    public function count(array $filters = []): int {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $where = [];
        $params = [];

        if (!empty($filters['iata'])) { $where[] = "iata LIKE :iata"; $params[':iata'] = $filters['iata'] . '%'; }
        if (!empty($filters['icao'])) { $where[] = "icao LIKE :icao"; $params[':icao'] = $filters['icao'] . '%'; }
        if (!empty($filters['airport_name'])) { $where[] = "airport_name LIKE :airport_name"; $params[':airport_name'] = '%' . $filters['airport_name'] . '%'; }
        if (!empty($filters['location_serve'])) { $where[] = "location_serve LIKE :location_serve"; $params[':location_serve'] = '%' . $filters['location_serve'] . '%'; }
        if (!empty($filters['time'])) { $where[] = "time = :time"; $params[':time'] = $filters['time']; }
        if (!empty($filters['dst'])) { $where[] = "dst = :dst"; $params[':dst'] = $filters['dst']; }

        if ($where) $sql .= " WHERE " . implode(' AND ', $where);

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->table} (iata, icao, airport_name, location_serve, time, dst)
                VALUES (:iata, :icao, :airport_name, :location_serve, :time, :dst)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':iata' => $data['iata'] ?? null,
            ':icao' => $data['icao'] ?? null,
            ':airport_name' => $data['airport_name'] ?? null,
            ':location_serve' => $data['location_serve'] ?? null,
            ':time' => $data['time'] ?? null,
            ':dst' => $data['dst'] ?? null,
        ]);
    }

    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} 
                SET iata = :iata, icao = :icao, airport_name = :airport_name, 
                    location_serve = :location_serve, time = :time, dst = :dst
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':iata' => $data['iata'] ?? null,
            ':icao' => $data['icao'] ?? null,
            ':airport_name' => $data['airport_name'] ?? null,
            ':location_serve' => $data['location_serve'] ?? null,
            ':time' => $data['time'] ?? null,
            ':dst' => $data['dst'] ?? null,
        ]);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
