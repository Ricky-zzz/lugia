<?php
require_once __DIR__ . '/BaseModel.php';

class Seat extends BaseModel
{
    public function __construct($pdo)
    {
        parent::__construct($pdo, "tblseats");
    }

    /**
     * Fetch all seats for a schedule (with optional filters)
     */
    public function all(array $filters = [], int $limit = 200, int $offset = 0): array
    {
        $sql = "SELECT id, fid, ticket_no, seat_name, class, status 
                  FROM {$this->table}";
        $where = [];
        $params = [];

        if (!empty($filters['fid'])) {
            $where[] = "fid = :fid";
            $params[':fid'] = $filters['fid'];
        }
        if (!empty($filters['class'])) {
            $where[] = "class = :class";
            $params[':class'] = $filters['class'];
        }
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $sql .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $where = [];
        $params = [];

        if (!empty($filters['fid'])) {
            $where[] = "fid = :fid";
            $params[':fid'] = $filters['fid'];
        }
        if (!empty($filters['class'])) {
            $where[] = "class = :class";
            $params[':class'] = $filters['class'];
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    /**
     * Insert a single seat
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (fid, ticket_no, seat_name, class, status)
                VALUES (:fid, :ticket_no, :seat_name, :class, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':fid'       => $data['fid'] ?? null,
            ':ticket_no' => $data['ticket_no'] ?? null,
            ':seat_name' => $data['seat_name'] ?? null,
            ':class'     => $data['class'] ?? null,
            ':status'    => $data['status'] ?? 'available',
        ]);
    }

    /**
     * Update seat (ex: mark as booked)
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} 
                   SET ticket_no = :ticket_no,
                       seat_name = :seat_name,
                       class     = :class,
                       status    = :status
                 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'        => $id,
            ':ticket_no' => $data['ticket_no'] ?? null,
            ':seat_name' => $data['seat_name'] ?? null,
            ':class'     => $data['class'] ?? null,
            ':status'    => $data['status'] ?? 'available',
        ]);
    }

    /**
     * Delete a seat
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
// In Seat.php
public function findBySchedule(int $fid): array
{
    $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE fid = :fid ORDER BY seat_name");
    $stmt->execute([':fid' => $fid]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    
}
