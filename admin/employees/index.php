<?php
$title = 'Employees';
$icon  = 'users';
include __DIR__.'/../template/header.php';

$emps = $mysqli->query("select * from employees")->fetch_all(MYSQLI_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $statement = $mysqli->prepare("delete from employees where id = ?");
  $statement->bind_param('i' , $empId);
  $empId = $_POST['id'];
  $statement->execute();

  if ($_POST['image']) {
  unlink($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'SaraSalon/'.$_POST['image']);
  }
    echo "<script>location.href = 'index.php'</script>";
}
?>
  <div class="card">
    <div class="content">
      <a href="create.php" class="btn btn-success">Create new Employee</a>
      <p class="header">Employees: <?php echo count($emps) ?></p>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach ($emps as $emp) : ?>
              <tr>
                <td width="0"><?php echo $emp['id'] ?></td>
                <td><?php echo $emp['name'] ?></td>
                <td><?php echo $emp['description'] ?></td>
                <td><img src="<?php echo $config['app_url'].$emp['image']?>" alt="" width="50"></td>
                <td width="250">
                    <a href="edit.php?id=<?php echo $emp['id'] ?>" class="btn btn-warning">Edit</a>
                    <form  method="post" style="display:inline">
                      <input type="hidden" name="id" value="<?php echo $emp['id'] ?>">
                      <input type="hidden" name="image" value="<?php echo $emp['image'] ?>">
                      <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php $mysqli->close(); ?>
<?php
include __DIR__.'/../template/footer.php';

 ?>
