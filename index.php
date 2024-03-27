<?php
include "db.php";

$employees_per_page = 5;

$total_employees = $conn->query("SELECT COUNT(*) FROM nhanvien")->fetch_assoc()["COUNT(*)"];
$num_pages = ceil($total_employees / $employees_per_page);

$page = 1;
if (isset($_GET["page"])) {
    $page = (int)$_GET["page"];
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $num_pages) {
        $page = $num_pages;
    }
}

if ($page === 1) {
    $offset = 0;
} else {
    $offset = ($page - 1) * $employees_per_page;
}

$sql = "SELECT nhanvien.*, phongban.Ten_Phong 
FROM nhanvien 
INNER JOIN phongban ON nhanvien.Ma_Phong = phongban.Ma_Phong
LIMIT $offset, $employees_per_page";

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Nhân viên</title>
    <link rel="stylesheet" href="style.css">
</head>


<body>
    <header>
        <h1>THÔNG TIN NHÂN VIÊN</h1>
        <div class="add-employee">
            <a href="add.php">THÊM NHÂN VIÊN</a>
        </div>
    </header>
    <section class="container">
        <table>
            <thead>
                <tr>
                    <th>Mã Nhân Viên</th>
                    <th>Tên Nhân Viên</th>
                    <th>Giới tính</th>
                    <th>Nơi Sinh</th>
                    <th>Tên Phòng</th>
                    <th>Lương</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $row["Ma_NV"]; ?></td>
                        <td><?php echo $row["Ten_NV"]; ?></td>
                        <td>
                            <?php
                            if ($row["Phai"] === "NU") {
                                echo "<img src='woman.jpg' alt='Nữ'>";
                            } else {
                                echo "<img src='man.jpg' alt='Nam'>";
                            }
                            ?>
                        </td>
                        <td><?php echo $row["Noi_Sinh"]; ?></td>
                        <td><?php echo $row["Ten_Phong"]; ?></td>
                        <td><?php echo $row["Luong"]; ?></td>
                        <td>
                            <a href="edit.php?id=1">Chỉnh sửa</a>
                            <a href="delete.php?id=1">Xóa</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php
            if ($num_pages > 1) {
                if ($page > 1) {
                    echo "<a href='index.php?page=" . ($page - 1) . "'>Trang trước</a> ";
                }

                for ($i = 1; $i <= $num_pages; $i++) {
                    $active_class = ($i == $page) ? "active" : "";
                    echo "<a href='index.php?page=$i' class='$active_class'>Trang $i</a> ";
                }

                if ($page < $num_pages) {
                    echo "<a href='index.php?page=" . ($page + 1) . "'>Trang sau</a>";
                }
            }
            ?>
        </div>
    </section>
</body>

</html>

<?php
$conn->close();
?>