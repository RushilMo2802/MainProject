<!DOCTYPE html>
<html>
<head>
    <title>TODO List</title>
</head>
<body>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "just";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // CRUD Operations
    if (isset($_POST['create'])) {
        $task = $_POST['task'];
        $sql = "INSERT INTO todos (task, status) VALUES ('$task', 0)";
        if ($conn->query($sql) === TRUE) {
            echo "Task created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $task = $_POST['task'];
        $sql = "UPDATE todos SET task='$task' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Task updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sql = "DELETE FROM todos WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Task deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Read operation - Fetch all tasks from the database
    $sql = "SELECT * FROM todos";
    $result = $conn->query($sql);
    ?>

    <h1>TODO List</h1>
    <form method="post" action="">
        <label for="task">New Task:</label>
        <input type="text" name="task" required>
        <input type="submit" name="create" value="Add Task">
    </form>

    <h2>Tasks:</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $task = $row['task'];
                $status = $row['status'] ? "Completed" : "Not Completed";
                echo "<li>$task - $status 
                      <a href='?delete=$id'>Delete</a> 
                      <a href='?edit=$id'>Edit</a></li>";
            }
        } else {
            echo "<li>No tasks found.</li>";
        }
        ?>
    </ul>

    <?php
    // Edit operation - Retrieve task for editing
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM todos WHERE id='$id'";
        $edit_result = $conn->query($sql);
        $edit_data = $edit_result->fetch_assoc();
    ?>
        <h2>Edit Task:</h2>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
            <label for="task">Task:</label>
            <input type="text" name="task" value="<?php echo $edit_data['task']; ?>" required>
            <input type="submit" name="update" value="Update Task">
        </form>
    <?php
    }
    ?>

    <?php
    $conn->close();
    ?>
</body>
</html>
