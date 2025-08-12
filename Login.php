<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-cover bg-center flex flex-col" style="background-image: url('./Public/graphic.jpg');">

    <!-- Navbar -->
    <nav class="bg-white/70 backdrop-blur-md shadow-md p-4 px-8 fixed w-full flex justify-between items-center z-20">
        <h1 class="text-3xl font-extrabold tracking-wide text-pink-600 drop-shadow-lg">Kk's</h1>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center space-x-6">
            <li><a href="Index.php" class="font-semibold hover:text-pink-500 transition">Home</a></li>
            <li><a href="ContactUs.php" class="font-semibold hover:text-pink-500 transition">Contact</a></li>
            <li><a href="Index.php#admission" class="font-semibold hover:text-pink-500 transition">Admission</a></li>
            <li>
                <a href="Login.php"
                    class="font-semibold px-4 py-2 rounded-lg bg-pink-500 text-white hover:bg-pink-600 transition">
                    Login
                </a>
            </li>
        </ul>

        <!-- Mobile Menu Button -->
        <button id="menu-btn" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-pink-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    <!-- Mobile Sidebar -->
    <div id="mobile-menu"
        class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-30">
        <div class="p-4 border-b">
            <h2 class="text-3xl font-bold text-pink-600">Kk's</h2>
        </div>
        <nav class="p-4 space-y-4">
            <a href="Index.php" class="block font-semibold hover:text-pink-500">Home</a>
            <a href="ContactUs.php" class="block font-semibold hover:text-pink-500">Contact</a>
            <a href="Index.php#admission" class="block font-semibold hover:text-pink-500">Admission</a>
            <a href="Login.php"
                class="block px-4 py-2 rounded-lg bg-pink-500 text-white font-semibold hover:bg-pink-600 text-center">
                Login
            </a>
        </nav>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-20"></div>

    <!-- Login Form -->
    <div class="flex flex-1 justify-center items-center px-4 sm:px-6 lg:px-8 pt-20">
        <form action="LoginCheck.php" method="POST"
            class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl p-8 w-full max-w-md transition hover:shadow-pink-400">

            <h2 class="text-center text-2xl sm:text-3xl font-bold text-pink-600 mb-6">Welcome Back 👋</h2>

            <div class="space-y-5">
                <input type="email" name="email" placeholder="Email..."
                    class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-gray-50"
                    required>

                <input type="password" name="password" placeholder="Password..."
                    class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-gray-50"
                    required>

                <button type="submit"
                    class="w-full py-3 bg-pink-500 text-white rounded-lg font-semibold hover:bg-pink-600 transition transform hover:scale-[1.02] shadow-lg">
                    Login
                </button>
            </div>

            <!-- Error Message -->
            <h3 class="text-red-500 font-semibold text-center mt-4">
                <?php
                error_reporting(0);
                session_start();
                session_destroy();
                $msg = $_SESSION["LoginMessage"];
                echo $msg;
                ?>
            </h3>
        </form>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('overlay');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            mobileMenu.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        });
    </script>
</body>

</html>