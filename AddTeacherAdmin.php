<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM teacher WHERE id=$id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

// Add Teacher
if (isset($_POST["apply"]) && !isset($_GET['id'])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $image = $_FILES["image"]['name'];
    $dst_Db = "Public/" . basename($image);

    move_uploaded_file($_FILES["image"]['tmp_name'], $dst_Db);

    $checkData = "SELECT * FROM teacher WHERE name='$name'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Teacher Is Already Exist. Try Another One.. ";
        header("location:AddTeacherAdmin.php");
        exit();
    }

    $sql = "INSERT INTO teacher(image, name, description) VALUES('$dst_Db', '$name', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Data Upload Successfull...";
        header("location:AddTeacherAdmin.php");

    } else {
        $_SESSION["msg"] = "Data Upload Failed...";
        header("location:AddTeacherAdmin.php");
    }
    exit();
}
// Update Teacher 
else if (isset($_POST["apply"]) && isset($_GET["id"])) {
    $id = $_GET["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];

    if (!empty($_FILES["image"]["name"])) {
        // New image uploaded
        $image = $_FILES["image"]['name'];
        $dst_Db = "Public/" . basename($image);
        move_uploaded_file($_FILES["image"]['tmp_name'], $dst_Db);
    } else {
        // Keep old image
        $dst_Db = mysqli_real_escape_string($conn, $row['image']);
    }

    $sql = "UPDATE teacher SET image='$dst_Db', name='$name', description='$description' WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg1"] = "Data Update Is Successful...";
        header("location:ViewTeacherAdmin.php");
    } else {
        $_SESSION["msg1"] = "Data Update Failed...";
        header("location:ViewTeacherAdmin.php");
    }
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
    <title><?php echo !isset($_GET['id']) ? "Add Teacher" : "Update Teacher"; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-pink-100 via-red-100 to-yellow-100 min-h-screen flex flex-col">

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
            <a href="AddStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Student</a>
            <a href="ViewStudentAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Student</a>
            <a href="AddTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Teacher</a>
            <a href="ViewTeacherAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Teacher</a>
            <a href="AddCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">Add Course</a>
            <a href="ViewCourseAdmin.php" class="font-semibold hover:bg-gray-200 px-4 py-3 rounded-lg">View Courses</a>
        </div>
    </div>

    <!-- Main content -->
    <main class="flex-grow mt-14 p-6 sm:ml-56 overflow-auto min-h-[calc(100vh-3.5rem)] flex items-center justify-center">
        <form method="POST" enctype="multipart/form-data"
            class="bg-white rounded-lg shadow-md lg:p-6 p-3  w-full max-w-md space-y-4 border-2 border-red-300"
            id="teacherForm">

            <h2 class="text-2xl font-semibold text-center text-red-600 select-none">
                <?php echo !isset($_GET['id']) ? "Add New Teacher" : "Update Teacher"; ?>
            </h2>

            <label class="block">
                <span class="text-sm font-medium text-gray-700">Teacher Name</span>
                <input type="text" name="name"
                    value="<?php echo isset($_GET['id']) ? htmlspecialchars($row['name']) : ''; ?>"
                    placeholder="Enter full name" required class="mt-1 block w-full rounded border border-red-300 bg-red-50 px-3 py-2 text-gray-900 placeholder-gray-400
          focus:border-red-500 focus:ring-1 focus:ring-red-400 outline-none transition duration-150" />
            </label>

            <label class="block">
                <span class="text-sm font-medium text-gray-700">Description</span>
                <textarea name="description" rows="3" placeholder="Add teacher description" required
                    class="mt-1 block w-full rounded border border-red-300 bg-red-50 px-3 py-2 text-gray-900 placeholder-gray-400
          focus:border-red-500 focus:ring-1 focus:ring-red-400 resize-none outline-none transition duration-150"><?php echo isset($_GET['id']) ? htmlspecialchars($row['description']) : ''; ?></textarea>
            </label>

            <?php if (isset($_GET['id']) && !empty($row['image'])): ?>
                <div class="flex flex-col items-center gap-1">
                    <span class="text-gray-700 font-medium">Current Image:</span>
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Teacher Image"
                        class="rounded border-2 border-red-300 shadow-sm w-32 h-32 object-cover" />
                </div>
            <?php endif; ?>

            <label class="block">
                <span class="text-sm font-medium text-gray-700">
                    <?php echo !isset($_GET['id']) ? "Upload Image" : "Change Image (optional)"; ?>
                </span>
                <input type="file" name="image" <?php echo !isset($_GET['id']) ? 'required' : ''; ?> accept="image/*"
                    class="mt-1 block w-full cursor-pointer rounded border border-red-300 bg-red-50 px-3 py-2 text-gray-700
          focus:border-red-500 focus:ring-1 focus:ring-red-400 outline-none transition duration-150" />
            </label>

            <button type="submit" name="apply" value="apply" class="w-full bg-gradient-to-r from-red-400 via-red-500 to-red-600 text-white font-bold py-3 rounded-lg shadow
        hover:from-red-500 hover:via-red-600 hover:to-red-700 active:scale-95 transition transform select-none">
                <?php echo !isset($_GET['id']) ? "Add Teacher" : "Update Teacher"; ?>
            </button>

        </form>
    </main>

    <script>
        // Sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar when clicking outside (mobile)
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>

</html>