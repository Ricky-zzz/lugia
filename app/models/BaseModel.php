<?php
class BaseModel {
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo, string $table) {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    /** Fetch all records */
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /** Find single record by ID */
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /** Delete record by ID */
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /** Create record (INSERT) */
    public function create(array $data): bool {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    /** Update record (by ID) */
    public function update(int $id, array $data): bool {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $fields = implode(", ", $fields);

        $sql = "UPDATE {$this->table} SET $fields WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $data['id'] = $id; // merge id into data array
        return $stmt->execute($data);
    }
}
