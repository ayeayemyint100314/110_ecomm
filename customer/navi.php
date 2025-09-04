<?php 
if(!isset($_SESSION))
{
  session_start();
}

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
      <?php   if(isset($_SESSION['email'])) {              ?>
             <li class="nav-item">
              <a class="nav-link" href="customerView.php">All Products</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#"><?php echo $_SESSION['email']; ?></a>
            </li>
            <li class="nav-item">
              <img src=<?php  echo $_SESSION['profilePath']; ?> style="width:50px; height:50px">
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-primary" href="userLogout.php">Logout</a>
            </li>
        <?php   }     ?>
      </ul>
    </div>
  </div>
</nav>