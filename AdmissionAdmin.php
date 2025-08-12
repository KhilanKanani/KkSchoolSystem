<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

$sql = "SELECT * FROM admission";
$result = mysqli_query($conn, $sql);

if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    echo "<script> alert('$msg'); </script>";
    unset($_SESSION["msg"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied For Admission</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 sm:px-8 fixed top-0 left-0 right-0 flex justify-between items-center shadow-lg z-50">
        <div class="flex items-center gap-4">
            <!-- Mobile Toggle -->
            <button id="sidebarToggle" class="sm:hidden text-white text-2xl focus:outline-none">
                ☰
            </button>
            <h1 class="font-bold lg:text-xl text-lg">Admin</h1>
        </div>
                <a href="Logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg font-semibold transition">
            Logout
        </a>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar"
        class="bg-white shadow-lg fixed top-16 left-0 h-full w-64 transform -translate-x-full sm:translate-x-0 transition-transform duration-300 z-40">
        <div class="flex flex-col p-4 gap-2">
            <a href="AdmissionAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Admission</a>
            <a href="AddStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Student</a>
            <a href="ViewStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Student</a>
            <a href="AddTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Teacher</a>
            <a href="ViewTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Teacher</a>
            <a href="AddCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Course</a>
            <a href="ViewCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Courses</a>
        </div>
    </div>

    <div class="sm:ml-64 mt-16 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <h2 class="lg:text-2xl text-xl text-center font-bold mb-4">Applied For Admission</h2>

            <!-- Desktop Table -->
            <table class="min-w-full border border-gray-300 text-left hidden lg:table">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Password</th>
                        <th class="border px-4 py-2">Mobile No.</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2"><?php echo $row['name']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['email']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['password']; ?></td>
                            <td class="border px-4 py-2"><?php echo $row['mobileno']; ?></td>
                            <td class="border px-4 py-2 text-center">
                                <a href="ConfirmAdmission.php?id=<?php echo $row['id'] ?>"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition">
                                    Confirm
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Mobile Card View -->
            <div class="space-y-4 lg:hidden">
                <?php mysqli_data_seek($result, 0); // reset pointer for mobile view ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="border rounded-lg shadow-sm p-4 bg-white">
                        <p class="font-bold text-lg"><?php echo $row['name']; ?></p>
                        <p class="text-gray-600"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                        <p class="text-gray-600"><strong>Password:</strong> <?php echo $row['password']; ?></p>
                        <p class="text-gray-600"><strong>Mobile:</strong> <?php echo $row['mobileno']; ?></p>
                        <div class="mt-3">
                            <a href="ConfirmAdmission.php?id=<?php echo $row['id'] ?>"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm transition">
                                Confirm
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <!-- JS for Sidebar Toggle -->
    <script>
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebar = document.getElementById("sidebar");

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
        });
    </script>
</body>

</html>