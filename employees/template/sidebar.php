<nav id="sidebar">
  <div class="custom-menu">
    <button type="button" id="sidebarCollapse" class="btn btn-dark">
      <i class="fa fa-bars"></i>
      <span class="sr-only">Toggle Menu</span>
    </button>
  </div>
  <div class="p-4">
    <h1><a href="<?php echo $config['app_url']?>" class="logo">Sara Salon</a></h1>
    <ul class="list-unstyled components mb-5">
      <li class="active">
        <a href="<?php echo $config['app_url']?>employees"><span class="fa fa-home mr-3"></span> Home</a>
      </li>
      <li>
          <a href="<?php echo $config['app_url']?>employees/reception/reception.php"><span class="fa fa-user mr-3"></span> Reception</a>
      </li>
      <!-- <li>
        <a href="#"><span class="fa fa-briefcase mr-3"></span> Works</a>
      </li>
      <li>
        <a href="#"><span class="fa fa-sticky-note mr-3"></span> Blog</a>
      </li>
      <li>
        <a href="#"><span class="fa fa-suitcase mr-3"></span> Gallery</a>
      </li> -->
      <li>
        <a href="<?php echo $config['app_url']?>employees/staff"><span class="fa fa-cogs mr-3"></span> Staff</a>
      </li>
      <li>
        <a href="<?php echo $config['app_url']?>employees/messages"><span class="fa fa-paper-plane mr-3"></span> Contacts</a>
      </li>
        <?php if (isset($_SESSION['logged_in']) &&  isset($_SESSION['user_role']) && $_SESSION['user_role'] ==  'admin') : ?>
      <li>
        <a href="<?php echo $config['app_url']?>admin"><span class="fa fa-server mr-3"></span> Control Panle</a>
      </li>
      <?php endif ?>
      <li>
        <a href="<?php echo $config['app_url'].'logout.php' ?>"><span class="fa fa-lock mr-3"></span>Log out</a>
      </li>
    </ul>




  </div>
</nav>
