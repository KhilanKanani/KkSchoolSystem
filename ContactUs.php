<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $_SESSION["msg"] = "Thank you, $name! Your message has been sent.";
    header("Location: ContactUs.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="bg-gray-900/90 backdrop-blur-md p-4 px-6 fixed w-full top-0 left-0 z-50 shadow-lg flex justify-between items-center">
        <label class="font-extrabold text-3xl tracking-wide text-blue-400 drop-shadow-lg">Kk's</label>

        <ul class="hidden md:flex space-x-6">
            <li><a href="Index.php" class="hover:text-blue-400 transition">Home</a></li>
            <li><a href="" class="hover:text-blue-400 transition">Contact</a></li>
            <li><a href="Index.php#admission" class="hover:text-blue-400 transition">Admission</a></li>
            <li>
                <a href="Login.php"
                    class="px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 font-semibold transition">Login</a>
            </li>
        </ul>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="md:hidden text-3xl focus:outline-none" aria-label="Open menu">
            ☰
        </button>
    </nav>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-40 md:hidden"></div>

    <!-- Sidebar drawer (from right) -->
    <aside id="mobileSidebar"
        class="fixed top-0 right-[-280px] h-full w-72 bg-gray-900/95 backdrop-blur-lg shadow-xl z-50 flex flex-col transition-all duration-300 ease-in-out md:hidden">
        <div class="flex justify-between items-center p-4 border-b border-gray-700">
        <h2></h2>    
        <button id="closeSidebar" class="text-3xl text-gray-400 hover:text-white focus:outline-none"
                aria-label="Close menu">
                &times;
            </button>
        </div>
        <nav class="flex flex-col p-4 space-y-5 text-lg">
            <a href="Index.php" class="hover:text-blue-400 transition">Home</a>
            <a href="" class="hover:text-blue-400 transition">Contact</a>
            <a href="Index.php#admission" class="hover:text-blue-400 transition">Admission</a>
            <a href="Login.php"
                class="bg-blue-500 hover:bg-blue-600 text-center px-4 py-2 rounded-lg font-semibold transition">Login</a>
        </nav>
    </aside>

    <!-- Contact Section -->
    <main class="flex-1 flex justify-center items-center px-4 pt-20">
        <div class="bg-gray-800/90 backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-700">
            <h1 class="text-4xl font-bold text-center mb-6 text-blue-400">Contact Us</h1>

            <?php if (isset($_SESSION["msg"])): ?>
                <p class="bg-green-500/20 border border-green-400 text-green-300 text-center py-2 rounded-lg mb-4">
                    <?= $_SESSION["msg"];
                    unset($_SESSION["msg"]); ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-5">
                <div>
                    <label class="block mb-1 font-semibold">Your Name</label>
                    <input type="text" name="name" placeholder="Kk's" required
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Your Email</label>
                    <input type="email" name="email" placeholder="example@mail.com" required
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">Message</label>
                    <textarea name="message" rows="5" placeholder="Write your message here..." required
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 py-3 rounded-lg font-bold text-lg transition cursor-pointer">
                    Send Message
                </button>
            </form>
        </div>
    </main>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        function openSidebar() {
            mobileSidebar.style.left = '0';
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }

        function closeSidebarFunc() {
            mobileSidebar.style.left = '-280px';
            overlay.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scroll
        }

        mobileMenuBtn.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', closeSidebarFunc);
        overlay.addEventListener('click', closeSidebarFunc);
    </script>
</body>

</html>