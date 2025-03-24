<style>
    nav{
	position: relative;
	background-color: #a06f00;
	z-index: 2;
    }
    a{
    color: #FFF;
    font-size: 15px;
    }
    .nav>li>a:hover, .nav>li>a:focus{
        	background-color: #009376;
        	color: #FF0000;
    }
</style>

<nav class="navbar">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
      <?php $sql=mysqli_query($con,"select id,categoryName from category order by id asc");
        while($row=mysqli_fetch_array($sql))
        { 
                     $menu_id 		    = $row['id'];
                     $category_name 	= $row['categoryName'];
        ?>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="category.php?cid=<?php echo $menu_id;?>"><?php echo $category_name; ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <?php
                     $sql2 = mysqli_query($con,"select * from subcategory where categoryid = '$menu_id'  order by id asc");
                         while($row1 = mysqli_fetch_array($sql2))
                             {		
                                $sub_menu_id 	    = $row1['id'];
                                $cat_id 		    = $row1['categoryid'];
                                $subcategory_name 	= $row1['subcategory'];
                    ?> 
          <li><a href="categories.php?cid=<?php echo $cat_id;?>&scid=<?php echo $sub_menu_id;?>"><?php echo $subcategory_name; ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>