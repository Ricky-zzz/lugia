<?php
function getAll($table) {
    global $conn;
    $sql = "SELECT * FROM $table";
    return $conn->query($sql);
}

function search($table, $conditions = []) {
    global $conn;

    if (empty($conditions)) {
        return getAll($table);
    }

    $where = [];
    foreach ($conditions as $col => $val) {
        $where[] = "$col = '" . $conn->real_escape_string($val) . "'";
    }
    $sql = "SELECT * FROM $table WHERE " . implode(" AND ", $where);
    return $conn->query($sql);
}
