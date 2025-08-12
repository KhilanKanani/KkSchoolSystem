<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

$sql = "SELECT * FROM user WHERE usertype='student'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }
    </script>
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
            <a href="AddStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add
                Student</a>
            <a href="ViewStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View
                Student</a>
            <a href="AddTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add
                Teacher</a>
            <a href="ViewTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View
                Teacher</a>
            <a href="AddCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Course</a>
            <a href="ViewCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View
                Courses</a>
        </div>
    </div>

    <!-- Page Content -->
    <div class="pt-20 px-4 md:px-8 lg:px-15 sm:ml-64 ">

        <div class="bg-white rounded-lg shadow-lg p-6 overflow-x-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">All Students</h2>

            <!-- Messages -->
            <?php if (isset($_SESSION['msg'])): ?>
                <p class="font-semibold text-red-500 mb-3"><?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION['msg1'])): ?>
                <p class="font-semibold text-green-500 mb-3"><?php echo $_SESSION['msg1'];
                unset($_SESSION['msg1']); ?></p>
            <?php endif; ?>

            <!-- Table -->
            <table class="w-full border border-gray-300 rounded-lg overflow-hidden hidden lg:table">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Password</th>
                        <th class="px-4 py-3 text-left">Mobile No.</th>
                        <th class="px-4 py-3 text-center">Delete</th>
                        <th class="px-4 py-3 text-center">Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b hover:bg-gray-100 transition">
                            <td class="px-4 py-3"><?php echo $row['name']; ?></td>
                            <td class="px-4 py-3"><?php echo $row['email']; ?></td>
                            <td class="px-4 py-3"><?php echo $row['password']; ?></td>
                            <td class="px-4 py-3"><?php echo $row['mobileno']; ?></td>
                            <td class="px-4 py-3 text-center">
                                <a href="DeleteStudent.php?id=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Are You Sure You Want to Delete This Student?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-semibold">
                                    Delete
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="AddStudentAdmin.php?id=<?php echo $row['id']; ?>"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-semibold">
                                    Update
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Mobile Cards -->
            <div class="lg:hidden mt-6 space-y-4">
                <?php mysqli_data_seek($result, 0); ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-gray-50 p-4 rounded-lg shadow border">
                        <p><span class="font-semibold">Name:</span> <?php echo $row['name']; ?></p>
                        <p><span class="font-semibold">Email:</span> <?php echo $row['email']; ?></p>
                        <p><span class="font-semibold">Password:</span> <?php echo $row['password']; ?></p>
                        <p><span class="font-semibold">Mobile No.:</span> <?php echo $row['mobileno']; ?></p>
                        <div class="flex gap-3 mt-3">
                            <a href="DeleteStudent.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Are You Sure You Want to Delete This Student?')"
                                class="flex-1 bg-red-500 hover:bg-red-600 text-white text-center px-3 py-2 rounded-md text-sm font-semibold">
                                Delete
                            </a>
                            <a href="AddStudentAdmin.php?id=<?php echo $row['id']; ?>"
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center px-3 py-2 rounded-md text-sm font-semibold">
                                Update
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
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