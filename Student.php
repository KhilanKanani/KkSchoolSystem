<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "admin") {
    header("location:Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Dashboard</title>
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
    <main class="flex-grow sm:pt-20 sm:pl-64 p-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-gray-800 font-bold text-3xl mb-6 mt-20 select-none">Welcome Back, <span
                    class="text-lime-600"><?php echo $_SESSION['email']; ?></span></h2>

            <p class="text-gray-600 leading-relaxed mb-4 select-none">Here you can manage your profile, view your
                courses and check your results easily. Use the sidebar to navigate through your dashboard.</p>

            <div class="grid sm:grid-cols-3 gap-6 mt-8">
                <a href="Profile.php"
                    class="bg-lime-100 rounded-lg p-6 shadow-lg hover:shadow-xl transition cursor-pointer select-none">
                    <i class="fas fa-user-circle text-lime-600 text-4xl mb-4"></i>
                    <h3 class="text-lime-800 font-semibold text-xl mb-2">My Profile</h3>
                    <p class="text-lime-700">Update your personal information and settings.</p>
                </a>

                <a href="Course.php"
                    class="bg-lime-100 rounded-lg p-6 shadow-lg hover:shadow-xl transition cursor-pointer select-none">
                    <i class="fas fa-book-reader text-lime-600 text-4xl mb-4"></i>
                    <h3 class="text-lime-800 font-semibold text-xl mb-2">My Courses</h3>
                    <p class="text-lime-700">Browse and access your enrolled courses.</p>
                </a>

                <a href="Result.php"
                    class="bg-lime-100 rounded-lg p-6 shadow-lg hover:shadow-xl transition cursor-pointer select-none">
                    <i class="fas fa-chart-bar text-lime-600 text-4xl mb-4"></i>
                    <h3 class="text-lime-800 font-semibold text-xl mb-2">Results</h3>
                    <p class="text-lime-700">View your academic results and progress.</p>
                </a>
            </div>
        </div>
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

        // Close sidebar on click outside on mobile
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && !overlay.classList.contains('hidden')) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>

</body>

</html>