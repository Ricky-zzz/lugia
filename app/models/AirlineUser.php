<?php
require_once __DIR__ . '/BaseModel.php';

class AirlineUser extends BaseModel
{
    public function __construct($pdo)
    {
        parent::__construct($pdo, "tblairlineuser");
    }

    /**
     * Fetch all airline users (with airline name via JOIN)
     */
    public function all(array $filters = [], int $limit = 100, int $offset = 0, string $orderBy = 'user', string $orderDir = 'ASC'): array
    {
        $sql = "SELECT u.id, u.user, u.pass, u.type, u.aid, a.airline_name
                  FROM {$this->table} u
                  LEFT JOIN tblairline a ON u.aid = a.id";
        $where = [];
        $params = [];

        // filter by username
        if (!empty($filters['user'])) {
            $where[] = "u.user LIKE :user";
            $params[':user'] = '%' . $filters['user'] . '%';
        }

        // filter by type
        if (!empty($filters['type'])) {
            $where[] = "u.type = :type";
            $params[':type'] = $filters['type'];
        }

        // filter by airline id
        if (!empty($filters['aid'])) {
            $where[] = "u.aid = :aid";
            $params[':aid'] = $filters['aid'];
        }

        // filter by airline name
        if (!empty($filters['airline_name'])) {
            $where[] = "a.airline_name LIKE :airline_name";
            $params[':airline_name'] = '%' . $filters['airline_name'] . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $allowedOrder = ['id', 'user', 'type', 'airline_name'];
        if (!in_array($orderBy, $allowedOrder, true)) {
            $orderBy = 'user';
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
     * Count airline users (for pagination)
     */
    public function count(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) 
                  FROM {$this->table} u
                  LEFT JOIN tblairline a ON u.aid = a.id";
        $where = [];
        $params = [];

        if (!empty($filters['user'])) {
            $where[] = "u.user LIKE :user";
            $params[':user'] = '%' . $filters['user'] . '%';
        }
        if (!empty($filters['type'])) {
            $where[] = "u.type = :type";
            $params[':type'] = $filters['type'];
        }
        if (!empty($filters['aid'])) {
            $where[] = "u.aid = :aid";
            $params[':aid'] = $filters['aid'];
        }
        if (!empty($filters['airline_name'])) {
            $where[] = "a.airline_name LIKE :airline_name";
            $params[':airline_name'] = '%' . $filters['airline_name'] . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * Create airline user (admin will provide default password)
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (user, pass, type, aid)
                VALUES (:user, :pass, :type, :aid)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user' => $data['user'] ?? null,
            ':pass' => $data['pass'] ?? null,  // TODO: hash password in controller
            ':type' => $data['type'] ?? null,
            ':aid' => $data['aid'] ?? null,
        ]);
    }

    /**
     * Update airline user
     */
    public function update(int $id, array $data): bool
    {
        $fields = ['user = :user', 'type = :type', 'aid = :aid'];
        $params = [
            ':id' => $id,
            ':user' => $data['user'] ?? null,
            ':type' => $data['type'] ?? null,
            ':aid' => $data['aid'] ?? null,
        ];

        // Only update password if provided
        if (isset($data['pass'])) {
            $fields[] = 'pass = :pass';
            $params[':pass'] = $data['pass'];
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }


    /**
     * Delete airline user
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
