<?php
// Define each name associated with an URL
$urls = array(
'Home' => '/',
'YTLINK' => '/ytlink.php',
// …
);
?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a href="#" class="navbar-brand">Brand</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
              <?php foreach($urls as $name => $url): ?>
                <a href="<?php echo $url; ?>" class="nav-item nav-link <?php if($currentPage === $name){echo "active";}; ?>"><?php echo $name; ?></a>
              <?php endforeach; ?>
            </div>
            <?php if($search): ?>
            <form action="javascript:void(0)"class="form-inline ml-auto d-none d-sm-block">
                <input type="text" id="search" class="form-control mr-sm-2" placeholder="Search">
            </form>
          <?php endif; ?>
        </div>
    </nav>
