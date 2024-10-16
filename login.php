<?php
// Create connection
$conn = mysqli_connect('localhost','root','','login_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO my_table (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $stmt->close();
}

// Delete data from the database
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM my_table WHERE id = ". $id;
    mysqli_query($conn,$sql);

    // $stmt = $conn->prepare("DELETE FROM my_table WHERE id = ". $id);
    // $stmt->bind_param("i", $id);
    // $stmt->execute();
    // $stmt->close();
}

// Retrieve data from the database
$result = $conn->query("SELECT * FROM my_table");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Management</title>
    <style>
        button{
            margin-top: 3px;
            position: relative;
            left:70px;
            top:3px;
        }

        .top{
            margin-left:40%;
        }
.top h2{
    color:blue;
    
}
.top input{
    margin-top:5px;
}
a{
    background-color:red;
    color:white;
    padding:2px;
}
.record{
    margin-left:37%;
}
.record h2{
    margin-left:15%;
    color:green;
}
    </style>
</head>
<body>
    <div class="top">
    <h2>Add New Student Record</h2>
    <form method="POST" action="">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        <button type="submit" name="add" >Add Record</button>
    </form>
    </div>
<hr><div class="record">
    <h2>Records</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
        </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
