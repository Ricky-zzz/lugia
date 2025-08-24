<?php
require_once __DIR__ . '/BaseModel.php';

class FlightRoute extends BaseModel
{
    private $lastQuery = '';

    public function __construct($pdo)
    {
        parent::__construct($pdo, "tblflightroute"); // Correct table name without 's'
    }

    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * Fetch all flight routes (with joins to airline, airports, aircraft)
     */
    public function all($filters = [], $limit = 0, $offset = 0)
    {
        $sql = "SELECT 
               fr.id,
               fr.aid,
               fr.oapid,
               fr.dapid,
               fr.round_trip,
               fr.acid,
               a.airline_name,
               ao.airport_name AS origin_airport,
               ao.iata AS origin_iata,
               ad.airport_name AS destination_airport,
               ad.iata AS destination_iata,
               ac.model AS aircraft_model
        FROM {$this->table} fr
        LEFT JOIN tblairline a ON fr.aid = a.id
        LEFT JOIN tblairport ao ON fr.oapid = ao.id
        LEFT JOIN tblairport ad ON fr.dapid = ad.id
        LEFT JOIN tblaircraft ac ON fr.acid = ac.id
        WHERE 1=1";


        $params = [];

        // Apply filters
        if (!empty($filters['id'])) {
            $sql .= " AND fr.id = :id";
            $params[':id'] = $filters['id'];
        }

        if (!empty($filters['aid'])) {
            $sql .= " AND fr.aid = :aid";
            $params[':aid'] = $filters['aid'];
        }
        if (!empty($filters['oapid'])) {
            $sql .= " AND fr.oapid = :oapid";
            $params[':oapid'] = $filters['oapid'];
        }
        if (!empty($filters['dapid'])) {
            $sql .= " AND fr.dapid = :dapid";
            $params[':dapid'] = $filters['dapid'];
        }
        if (!empty($filters['acid'])) {
            $sql .= " AND fr.acid = :acid";
            $params[':acid'] = $filters['acid'];
        }
        if (isset($filters['round_trip']) && $filters['round_trip'] !== '') {
            $sql .= " AND fr.round_trip = :round_trip";
            $params[':round_trip'] = $filters['round_trip'];
        }

        // Only add limit and offset if they are greater than 0
        if ($limit > 0) {
            $sql .= " LIMIT :limit";
            if ($offset > 0) {
                $sql .= " OFFSET :offset";
            }
        }

        $this->lastQuery = $sql;
        try {
            $stmt = $this->pdo->prepare($sql);

            // Bind all filter parameters first
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
                $this->lastQuery = str_replace($key, "'$val'", $this->lastQuery);
            }

            // Only bind limit and offset if they are being used
            if ($limit > 0) {
                $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
                $this->lastQuery = str_replace(':limit', $limit, $this->lastQuery);
                if ($offset > 0) {
                    $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
                    $this->lastQuery = str_replace(':offset', $offset, $this->lastQuery);
                }
            }

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<!-- Debug: Found " . count($result) . " routes in database -->\n";
            return $result;
        } catch (PDOException $e) {
            echo "<!-- Debug: SQL Error: " . $e->getMessage() . " -->\n";
            return [];
        }
    }

    /**
     * Count flight routes
     */
public function count($filters = [])
{
    $sql = "SELECT COUNT(*) as count
            FROM {$this->table} fr
            LEFT JOIN tblairline a ON fr.aid = a.id
            LEFT JOIN tblairport ao ON fr.oapid = ao.id
            LEFT JOIN tblairport ad ON fr.dapid = ad.id
            LEFT JOIN tblaircraft ac ON fr.acid = ac.id
            WHERE 1=1";
    $params = [];

    if (!empty($filters['id'])) {
        $sql .= " AND fr.id = :id";
        $params[':id'] = $filters['id'];
    }
    if (!empty($filters['aid'])) {
        $sql .= " AND fr.aid = :aid";
        $params[':aid'] = $filters['aid'];
    }
    if (!empty($filters['oapid'])) {
        $sql .= " AND fr.oapid = :oapid";
        $params[':oapid'] = $filters['oapid'];
    }
    if (!empty($filters['dapid'])) {
        $sql .= " AND fr.dapid = :dapid";
        $params[':dapid'] = $filters['dapid'];
    }
    if (!empty($filters['acid'])) {
        $sql .= " AND fr.acid = :acid";
        $params[':acid'] = $filters['acid'];
    }
    if (isset($filters['round_trip']) && $filters['round_trip'] !== '') {
        $sql .= " AND fr.round_trip = :round_trip";
        $params[':round_trip'] = $filters['round_trip'];
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
}



    /**
     * Create flight route
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} (aid, oapid, dapid, round_trip, acid)
            VALUES (:aid, :oapid, :dapid, :round_trip, :acid)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':aid' => $data['aid'] ?? null,
            ':oapid' => $data['oapid'] ?? null,
            ':dapid' => $data['dapid'] ?? null,
            ':round_trip' => $data['round_trip'] ?? 0,
            ':acid' => $data['acid'] ?? null,
        ]);
    }

    /**
     * Update flight route
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
               SET aid        = :aid,
                   oapid      = :oapid,
                   dapid      = :dapid,
                   round_trip = :round_trip,
                   acid       = :acid
             WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':aid' => $data['aid'] ?? null,
            ':oapid' => $data['oapid'] ?? null,
            ':dapid' => $data['dapid'] ?? null,
            ':round_trip' => $data['round_trip'] ?? 0,
            ':acid' => $data['acid'] ?? null,
        ]);
    }

    /**
     * Delete flight route
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
