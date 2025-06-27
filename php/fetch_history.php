<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
http_response_code(401);
echo json_encode(["error" => "Not logged in"]);
exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT
    bh.height,
    bh.weight,
    bh.bmi,
    bh.status,
    bh.created_at,
    SUBSTRING_INDEX(SUBSTRING_INDEX(r.content, '|', 1), ':', -1) AS food,
    SUBSTRING_INDEX(r.content, ':', -1) AS exercise
FROM
    bmi_history bh
LEFT JOIN
    recommendations r ON r.bmi_history_id = bh.id
WHERE
    bh.user_id = ?
ORDER BY
    bh.created_at DESC

";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
$history[] = [
'height' => $row['height'],
'weight' => $row['weight'],
'bmi' => $row['bmi'],
'status' => $row['status'],
'created_at' => $row['created_at'],
'food' => trim($row['food']),
'exercise' => trim($row['exercise'])
];
}

header('Content-Type: application/json');
echo json_encode($history);
?>