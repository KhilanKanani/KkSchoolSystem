<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "admin") {
    header("location:Login.php");
    exit();
}

require_once "Database.php";

$sql = "SELECT * FROM course";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>View Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

</head>

<body class="bg-lime-50 min-h-screen flex flex-col">

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

    <!-- Overlay for Mobile when sidebar is open -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 hidden z-30 sm:hidden"></div>

    <main
        class="flex flex-col mt-15 p-6 sm:ml-56 overflow-auto min-h-[calc(100vh-3.5rem)] flex items-center justify-center">

        <h1 class="text-center text-lime-700 font-extrabold text-3xl mb-6 mt-20 sm:mt-0 select-none">All Courses</h1>

        <?php if (isset($_SESSION['msg'])): ?>
            <p class="text-red-600 font-semibold mb-4 text-center select-none">
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_SESSION['msg1'])): ?>
            <p class="text-green-600 font-semibold mb-4 text-center select-none">
                <?php echo $_SESSION['msg1'];
                unset($_SESSION['msg1']); ?>
            </p>
        <?php endif; ?>

        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto rounded-lg shadow-lg border border-gray-300 bg-white">
            <table class="min-w-full text-left font-light">
                <thead class="border-b border-lime-300 bg-lime-100">
                    <tr>
                        <th class="px-4 border border-gray-300 py-3 w-20">Image</th>
                        <th class="px-4 border border-gray-300 py-3 w-40">Name</th>
                        <th class="px-4 border border-gray-300 py-3 max-w-lg">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php mysqli_data_seek($result, 0); // Reset pointer for table ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b hover:bg-lime-50 transition">
                            <td class="px-4 py-3">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Course Image"
                                    class="w-12 h-12 object-cover rounded-md border border-lime-300" />
                            </td>
                            <td class="px-4 py-3 border border-gray-300 font-semibold text-lime-800">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td class="px-4 py-3 border border-gray-300 max-w-xl truncate"
                                title="<?php echo htmlspecialchars($row['description']); ?>">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="space-y-4 lg:hidden">
            <?php mysqli_data_seek($result, 0); // Reset pointer for cards ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col gap-3 border border-lime-300">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Course Image"
                        class="w-full h-48 object-cover rounded-md" />
                    <h2 class="text-lime-800 font-bold text-xl truncate"><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p class="text-gray-700 text-sm max-h-24 overflow-hidden">
                        <?php echo htmlspecialchars($row['description']); ?>
                    </p>
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