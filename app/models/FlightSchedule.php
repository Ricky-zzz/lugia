<?php
require_once __DIR__ . '/BaseModel.php';

class FlightSchedule extends BaseModel
{
    public function __construct($pdo)
    {
        parent::__construct($pdo, "tblflightschedule");
    }

    /**
     * Fetch all flight schedules with joins and optional filters
     */
    public function all($filters = [], $limit = 0, $offset = 0)
    {
        $sql = "SELECT 
                    fs.id,
                    fs.auid,
                    fs.frid,
                    fs.date_departure,
                    fs.time_departure,
                    fs.date_arrival,
                    fs.time_arrival,
                    fs.status,
                    au.user AS schedule_user,
                    fr.aid AS airline_id,
                    a.airline_name,
                    ao.airport_name AS origin_airport,
                    ao.iata AS origin_iata,
                    ad.airport_name AS destination_airport,
                    ad.iata AS destination_iata,
                    ac.model AS aircraft_model
                FROM {$this->table} fs
                LEFT JOIN tblairlineuser au ON fs.auid = au.id
                LEFT JOIN tblflightroute fr ON fs.frid = fr.id
                LEFT JOIN tblairline a ON fr.aid = a.id
                LEFT JOIN tblairport ao ON fr.oapid = ao.id
                LEFT JOIN tblairport ad ON fr.dapid = ad.id
                LEFT JOIN tblaircraft ac ON fr.acid = ac.id
                WHERE 1=1";

        $params = [];

        // ID filter
        if (!empty($filters['id'])) {
            $sql .= " AND fs.id = :id";
            $params[':id'] = $filters['id'];
        }

        // User ID or name
        if (!empty($filters['auid'])) {
            $sql .= " AND fs.auid = :auid";
            $params[':auid'] = $filters['auid'];
        }
        if (!empty($filters['schedule_user'])) {
            $sql .= " AND au.user LIKE :schedule_user";
            $params[':schedule_user'] = '%' . $filters['schedule_user'] . '%';
        }

        // Flight route & status
        if (!empty($filters['frid'])) {
            $sql .= " AND fs.frid = :frid";
            $params[':frid'] = $filters['frid'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND fs.status = :status";
            $params[':status'] = $filters['status'];
        }

        // Date ranges
        if (!empty($filters['date_departure_from'])) {
            $sql .= " AND fs.date_departure >= :date_departure_from";
            $params[':date_departure_from'] = $filters['date_departure_from'];
        }
        if (!empty($filters['date_departure_to'])) {
            $sql .= " AND fs.date_departure <= :date_departure_to";
            $params[':date_departure_to'] = $filters['date_departure_to'];
        }
        if (!empty($filters['date_arrival_from'])) {
            $sql .= " AND fs.date_arrival >= :date_arrival_from";
            $params[':date_arrival_from'] = $filters['date_arrival_from'];
        }
        if (!empty($filters['date_arrival_to'])) {
            $sql .= " AND fs.date_arrival <= :date_arrival_to";
            $params[':date_arrival_to'] = $filters['date_arrival_to'];
        }

        // Pagination
        if ($limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        if ($limit > 0) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count flight schedules with optional filters
     */
    public function count($filters = [])
    {
        $sql = "SELECT COUNT(*) as count
                FROM {$this->table} fs
                LEFT JOIN tblairlineuser au ON fs.auid = au.id
                LEFT JOIN tblflightroute fr ON fs.frid = fr.id
                LEFT JOIN tblairline a ON fr.aid = a.id
                LEFT JOIN tblairport ao ON fr.oapid = ao.id
                LEFT JOIN tblairport ad ON fr.dapid = ad.id
                LEFT JOIN tblaircraft ac ON fr.acid = ac.id
                WHERE 1=1";

        $params = [];

        if (!empty($filters['id'])) {
            $sql .= " AND fs.id = :id";
            $params[':id'] = $filters['id'];
        }
        if (!empty($filters['auid'])) {
            $sql .= " AND fs.auid = :auid";
            $params[':auid'] = $filters['auid'];
        }
        if (!empty($filters['schedule_user'])) {
            $sql .= " AND au.user LIKE :schedule_user";
            $params[':schedule_user'] = '%' . $filters['schedule_user'] . '%';
        }
        if (!empty($filters['frid'])) {
            $sql .= " AND fs.frid = :frid";
            $params[':frid'] = $filters['frid'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND fs.status = :status";
            $params[':status'] = $filters['status'];
        }
        if (!empty($filters['date_departure_from'])) {
            $sql .= " AND fs.date_departure >= :date_departure_from";
            $params[':date_departure_from'] = $filters['date_departure_from'];
        }
        if (!empty($filters['date_departure_to'])) {
            $sql .= " AND fs.date_departure <= :date_departure_to";
            $params[':date_departure_to'] = $filters['date_departure_to'];
        }
        if (!empty($filters['date_arrival_from'])) {
            $sql .= " AND fs.date_arrival >= :date_arrival_from";
            $params[':date_arrival_from'] = $filters['date_arrival_from'];
        }
        if (!empty($filters['date_arrival_to'])) {
            $sql .= " AND fs.date_arrival <= :date_arrival_to";
            $params[':date_arrival_to'] = $filters['date_arrival_to'];
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Create flight schedule
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
                (auid, frid, date_departure, time_departure, date_arrival, time_arrival, status)
                VALUES (:auid, :frid, :date_departure, :time_departure, :date_arrival, :time_arrival, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':auid' => $data['auid'] ?? null,
            ':frid' => $data['frid'] ?? null,
            ':date_departure' => $data['date_departure'] ?? null,
            ':time_departure' => $data['time_departure'] ?? null,
            ':date_arrival' => $data['date_arrival'] ?? null,
            ':time_arrival' => $data['time_arrival'] ?? null,
            ':status' => $data['status'] ?? 'scheduled'
        ]);
    }

    /**
     * Update flight schedule
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table} SET 
                    auid = :auid,
                    frid = :frid,
                    date_departure = :date_departure,
                    time_departure = :time_departure,
                    date_arrival = :date_arrival,
                    time_arrival = :time_arrival,
                    status = :status
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':auid' => $data['auid'] ?? null,
            ':frid' => $data['frid'] ?? null,
            ':date_departure' => $data['date_departure'] ?? null,
            ':time_departure' => $data['time_departure'] ?? null,
            ':date_arrival' => $data['date_arrival'] ?? null,
            ':time_arrival' => $data['time_arrival'] ?? null,
            ':status' => $data['status'] ?? 'scheduled'
        ]);
    }

    /**
     * Delete flight schedule
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

        /**
     * Find single flight schedule by ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT 
                    fs.id,
                    fs.auid,
                    fs.frid,
                    fs.date_departure,
                    fs.time_departure,
                    fs.date_arrival,
                    fs.time_arrival,
                    fs.status,
                    au.user AS schedule_user,
                    fr.aid AS airline_id,
                    a.airline_name,
                    ao.airport_name AS origin_airport,
                    ao.iata AS origin_iata,
                    ad.airport_name AS destination_airport,
                    ad.iata AS destination_iata,
                    ac.model AS aircraft_model
                FROM {$this->table} fs
                LEFT JOIN tblairlineuser au ON fs.auid = au.id
                LEFT JOIN tblflightroute fr ON fs.frid = fr.id
                LEFT JOIN tblairline a ON fr.aid = a.id
                LEFT JOIN tblairport ao ON fr.oapid = ao.id
                LEFT JOIN tblairport ad ON fr.dapid = ad.id
                LEFT JOIN tblaircraft ac ON fr.acid = ac.id
                WHERE fs.id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

}
