</div>
<script src="template/assets/js/jquery-3.5.1.slim.min.js"></script>
<script src="template/assets/js/bootstrap.min.js"></script>
<script src="template/assets/js/popper.min.js"></script>
<script src="template/assets/js/jquery.min.js"></script>

<script >
window.onload = function (){
  $('.loader_bg').fadeOut();

  if (window.location.href === '<?php echo $config['app_url']?>' || window.location.href === '<?php echo $config['app_url']."index.php" ?>')
  {
           let navbar = document.getElementById('my-navbar');
           navbar.style.width = '100%';
           navbar.style.position = 'absolute';
           navbar.style.zIndex = 9000;
           navbar.top = '0';
           navbar.margin = 'auto';
           navbar.style.background = 'rgba(255, 255, 255,0.8)';
  }
}
</script>

</body>
<hr>
<footer class="footer-light bg-light" >
    <div class="container">

      <div class="row">
        <div class="col-md-12 py-5">

          <div class=" d-flex justify-content-center footer-social ">
            <a href="https://iwtsp.com/966552662010"> <i class="fa fa-whatsapp fa-lg white-text mr-md-5 mr-3 fa-2x "></i> </a>
            <a href="https://mobile.twitter.com/azooz77758a"> <i class="fa fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"></i></a>
            <a href="https://www.instagram.com/azooz77758/"> <i class="fa fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"></i> </a>
          </div>
        </div>
      </div>

    </div>
  </footer>
    <div class="footer-copyright text-center py-3">© 2020 Copyright: abdulaziz mualla</div>
</html>
