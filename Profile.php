<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "admin") {
    header("location:Login.php");
}

require_once "Database.php";

$mainEmail = $_SESSION["email"];
$sql = "SELECT * FROM user WHERE email= '$mainEmail'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_SESSION["email"]) && isset($_POST['apply'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobileno = $_POST['number'];
    $usertype = "student";

    $checkData = "SELECT * FROM user WHERE name='$name' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Student already exists!";
        header("location:Profile.php");
        exit();
    }


    $sql1 = "UPDATE user SET name='$name', email='$email', password='$password', mobileno='$mobileno', usertype='$usertype' WHERE email='$mainEmail'";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1) {
        $_SESSION["msg"] = "Profile Update Successfull...";
        header("location:Profile.php");
        exit();
    }
}

if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script> alert('$msg'); </script>";
    unset($_SESSION["msg"]);
}
?>



<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Update Profile</title>
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
    <main class="flex-grow pt-40 sm:pl-64 p-6 flex justify-center items-start">
        <form method="POST" class="bg-white w-full max-w-md p-8 rounded-xl shadow-xl border border-lime-300 space-y-6">

            <h2 class="text-2xl font-extrabold text-lime-700 mb-4 select-none text-center">Update Your Profile</h2>

            <input type="text" name="name" required value="<?php echo htmlspecialchars($row['name']); ?>"
                class="w-full p-3 border border-lime-400 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-400"
                placeholder="Name" />

            <input type="email" name="email" required value="<?php echo htmlspecialchars($row['email']); ?>"
                class="w-full p-3 border border-lime-400 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-400"
                placeholder="Email" />

            <input type="password" name="password" required value="<?php echo htmlspecialchars($row['password']); ?>"
                class="w-full p-3 border border-lime-400 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-400"
                placeholder="Password" />

            <input type="number" name="number" required value="<?php echo htmlspecialchars($row['mobileno']); ?>"
                class="w-full p-3 border border-lime-400 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-lime-400"
                placeholder="Mobile Number" />

            <button type="submit" name="apply"
                class="w-full py-3 bg-lime-600 hover:bg-lime-700 text-white font-bold rounded-lg transition select-none">
                Update Profile
            </button>
        </form>
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