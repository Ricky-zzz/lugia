<?php
class ImportController {
    public function import() {
        global $db; // reuse PDO from config

        if (!isset($_POST['table']) || !isset($_FILES['csv_file'])) {
            Flash::set('danger', 'Invalid import request.');
            header("Location: /admin");
            exit;
        }

        $table = $_POST['table'];  // 'aircraft', 'airline', 'airport'
        $file  = $_FILES['csv_file']['tmp_name'];

        if (!file_exists($file)) {
            Flash::set('danger', 'No file uploaded.');
            header("Location: /admin");
            exit;
        }

        $rowCount = 0;
        $skipped  = 0;
        $redirect = '/admin';

        if (($handle = fopen($file, "r")) !== FALSE) {
            // read header row
            $header = fgetcsv($handle);

            try {
                switch ($table) {
                    case 'aircraft':
                        $expectedCols = 3;
                        $stmt = $db->prepare("INSERT INTO tblaircraft (iata, icao, model) VALUES (?, ?, ?)");
                        $redirect = '/admin/aircraft';
                        break;

                    case 'airline':
                        $expectedCols = 3;
                        $stmt = $db->prepare("INSERT INTO tblairline (iata, icao, name) VALUES (?, ?, ?)");
                        $redirect = '/admin/airlines';
                        break;

                    case 'airport':
                        $expectedCols = 5;
                        $stmt = $db->prepare("INSERT INTO tblairport (iata, icao, name, city, country) VALUES (?, ?, ?, ?, ?)");
                        $redirect = '/admin/airports';
                        break;

                    default:
                        Flash::set('danger', 'Invalid table selected.');
                        header("Location: /admin");
                        exit;
                }

                // Validate header format
                if (count($header) < $expectedCols) {
                    Flash::set('danger', "CSV format error: expected {$expectedCols} columns, got " . count($header));
                    header("Location: {$redirect}");
                    exit;
                }

                // Begin transaction
                $db->beginTransaction();

                // Process rows
                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (count($row) < $expectedCols) {
                        $skipped++;
                        continue;
                    }
                    $stmt->execute(array_slice($row, 0, $expectedCols));
                    $rowCount++;
                }

                fclose($handle);

                if ($rowCount > 0) {
                    $db->commit();
                    $msg = "Import successful! {$rowCount} rows added.";
                    if ($skipped > 0) {
                        $msg .= " {$skipped} rows skipped due to invalid format.";
                        Flash::set('warning', $msg);
                    } else {
                        Flash::set('success', $msg);
                    }
                } else {
                    $db->rollBack();
                    Flash::set('warning', "No rows imported. {$skipped} rows skipped due to invalid format.");
                }

            } catch (Exception $e) {
                $db->rollBack(); // undo partial inserts
                Flash::set('danger', "Import failed: " . $e->getMessage());
            }

        } else {
            Flash::set('danger', 'Failed to open CSV file.');
        }

        header("Location: {$redirect}");
        exit;
    }
}
