<?php

require './read.php'; // Make sure this path is correct for your project structure

$db = connect_database(); // Initialize your database connection

// Fetch all buckets
$buckets = get_buckets($db);

// HTML for displaying buckets
echo "<button onclick=\"location.href='../Create/create_html.php'\">Create Bucket</button>"; // Adjust the link as needed

echo "<table border='1'>";
echo "<tr>
        <th>Bucket ID</th>
        <th>Transaction Name</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>";

foreach ($buckets as $bucket) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($bucket['bucket_id']) . "</td>";
    echo "<td>" . htmlspecialchars($bucket['transaction_name']) . "</td>";
    echo "<td>" . htmlspecialchars($bucket['category']) . "</td>";
    echo "<td>";
    echo "<button onclick=\"location.href='../Update/update_html.php?id=" . $bucket['bucket_id'] . "'\">Update</button>"; // Adjust the link as needed
    echo "<button onclick=\"location.href='../Delete/delete.php?id=" . $bucket['bucket_id'] . "'\">Delete</button>"; // Adjust the link as needed
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buckets</title>
</head>

<body>
    <button onclick="location.href='../../../index.php'">Back</button>
</body>

</html>