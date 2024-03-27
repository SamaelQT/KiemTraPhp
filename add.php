<?php
require_once "db.php";

if (isset($_POST["tennv"]) && isset($_POST["phai"]) && isset($_POST["noisinh"]) && isset($_POST["maphong"]) && isset($_POST["luong"])) {
  $tennv = $_POST["tennv"];
  $phai = $_POST["phai"];
  $noisinh = $_POST["noisinh"];
  $maphong = $_POST["maphong"];
  $luong = $_POST["luong"];

  // Thêm dữ liệu vào bảng `nhanvien`
  $sql = "INSERT INTO nhanvien (Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $tennv, $phai, $noisinh, $maphong, $luong);
  $stmt->execute();

  // Xử lý kết quả
  if ($stmt->affected_rows === 1) {
    echo "Thêm nhân viên thành công!";
  } else {
    echo "Thêm nhân viên thất bại!";
  }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm nhân viên</title>
</head>
<body>
  <h1>Thêm nhân viên</h1>
  <form action="themnhanvien.php" method="post">
    <label for="tennv">Tên nhân viên:</label>
    <input type="text" id="tennv" name="tennv" required>
    <br>
    <label for="phai">Phái:</label>
    <select id="phai" name="phai" required>
      <option value="">Chọn giới tính</option>
      <option value="Nam">Nam</option>
      <option value="Nữ">Nữ</option>
    </select>
    <br>
    <label for="noisinh">Nơi sinh:</label>
    <input type="text" id="noisinh" name="noisinh" required>
    <br>
    <label for="maphong">Mã phòng:</label>
    <input type="text" id="maphong" name="maphong" required>
    <br>
    <label for="luong">Lương:</label>
    <input type="number" id="luong" name="luong" required>
    <br>
    <button type="submit">Thêm nhân viên</button>
  </form>
</body>
</html>
