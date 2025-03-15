// name AHmed hamdy
// id : 230103760

<?php
#1
// $attr = "mysql:host=localhost;dbname=testdb;charset=utf8mb4";
// $username = "root";
// $password = "pass";

// try {
//     $pdo = new PDO($attr, $username, $password, [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//     ]);

//     $stmt = $pdo->query("SELECT id, name, email FROM users");

//     //for one row
//     $row = $stmt->fetch();
//     echo "your name:" . $row['name'] . "<br>";

//     // for all rows
//     $allRows = $stmt->fetchAll();
//     foreach ($allRows as $row) {
//         echo $row['name'] . " - " . $row['email'] . "<br>";
//     }

//     // for first data of first row
//     $stmt = $pdo->query("SELECT COUNT(*) FROM users");
//     $userCount = $stmt->fetchColumn();
//     echo "users count" . $userCount;

// } catch (PDOException $e) {
//     die("Connection failed" . $e->getMessage());
// }


#2
$dsn = "mysql:host=localhost;dbname=testdb;charset=utf8mb4";
$username = "root";
$password = "pass";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// number of row of page
$rowsPerPage = 20;


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $rowsPerPage;

$stmt = $pdo->prepare("SELECT id, name, email FROM users LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $rowsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

$totalRows = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalPages = ceil($totalRows / $rowsPerPage);

?>
