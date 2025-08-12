<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

$sql = "SELECT * FROM teacher";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Teachers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-pink-100 via-red-100 to-yellow-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="bg-gray-800 text-white p-4 sm:px-8 fixed top-0 left-0 right-0 flex justify-between items-center shadow-lg z-50">
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

    <!-- Main Content -->
    <main
        class="flex flex-col mt-15 p-6 sm:ml-56 overflow-auto min-h-[calc(100vh-3.5rem)] flex items-center justify-center">

        <h2
            class="text-center font-extrabold text-3xl mt-20 sm:mt-0 text-red-600 mb-8 select-none tracking-wide drop-shadow-md">
            All Teachers
        </h2>

        <!-- Session messages -->
        <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-center text-red-600 font-semibold mb-6 select-text px-4 sm:px-0 max-w-xl mx-auto">
                <?= htmlspecialchars($_SESSION['msg']) ?>
            </p>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['msg1'])): ?>
            <p class="text-center text-green-600 font-semibold mb-6 select-text px-4 sm:px-0 max-w-xl mx-auto">
                <?= htmlspecialchars($_SESSION['msg1']) ?>
            </p>
            <?php unset($_SESSION['msg1']); ?>
        <?php endif; ?>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto rounded-lg shadow-lg border border-gray-300 bg-white">
            <table class="min-w-full border-collapse text-gray-700">
                <thead class="bg-red-100">
                    <tr>
                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-semibold">Image</th>
                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-semibold">Name</th>
                        <th class="border border-gray-300 px-6 py-3 text-left text-sm font-semibold max-w-xl">
                            Description
                        </th>
                        <th class="border border-gray-300 px-6 py-3 text-center text-sm font-semibold">Delete</th>
                        <th class="border border-gray-300 px-6 py-3 text-center text-sm font-semibold">Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-6 py-4">
                                <img src="<?= htmlspecialchars($row['image']) ?>" alt="Teacher Image"
                                    class="w-12 h-23 rounded-lg object-cover border border-gray-300 shadow-sm mx-auto" />
                            </td>
                            <td class="border border-gray-300 px-6 py-4 font-semibold"><?= htmlspecialchars($row['name']) ?>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 max-w-xl truncate"
                                title="<?= htmlspecialchars($row['description']) ?>">
                                <?= htmlspecialchars($row['description']) ?>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 text-center">
                                <a href="DeleteTeacher.php?id=<?= $row['id'] ?>"
                                    onclick="return confirm('Are you sure you want to delete this teacher?');"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold transition select-none inline-block">
                                    Delete
                                </a>
                            </td>
                            <td class="border border-gray-300 px-6 py-4 text-center">
                                <a href="AddTeacherAdmin.php?id=<?= $row['id'] ?>"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold transition select-none inline-block">
                                    Update
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <?php mysqli_data_seek($result, 0); // Reset result pointer ?>
        <div class="lg:hidden grid grid-cols-1 gap-6">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div
                    class="bg-white rounded-xl shadow-md p-5 flex flex-col gap-4 hover:shadow-lg transition-shadow cursor-pointer">
                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="Teacher Image"
                        class="w-full h-48 rounded-lg object-cover border border-gray-300 shadow-sm" />
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($row['name']) ?></h3>
                        <p class="text-gray-600 mt-1 line-clamp-3"><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <div class="flex justify-between mt-3">
                        <a href="DeleteTeacher.php?id=<?= $row['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this teacher?');"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold transition select-none w-full text-center mr-2">
                            Delete
                        </a>
                        <a href="AddTeacherAdmin.php?id=<?= $row['id'] ?>"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold transition select-none w-full text-center ml-2">
                            Update
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </main>

    <script>
        // Sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar if clicking outside (mobile)
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>

</html>