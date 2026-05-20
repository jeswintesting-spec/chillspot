<?php
// Show errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../db.php';

// Authentication Check: Only admins should access this
if (!isset($_SESSION['admin_number'])) {
    header("Location: adminlogin.html");
    exit();
}

$success_message = "";
$error_message = "";

// Handle settings update
if (isset($_POST['update_settings'])) {
    $new_name = trim($_POST['institute_name']);
    if (empty($new_name)) {
        $error_message = "Institute name cannot be empty.";
    } else {
        $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'institute_name'");
        $stmt->bind_param("s", $new_name);
        if ($stmt->execute()) {
            $success_message = "Institute name updated successfully!";
        } else {
            $error_message = "Failed to update database: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch current setting value
$institute_name = "CUCEK";
$res = $conn->query("SELECT setting_value FROM settings WHERE setting_key = 'institute_name'");
if ($res && $row = $res->fetch_assoc()) {
    $institute_name = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Settings | ChillSpot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

<!-- HEADER -->
<header class="bg-gradient-to-r from-teal-700 to-teal-600 text-white shadow-md sticky top-0 z-50">
  <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
    <a href="adminmain.html" class="text-2xl font-bold hover:text-white/80">ChillSpot Admin</a>
    <div class="flex items-center space-x-4">
      <a href="adminmain.html" class="text-white/90 hover:text-white font-medium transition">Dashboard</a>
      <button onclick="location.href='../login.html'" 
              class="bg-white text-teal-700 px-5 py-2.5 rounded-lg font-semibold hover:bg-teal-50 shadow-sm transition">
        Logout
      </button>
    </div>
  </nav>
</header>

<div class="container mx-auto p-6 max-w-2xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
        <!-- Banner/Hero Header inside Card -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-500 p-6 text-white text-center">
            <h2 class="text-2xl font-bold">General System Settings</h2>
            <p class="text-teal-100 text-sm mt-1">Configure global application branding and parameters</p>
        </div>

        <div class="p-8">
            <!-- Messages -->
            <?php if (!empty($success_message)) { ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center space-x-2">
                    <span class="font-semibold">✓</span>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php } ?>
            
            <?php if (!empty($error_message)) { ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center space-x-2">
                    <span class="font-semibold">✗</span>
                    <span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php } ?>

            <!-- Form -->
            <form method="POST" action="settings.php" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Institute Name</label>
                    <input type="text" 
                           name="institute_name" 
                           value="<?php echo htmlspecialchars($institute_name); ?>" 
                           placeholder="e.g. CUCEK, CUSAT, etc."
                           class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition"
                           required>
                    <p class="text-gray-500 text-xs mt-2">
                        Changing this setting will dynamically rename all references to the institute across titles, headers, footers, and dashboard pages on the platform.
                    </p>
                </div>

                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" 
                            name="update_settings" 
                            class="bg-teal-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-teal-700 shadow-md hover:shadow-lg transition">
                        Save Changes
                    </button>
                    <a href="adminmain.html" 
                       class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/institute.js" defer></script>
</body>
</html>
