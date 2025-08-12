<?php
error_reporting(0);
session_start();

if (isset($_SESSION["msg"])) {
    $message = $_SESSION["msg"];
    echo "<script> alert('$message'); </script>";
    unset($_SESSION["msg"]);
}

require_once "Database.php";

$sql = "SELECT * FROM teacher";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM course";
$result1 = mysqli_query($conn, $sql1);

session_destroy();
?>

<!-------------------------------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <!-- Tailwind Css -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-b from-gray-50 to-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav
        class="bg-white/90 backdrop-blur-md shadow-lg fixed top-0 left-0 right-0 z-50 px-6 py-4 flex justify-between items-center">
        <label class="font-extrabold text-3xl tracking-wide text-gray-900">Kk's</label>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex gap-6">
            <li><a href="#" class="hover:text-blue-500 transition font-medium">Home</a></li>
            <li><a href="ContactUs.php" class="hover:text-blue-500 transition font-medium">Contact</a></li>
            <li><a href="#admission" class="hover:text-blue-500 transition font-medium">Admission</a></li>
            <li>
                <a href="Login.php"
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                    Login
                </a>
            </li>
        </ul>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn"
            class="md:hidden px-4 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
            ☰
        </button>
    </nav>

    <!-- Overlay -->
    <div id="overlay"
        class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-40 transition-opacity duration-300 md:hidden">
    </div>

    <!-- Sidebar Drawer -->
    <aside id="mobileSidebar"
        class="fixed top-0 left-[-280px] h-full w-72 bg-white shadow-2xl z-50 flex flex-col transform transition-all duration-300 ease-in-out md:hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-300">
            <h2 class="text-3xl font-extrabold text-blue-600 select-none">Kk's</h2>
            <button id="closeSidebar"
                class="text-3xl font-bold text-gray-600 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                aria-label="Close menu">&times;</button>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col px-6 py-8 gap-6 text-gray-700 text-lg font-semibold select-none">

            <a href="#" class="flex items-center gap-3 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                </svg>
                Home
            </a>

            <a href="ContactUs.php" class="flex items-center gap-3 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 10a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 14.25a2.25 2.25 0 11-3.5-2.5" />
                </svg>
                Contact
            </a>

            <a href="#admission" class="flex items-center gap-3 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.1 0-2 .9-2 2v4h4v-4a2 2 0 00-2-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 18v-6a4 4 0 00-8 0v6" />
                </svg>
                Admission
            </a>

            <a href="Login.php"
                class="mt-auto px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-center font-bold hover:scale-105 transition shadow-lg select-none">
                Login
            </a>
        </nav>
    </aside>

    <!-- Hero Section -->
    <section class="relative mt-16 md:mt-20">
        <img src="./Public/class.webp"
            class="w-full h-[250px] sm:h-[350px] md:h-[500px] object-cover rounded-b-3xl shadow-lg" alt="Class Image">
        <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-b-3xl">
            <h1 class="text-white text-xl sm:text-4xl md:text-5xl font-extrabold drop-shadow-lg px-3 text-center">
                We Teach Students With Care
            </h1>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="max-w-6xl mx-auto py-10 px-5 grid md:grid-cols-2 gap-8 items-center">
        <img src="./Public/school.png" class="rounded-xl shadow-lg hover:scale-105 transition w-full"
            alt="School Image">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold mb-3">Welcome To Kk's School</h2>
            <p class="leading-relaxed text-gray-700 text-sm sm:text-base">
                MEMS has been committed to global learning long before it became an indispensable feature of
                contemporary
                education. Established in 2025, we proudly stand as the 1st English medium school in Kp Bhavan to adopt
                both Pearson Edexcel and Cambridge curriculum (in O and A levels), drawing together students in a
                vibrant, academically challenging, and encouraging environment where manifold viewpoints are prized and
                celebrated.
            </p>
        </div>
    </section>

    <!-- Our Teacher -->
    <section class="bg-white py-10">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-center mb-8">Our Teachers</h2>
        <div class="flex flex-wrap gap-6 justify-center px-4">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div
                    class="w-full sm:w-[45%] md:w-[30%] bg-gradient-to-b from-white to-gray-50 rounded-xl shadow-xl hover:shadow-2xl transition transform hover:scale-105 p-5">
                    <img src="<?php echo $row['image'] ?>" class="h-48 sm:h-60 w-full object-cover rounded-lg mb-4">
                    <h3 class="font-bold text-lg sm:text-xl mb-2"><?php echo $row['name'] ?></h3>
                    <p class="text-gray-600 text-sm sm:text-base"><?php echo $row['description'] ?></p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Our Courses -->
    <section class="bg-gray-50 py-10">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-center mb-8">Our Courses</h2>
        <div class="flex flex-wrap gap-6 justify-center px-4">
            <?php while ($row = mysqli_fetch_assoc($result1)) { ?>
                <div
                    class="w-full sm:w-[45%] md:w-[30%] bg-gradient-to-b from-white to-gray-50 rounded-xl shadow-xl hover:shadow-2xl transition transform hover:scale-105 p-5">
                    <img src="<?php echo $row['image'] ?>" class="h-48 sm:h-60 w-full object-cover rounded-lg mb-4">
                    <h3 class="font-bold text-lg sm:text-xl mb-2"><?php echo $row['name'] ?></h3>
                    <p class="text-gray-600 text-sm sm:text-base"><?php echo $row['description'] ?></p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Admission Form -->
    <section id="admission" class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-2xl sm:text-4xl font-extrabold text-center mb-8">Admission Form</h2>
        <form action="AdmissinDataCheck.php" method="POST" class="bg-white rounded-xl shadow-lg p-6 sm:p-8 space-y-4">
            <input type="text" name="name" placeholder="Name..." required
                class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none">
            <input type="email" name="email" placeholder="Email..." required
                class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none">
            <input type="password" name="password" placeholder="Password..." required
                class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none">
            <input type="number" name="number" placeholder="Mobile Number..." required
                class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 outline-none">
            <button name="apply" value="apply" type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 rounded-lg font-semibold shadow hover:scale-105 transition">
                Apply Now
            </button>
        </form>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-5 text-center text-sm sm:text-base">
        &copy; 2025 Kk's Pvt Ltd. All Rights Reserved.
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            mobileSidebar.style.left = '0';
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.style.opacity = '1';
            }, 10);
            document.body.style.overflow = 'hidden'; // prevent background scroll
        }

        function closeSidebarFunc() {
            mobileSidebar.style.left = '-280px';
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
            document.body.style.overflow = ''; // restore scroll
        }

        mobileMenuBtn.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', closeSidebarFunc);
        overlay.addEventListener('click', closeSidebarFunc);

        // Close sidebar when clicking any sidebar nav link
        const sidebarLinks = mobileSidebar.querySelectorAll('nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', closeSidebarFunc);
        });
    </script>


</body>

</html>