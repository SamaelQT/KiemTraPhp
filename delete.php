<?php
require_once "db.php";

if (isset($_GET["manv"])) {
  $manv = $_GET["manv"];
  $sql = "DELETE FROM nhanvien WHERE Ma_NV = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $manv);
  $stmt->execute();

  if ($stmt->affected_rows === 1) {
    echo "Xóa nhân viên thành công!";
  } else {
    echo "Xóa nhân viên thất bại!";
  }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xóa nhân viên</title>
</head>
<body>
  
