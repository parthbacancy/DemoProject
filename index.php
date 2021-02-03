<?php include "includes/db.php"; ?>
<?php include "includes/function.php"; ?>

<?php include "includes/header.php"; ?>

<body class="container">
    <br>
    <a href='/DemoProject/add-user.php' target="_blank"><button class="btn btn-primary float-right">Add User</button></a>
    <form method="GET">
        <div class="form-group row">
            <input type="text" class='form-control w-25 ml-3 mr-2' placeholder="Search.." name="search" required>
            <button type="submit" class="btn btn-info ">Search</button>
        </div>
    </form>
    <form method="GET">
        <div class="form-group w-25">
            <label for="exampleFormControlSelect1">Sort By</label>
            <select class="form-control" id="exampleFormControlSelect1" name='sortby'>
                <?php
                if (isset($_GET['sortby'])) {
                    $sort_query =  escape($_GET['sortby']);
                    echo '<option value="$sort_query">Selected</option>';
                } ?>
                <option value='user_name'>Name</option>
                <option value='user_email'>Email</option>
                <option value='user_designation'>Designation</option>

            </select>
            <br>
            <button type="submit" class="btn btn-info">Sort</button>
        </div>
    </form>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Photo</th>
                <th scope="col">Email</th>
                <th scope="col">Designation</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $query = 'SELECT * FROM user';

            if (isset($_GET['sortby'])) {
                $sort_query =  escape($_GET['sortby']);
                $query = "SELECT * FROM user ORDER BY $sort_query";
            }

            if (isset($_GET['search'])) {
                $search_query =  escape($_GET['search']);
                $query = "SELECT * FROM user WHERE user_name LIKE '%$search_query%' OR user_email LIKE '%$search_query%' OR user_designation LIKE '%$search_query%'";
            }

            $select_user = mysqli_query($connection, $query);
            if (mysqli_num_rows($select_user) === 0) {
                echo '<h1>No Records Found</h1>';
            }
            while ($row = mysqli_fetch_assoc($select_user)) {
                $user_id = $row['user_id'];
                $user_name = $row['user_name'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_designation = $row['user_designation'];

                if ($user_image == '') {
                    $user_image = 'default-user-image.png';
                }

                echo "<tr>";
                echo "<th scope='row'>$user_id</th>";
                echo "<td>$user_name</td>";
                if (strpos($user_image, 'http') !== false) {
                    echo "<td><img src='$user_image' alt='$user_name'  width='100' height='100'></td>";
                } else {
                    echo "<td><img src='images/$user_image' alt='$user_name'  width='100' height='100'></td>";
                }
                echo "<td>$user_email</td>";
                echo "<td>$user_designation</td>";


            ?>
                <form method="post">

                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">

                    <?php
                    echo "<td><a class='btn btn-info' href='edit-user.php?u_id={$user_id}'>Edit</a></td>";
                    echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';

                    ?>
                </form>
            <?php
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php

    if (isset($_POST['delete'])) {
        echo "<script type='text/javascript'>alert('What your favorite cocktail drink');</script>";
        $the_user_id = escape($_POST['user_id']);
        $query = "DELETE FROM user WHERE user_id = {$the_user_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: /DemoProject/");
    }
    ?>
    <?php include "includes/footer.php"; ?>


</body>