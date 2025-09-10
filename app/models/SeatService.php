<?php
require_once __DIR__ . '/Seat.php';

class SeatService
{
    private $pdo;
    private $seatModel;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->seatModel = new Seat($pdo);
    }

    public function generateSeats($fid, $aircraftId)
    {
        // fetch aircraft config
        $stmt = $this->pdo->prepare("SELECT first_class, business_class, economy_class 
                                     FROM tblaircraft WHERE id = :id");
        $stmt->execute([':id' => $aircraftId]);
        $aircraft = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$aircraft) return;

        $classes = [
            "First"    => ["count" => (int)$aircraft['first_class'], "perRow" => 3],
            "Business" => ["count" => (int)$aircraft['business_class'], "perRow" => 4],
            "Economy"  => ["count" => (int)$aircraft['economy_class'], "perRow" => 6],
        ];

        $letters = range('A', 'Z');
        $ticketNo = 1;

        foreach ($classes as $class => $cfg) {
            for ($i = 1; $i <= $cfg['count']; $i++) {
                $rowNum = ceil($i / $cfg['perRow']);
                $col    = ($i - 1) % $cfg['perRow'];
                $seat   = $letters[$col] . $rowNum;

                $this->seatModel->create([
                    'fid'       => $fid,
                    'ticket_no' => str_pad($ticketNo, 6, '0', STR_PAD_LEFT),
                    'seat_name' => $seat,
                    'class'     => $class,
                    'status'    => 'available'
                ]);

                $ticketNo++;
            }
        }
    }

    public function deleteSeatsBySchedule($fid)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tblseats WHERE fid = :fid");
        return $stmt->execute([':fid' => $fid]);
    }
public function getSeatsBySchedule(int $fid): array
{

    $stmt = $this->pdo->prepare("
        SELECT * 
        FROM tblseats 
        WHERE fid = :fid 
        ORDER BY 
            CASE class
                WHEN 'First' THEN 1
                WHEN 'Business' THEN 2
                WHEN 'Economy' THEN 3
            END,
            seat_name ASC
    ");
    $stmt->execute([':fid' => $fid]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
