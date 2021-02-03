<?php include "includes/db.php"; ?>
<?php include "includes/function.php"; ?>

<?php include "includes/header.php"; ?>
<?php


if (isset($_POST['create_user'])) {

    $user_name        = escape($_POST['user_name']);
    $user_email        = escape($_POST['user_email']);
    $user_designation        = escape($_POST['user_designation']);
    $user_image        = escape($_FILES['image']['name']);

    if (empty($user_image)) {
        $user_image = "default-user-image.png";
    }
    $user_image_temp   = escape($_FILES['image']['tmp_name']);
    echo $user_image_temp;

    $dirpath = realpath(dirname(getcwd()));
    move_uploaded_file($user_image_temp, "$dirpath/DemoProject/images/$user_image");
    $query = "INSERT INTO user(user_name, user_email, user_image,user_designation) ";

    $query .= "VALUES('{$user_name}','{$user_email}','{$user_image}','{$user_designation}') ";

    $create_user_query = mysqli_query($connection, $query);

    confirmQuery($create_user_query);
    header("Location: /DemoProject/");
}
?>

<body class="container">
    <br>
    <a href='/DemoProject/'><button class="btn btn-primary">Home Page</button></a>
    <br>
    <br>
    <form action="" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="title">User Name</label>
            <input type="text" class="form-control" name="user_name" required>
        </div>
        <br>
        <div class="form-group">
            <label for="user_image">User Image</label>
            <input type="file" name="image">
        </div>
        <br>
        <div class="form-group">
            <label for="user_email">User Email</label>
            <input type="email" class="form-control" name="user_email" required>
        </div>
        <br>
        <div class="form-group">
            <label for="user_designation">User Designation</label>
            <input type="text" class="form-control" name="user_designation" required>
        </div>
        <br>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
        </div>


    </form>
</body>