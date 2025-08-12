<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

// Fetch existing student data if updating
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM user WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

// Add Student
if (isset($_POST["apply"]) && !isset($_GET['id'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $mobileno = $_POST["number"];
    $usertype = "student";

    $checkData = "SELECT * FROM user WHERE name='$name' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Student already exists!";
        header("location:AddStudentAdmin.php");
        exit();
    }

    $sql = "INSERT INTO user(name, email, password, mobileno, usertype) 
            VALUES('$name', '$email', '$password', '$mobileno', '$usertype')";
    $result = mysqli_query($conn, $sql);

    $_SESSION["msg"] = $result ? "Student Added Successfully!" : "Failed to Add Student!";
    header("location:AddStudentAdmin.php");
    exit();
}

// Update Student
if (isset($_POST["apply"]) && isset($_GET["id"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $mobileno = $_POST["number"];
    $usertype = "student";

    $sql = "UPDATE user SET name='$name', email='$email', password='$password', 
            mobileno='$mobileno', usertype='$usertype' WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $_SESSION["msg1"] = $result ? "Student Updated Successfully!" : "Failed to Update Student!";
    header("location:ViewStudentAdmin.php");
    exit();
}

if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script> alert('$msg'); </script>";
    unset($_SESSION["msg"]);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($_GET['id']) ? 'Update Student' : 'Add Student'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

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

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 hidden z-30 sm:hidden"></div>

    <!-- Main Content -->
    <main
        class="flex-grow mt-14 p-6 sm:ml-56 overflow-auto min-h-[calc(100vh-3.5rem)] flex items-center justify-center">

        <section
            class="bg-white max-w-md w-full rounded-xl shadow-lg lg:p-8 p-3 border border-purple-200 flex flex-col gap-6">

            <h1 class="text-3xl font-semibold text-purple-700 text-center select-none">
                <?php echo isset($_GET['id']) ? "Update Student" : "Add New Student"; ?>
            </h1>

            <form method="POST" class="flex flex-col gap-4" >

                <label class="block">
                    <span class="text-sm font-medium text-purple-700 mb-1 block select-none">Full Name</span>
                    <input type="text" name="name"
                        value="<?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?>"
                        placeholder="Enter full name" class="w-full rounded-md border border-purple-300 bg-purple-50 px-3 py-2 text-base
                               text-purple-900 placeholder-purple-400
                               focus:outline-none focus:ring-2 focus:ring-purple-400
                               transition duration-200" required />
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-purple-700 mb-1 block select-none">Email Address</span>
                    <input type="email" name="email"
                        value="<?php echo isset($row['email']) ? htmlspecialchars($row['email']) : ''; ?>"
                        placeholder="Enter email address" class="w-full rounded-md border border-purple-300 bg-purple-50 px-3 py-2 text-base
                               text-purple-900 placeholder-purple-400
                               focus:outline-none focus:ring-2 focus:ring-purple-400
                               transition duration-200" required />
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-purple-700 mb-1 block select-none">Password</span>
                    <input type="password" name="password"
                        value="<?php echo isset($row['password']) ? htmlspecialchars($row['password']) : ''; ?>"
                        placeholder="Enter password" class="w-full rounded-md border border-purple-300 bg-purple-50 px-3 py-2 text-base
                               text-purple-900 placeholder-purple-400
                               focus:outline-none focus:ring-2 focus:ring-purple-400
                               transition duration-200" required />
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-purple-700 mb-1 block select-none">Mobile Number</span>
                    <input type="tel" name="number"
                        value="<?php echo isset($row['mobileno']) ? htmlspecialchars($row['mobileno']) : ''; ?>"
                        placeholder="Enter mobile number" class="w-full rounded-md border border-purple-300 bg-purple-50 px-3 py-2 text-base
                               text-purple-900 placeholder-purple-400
                               focus:outline-none focus:ring-2 focus:ring-purple-400
                               transition duration-200" required pattern="[0-9]{10,15}" />
                </label>

                <button type="submit" name="apply" class="w-full bg-gradient-to-r from-purple-600 to-pink-600
                           text-white font-semibold py-3 rounded-md shadow-sm
                           hover:from-purple-700 hover:to-pink-700 active:scale-95
                           transition transform select-none">
                    <?php echo isset($_GET['id']) ? "Update Student" : "Add Student"; ?>
                </button>

            </form>

        </section>
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

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
    </script>

</body>

</html>