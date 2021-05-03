<?php
$title = 'Users';
$icon  = 'users';
include __DIR__.'/../template/header.php';
$users = $mysqli->query("select * from users order by id")->fetch_all(MYSQLI_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $statement = $mysqli->prepare("delete from users where id = ?");
  $statement->bind_param('i' , $userId);
  $userId = $_POST['user_id'];
  $statement->execute();
    echo "<script>location.href = 'index.php'</script>";
}
?>
  <div class="card">
    <div class="content">
      <a href="create.php" class="btn btn-success">Create new User</a>
      <p class="header">Users: <?php echo count($users) ?></p>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Email</th>
              <th>Name</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user) : ?>
              <tr>
                <td width="0"><?php echo $user['id'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['user_name'] ?></td>
                <td><?php echo $user['role'] ?></td>
                <td width="250">
                    <a href="edit.php?id=<?php echo $user['id'] ?>" class="btn btn-warning">Edit</a>
                    <form  method="post" style="display:inline">
                      <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
