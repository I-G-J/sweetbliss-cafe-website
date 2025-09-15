
<?php
include "db.php";
header('Content-Type: application/json');

$result = $conn->query("SELECT cake_id, cake_name, description, image, price FROM cakes");
$cakes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cakes[] = [
            'id' => $row['cake_id'],
            'title' => $row['cake_name'],
            'desc' => $row['description'],
            'img' => $row['image'],
            'cat' => 'cake', // or set category if you have one
            'price' => (float)$row['price']
        ];
    }
}
$conn->close();
echo json_encode($cakes);