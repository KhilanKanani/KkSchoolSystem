<?php
session_start();

// Only allow students to access this page
if (!isset($_SESSION["email"]) || $_SESSION["usertype"] != "student") {
    header("location:Login.php");
    exit();
}

require_once "Database.php";

$studentEmail = $_SESSION["email"];
$sql = "SELECT * FROM results WHERE email = '$studentEmail'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="bg-gray-800 text-white p-4 sm:px-8 fixed top-0 left-0 right-0 flex justify-between items-center shadow-lg z-50">
        <div class="flex items-center gap-4">
            <!-- Mobile Toggle -->
            <button id="sidebarToggle" class="sm:hidden text-white text-2xl focus:outline-none">
                ☰
            </button>
            <h1 class="font-bold lg:text-xl text-lg">Student</h1>
        </div>
              <a href="Logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg font-semibold transition">
            Logout
        </a>
    </nav>


    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-16 left-0 bottom-0 w-64 bg-white shadow-lg border-r border-gray-300 pt-8 transform -translate-x-full sm:translate-x-0 transition-transform duration-300 z-40 overflow-y-auto">

        <nav class="flex flex-col gap-3 px-6">
            <a href="Profile.php"
                class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold text-gray-700 hover:bg-lime-200 hover:text-lime-900 transition select-none">
                <i class="fas fa-user text-lg w-5"></i> My Profile
            </a>
            <a href="Course.php"
                class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold text-gray-700 hover:bg-lime-200 hover:text-lime-900 transition select-none">
                <i class="fas fa-book-open text-lg w-5"></i> My Courses
            </a>
            <a href="Result.php"
                class="flex items-center gap-3 py-3 px-4 rounded-lg font-semibold text-gray-700 hover:bg-lime-200 hover:text-lime-900 transition select-none">
                <i class="fas fa-chart-line text-lg w-5"></i> Result
            </a>
        </nav>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-30 sm:hidden"></div>

    <!-- Main content -->
    <main class="flex-grow mt-20 sm:pl-64 sm:p-6 flex flex-col items-center">

        <?php if ($result->num_rows === 0): ?>
            <div
                class="bg-white max-w-3xl w-full rounded-xl shadow-lg p-8 text-center text-gray-500 font-semibold select-none">
                No results found.
            </div>
        <?php else: ?>

            <!-- Desktop Table -->
            <div class="sm:block hidden bg-white max-w-4xl w-full rounded-xl shadow-lg p-6">
                <h2 class="text-3xl font-extrabold text-lime-700 mb-6 select-none">Your Exam Results</h2>
                <table class="w-full text-left text-sm font-light">
                    <thead class="border-b border-lime-300 bg-lime-100">
                        <tr>
                            <th class="px-4 border border-gray-300 py-3 w-48">Course</th>
                            <th class="px-4 border border-gray-300 py-3 w-28">Marks</th>
                            <th class="px-4 border border-gray-300 py-3 w-28">Grade</th>
                            <th class="px-4 border border-gray-300 py-3 max-w-lg">Exam Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-lime-50 transition">
                                <td class="px-4 py-3  border border-gray-300 font-semibold text-lime-800">
                                    <?php echo htmlspecialchars($row['course']); ?>
                                </td>
                                <td class="px-4 py-3  border border-gray-300 font-semibold text-lime-800">
                                    <?php echo htmlspecialchars($row['marks']); ?>
                                </td>
                                <td class="px-4 py-3  border border-gray-300 font-semibold text-lime-800">
                                    <?php echo htmlspecialchars($row['grade']); ?>
                                </td>
                                <td class="px-4 py-3  border border-gray-300 font-semibold text-lime-800">
                                    <?php echo htmlspecialchars($row['examdate']); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>


            <!-- Mobile Cards -->
            <div class="sm:hidden space-y-5 px-4 pb-10 w-full max-w-full mx-auto">
                <?php foreach ($result as $row): ?>
                    <div class="bg-white rounded-xl w-full shadow-2xl p-6 border-l-8 border-lime-500">
                        <div class="flex justify-between w-full items-center gap-3 mb-4">
                            <h3 class="text-xl font-extrabold text-lime-700 tracking-wide">
                                <?php echo htmlspecialchars($row['course']); ?>
                            </h3>
                            <span
                                class="inline-block bg-lime-100 text-lime-700 font-bold text-sm px-3 py-1 rounded-full shadow-md select-none">
                                Grade: <?php echo htmlspecialchars($row['grade']); ?>
                            </span>
                        </div>

                        <div class="flex flex-col gap-2 text-gray-700 font-semibold text-sm">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-bar text-lime-600"></i>
                                <span>Marks: <?php echo htmlspecialchars($row['marks']); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-lime-600"></i>
                                <span>Exam Date: <?php echo htmlspecialchars($row['examdate']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </main>


    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && !overlay.classList.contains('hidden')) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>

</html>