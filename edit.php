<?php
require_once "db.php";

$ma_nv = isset($_GET['Ma_NV']) ? $_GET['Ma_NV'] : null;
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ma_nv = $_POST['Ma_NV'];
    $tennv = $_POST['tennv'];
    $phai = $_POST['phai'];
    $noisinh = $_POST['noisinh'];
    $maphong = $_POST['maphong'];
    $luong = $_POST['luong'];
    if (empty($tennv) || empty($phai) || empty($noisinh) || empty($maphong) || !is_numeric($luong)) {
        $errorMessage = "Vui lòng nhập đầy đủ thông tin nhân viên!";
    }

    // Cập nhật thông tin nhân viên
    if (empty($errorMessage)) {
        $sql = "UPDATE nhanvien SET Ten_NV = ?, Phai = ?, Noi_Sinh = ?, Ma_Phong = ?, Luong = ? WHERE Ma_NV = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $tennv, $phai, $noisinh, $maphong, $luong, $ma_nv);

        if ($stmt->execute()) {
            echo "Cập nhật nhân viên thành công!";
        } else {
            $errorMessage = "Cập nhật nhân viên thất bại!";
        }

        $stmt->close();
    }
} else if ($ma_nv !== null) {
    $sql = "SELECT * FROM nhanvien WHERE Ma_NV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_nv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    } else {
        $errorMessage = "Không tìm thấy nhân viên!";
        exit;
    }

    $stmt->close();
} else {
    echo "Không có Ma_NV được cung cấp!";
    exit;
}


$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>
</head>

<body>
    <h1>Sửa thông tin nhân viên</h1>
    <?php if (!empty($errorMessage)) { ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php } ?>
    <form action="suanhanvien.php?Ma_NV=<?php echo $row['Ma_NV']; ?>" method="post">
        <label for="tennv">Tên nhân viên:</label>
        <input type="text" id="tennv" name="tennv" value="<?php echo $row['Ten_NV']; ?>" required>
        <br