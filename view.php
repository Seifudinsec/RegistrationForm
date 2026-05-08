<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <table width="50%" border="1px" style="border-collapse: collapse;">
        <tr>
            <td>UserID</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>User Name</td>
            <td>Email</td>
            <td>Password</td>
            <td>Action</td>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "userdetailsDB");
 
        $allUsers = "SELECT * FROM userstable";
        $run = mysqli_query($conn, $allUsers);
 
        while ($row = mysqli_fetch_array($run)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['firstname'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <button id="back" onclick="window.location='index.php'">Add User</button>

</body>
</html>