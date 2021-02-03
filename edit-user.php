<?php include "includes/db.php"; ?>
<?php include "includes/function.php"; ?>

<?php include "includes/header.php"; ?>
<?php

if (isset($_GET['u_id'])) {

    $the_user_id =  escape($_GET['u_id']);
}


$query = "SELECT * FROM user WHERE user_id = $the_user_id  ";
$select_user_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_user_by_id)) {
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_designation = $row['user_designation'];
    if (strpos($user_image, 'http') === false) {
        $user_new_image = 'images/'.$user_image;
    }else{
        $user_new_image = $user_image;
    }
    if ($user_image == '') {
        $user_new_image = 'images/default-user-image.png';
    }
}


if (isset($_POST['update_user'])) {


    $user_name           =  escape($_POST['user_name']);
    $user_email          =  escape($_POST['user_email']);
    $user_designation    =  escape($_POST['user_designation']);
    $user_image          =  escape($_FILES['image']['name']);
    $user_image_temp     =  escape($_FILES['image']['tmp_name']);

    echo $user_image;
    echo $user_image_temp;
    $dirpath = realpath(dirname(getcwd()));
    move_uploaded_file($user_image_temp, "$dirpath/DemoProject/images/$user_image");

    if (empty($user_image)) {

        $query = "SELECT * FROM user WHERE user_id = $the_user_id ";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($select_image)) {

            $user_image = $row['user_image'];
        }
    }
    $user_name = mysqli_real_escape_string($connection, $user_name);


    $query = "UPDATE user SET ";
    $query .= "user_name  = '{$user_name}', ";
    $query .= "user_image  = '{$user_image}', ";
    $query .= "user_email  = '{$user_email}', ";
    $query .= "user_designation  = '{$user_designation}' ";
    $query .= "WHERE user_id = {$the_user_id} ";

    $update_user = mysqli_query($connection, $query);

    confirmQuery($update_user);
    header("Location: /DemoProject/");
}

?>


<body class="container">

    <form action="" method="post" enctype="multipart/form-data">


        <div class="form-group">
            <label for="title">User Name</label>
            <input value="<?php echo htmlspecialchars(stripslashes($user_name)); ?>" type="text" class="form-control" name="user_name" required>
        </div>
        <br>
        <div class="form-group">
            <img width="100" src="<?php echo $user_new_image; ?>" alt="">
            <input type="file" name="image">
        </div>
        <br>
        <div class="form-group">
            <label>User Email</label>
            <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email" required>
        </div>
        <br>
        <div class="form-group">
            <label>User Designation</label>
            <input value="<?php echo $user_designation; ?>" type="text" class="form-control" name="user_designation" required>
        </div>
        <br>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
        </div>


    </form>
</body>