<?php
require_once __DIR__ . '/BaseModel.php';

class Aircraft extends BaseModel {
    public function __construct($pdo) {
        parent::__construct($pdo, "tblaircraft"); // your table name
    }

    /**
     * Fetch all aircraft with optional filters + paging
     */
    public function all(array $filters = [], int $limit = 100, int $offset = 0, string $orderBy = 'model', string $orderDir = 'ASC'): array {
        $sql = "SELECT id, iata, icao, model FROM {$this->table}";
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
        if (!empty($filters['model'])) {
            $where[] = "model LIKE :model";
            $params[':model'] = '%' . $filters['model'] . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $allowedOrder = ['id','iata','icao','model'];
        if (!in_array($orderBy, $allowedOrder, true)) {
            $orderBy = 'model';
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
     * Count aircraft with filters (for pagination)
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
        if (!empty($filters['model'])) {
            $where[] = "model LIKE :model";
            $params[':model'] = '%' . $filters['model'] . '%';
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
     * Insert a new aircraft
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->table} (iata, icao, model)
                VALUES (:iata, :icao, :model)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':iata'  => $data['iata'] ?? null,
            ':icao'  => $data['icao'] ?? null,
            ':model' => $data['model'] ?? null,
        ]);
    }

    /**
     * Update an aircraft
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} 
                   SET iata = :iata, icao = :icao, model = :model
                 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'    => $id,
            ':iata'  => $data['iata'] ?? null,
            ':icao'  => $data['icao'] ?? null,
            ':model' => $data['model'] ?? null,
        ]);
    }

    /**
     * Delete an aircraft
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
