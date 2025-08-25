<?php
require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel {
    public function __construct($pdo) {
        parent::__construct($pdo, "tbluser");
    }

    /**
     * Find user by username (for login)
     */
    public function findByUsername(string $username): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE user = :user LIMIT 1");
        $stmt->execute([':user' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Fetch all users with optional filters + paging
     */
    public function all(array $filters = [], int $limit = 50, int $offset = 0, string $orderBy = 'id', string $orderDir = 'ASC'): array {
        $sql = "SELECT id, user, role FROM {$this->table}";
        $where = [];
        $params = [];

        if (!empty($filters['user'])) {
            $where[] = "user LIKE :user";
            $params[':user'] = '%' . $filters['user'] . '%';
        }
        if (!empty($filters['role'])) {
            $where[] = "role = :role";
            $params[':role'] = $filters['role'];
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $allowedOrder = ['id','user','role'];
        if (!in_array($orderBy, $allowedOrder, true)) {
            $orderBy = 'id';
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
     * Count users with filters (for pagination)
     */
    public function count(array $filters = []): int {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $where = [];
        $params = [];

        if (!empty($filters['user'])) {
            $where[] = "user LIKE :user";
            $params[':user'] = '%' . $filters['user'] . '%';
        }
        if (!empty($filters['role'])) {
            $where[] = "role = :role";
            $params[':role'] = $filters['role'];
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
     * Insert a new user
     */
    public function create(array $data): bool {
        $sql = "INSERT INTO {$this->table} (user, pass, role)
                VALUES (:user, :pass, :role)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':user' => $data['user'] ?? null,
            ':pass' => $data['pass'] ?? null, // remember to hash passwords!
            ':role' => $data['role'] ?? null,
        ]);
    }

    /**
     * Update a user
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} 
                   SET user = :user, pass = :pass, role = :role
                 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'   => $id,
            ':user' => $data['user'] ?? null,
            ':pass' => $data['pass'] ?? null,
            ':role' => $data['role'] ?? null,
        ]);
    }

    /**
     * Delete a user
     */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
