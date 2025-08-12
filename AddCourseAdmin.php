<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["usertype"] == "student") {
    header("location:Login.php");
}

require_once "Database.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM course WHERE id=$id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

// Add Course
if (isset($_POST["apply"]) && !isset($_GET['id'])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $image = $_FILES["image"]['name'];
    $dst_Db = "Public/" . basename($image);

    move_uploaded_file($_FILES["image"]['tmp_name'], $dst_Db);

    $checkData = "SELECT * FROM course WHERE name='$name'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Course Is Already Exist. Try Another One.. ";
        header("location:AddCourseAdmin.php.php");
        exit();
    }

    $sql = "INSERT INTO course(image, name, description) VALUES('$dst_Db', '$name', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Data Upload Successfull...";
        header("location:AddCourseAdmin.php");

    } else {
        $_SESSION["msg"] = "Data Upload Failed...";
        header("location:AddCourseAdmin.php");
    }
    exit();
}
// Update Course 
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

    $sql = "UPDATE course SET image='$dst_Db', name='$name', description='$description' WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg1"] = "Data Update Is Successful...";
        header("location:ViewCourseAdmin.php");
    } else {
        $_SESSION["msg1"] = "Data Update Failed...";
        header("location:ViewCourseAdmin.php");
    }
    exit();
}


if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    echo "<script> alert('$msg'); </script>";
    unset($_SESSION["msg"]);
}
?>

<!----------------------------------------------------------------------------------------------------------------------------------------------->




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
        <?php echo !isset($_GET['id']) ? "Add Course" : "Update Course"; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-lime-50 min-h-screen flex flex-col">

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

    <!-- Main Content -->
    <main
        class="flex-grow mt-14 p-6 sm:ml-56 overflow-auto min-h-[calc(100vh-3.5rem)] flex items-center justify-center">

        <div class="bg-white shadow-lg rounded-xl lg:p-6 p-3 w-full border-2 border-lime-300 flex flex-col max-w-md gap-4">

            <h1 class="text-center text-lime-700 font-extrabold text-2xl select-none drop-shadow-sm">
                <?php echo !isset($_GET['id']) ? "Add New Course" : "Update Course Data"; ?>
            </h1>

            <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 w-full max-w-md">

                <input type="text" name="name" placeholder="Course Name" required
                    value="<?php echo isset($_GET['id']) ? htmlspecialchars($row['name']) : ''; ?>"
                    class="px-3 py-2 rounded-lg border border-lime-300 bg-lime-50 text-lime-900 font-semibold focus:border-lime-500 focus:ring-1 focus:ring-lime-400 outline-none transition" />

                <textarea name="description" rows="4" placeholder="Course Description" required
                    class="px-3 py-2 rounded-lg border border-lime-300 bg-lime-50 text-lime-900 font-semibold resize-none focus:border-lime-500 focus:ring-1 focus:ring-lime-400 outline-none transition"><?php echo isset($_GET['id']) ? htmlspecialchars($row['description']) : ''; ?></textarea>

                <?php if (isset($_GET['id']) && !empty($row['image'])): ?>
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-lime-700 font-semibold select-none text-sm">Current Image:</span>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Course Image"
                            class="w-28 h-28 object-cover rounded-lg border-2 border-lime-400 shadow" />
                    </div>
                <?php endif; ?>

                <input type="file" name="image" <?php echo !isset($_GET['id']) ? 'required' : ''; ?> accept="image"
                    class="cursor-pointer rounded-md border border-lime-300 bg-lime-100 px-2 py-1 text-lime-700 font-semibold shadow-sm focus:outline-none focus:border-lime-500 focus:ring-1 focus:ring-lime-400 transition" />

                <button type="submit" name="apply" value="apply"
                    class="mt-3 rounded-lg bg-lime-500 hover:bg-lime-600 text-white font-bold py-3 text-lg shadow-sm active:scale-95 transition transform select-none">
                    <?php echo !isset($_GET['id']) ? "Add Course" : "Update Course"; ?>
                </button>

            </form>

        </div>

    </main>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>

</html>