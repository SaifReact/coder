<section class="hero">
    <div class="container">
        <div class="row">
            <!-- Categories Section -->
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Departments</span><span style="font-size: 12px"> - সকল বিভাগ</span>
                    </div>
                    <ul>
                        <?php 
                        $sql = mysqli_query($con, "SELECT id, catName, catName_en FROM category");
                        while ($row = mysqli_fetch_array($sql)) { ?>
                            <li>
                                <a href="category.php?cid=<?= $row['id']; ?>">
                                    <?= htmlentities($row['catName_en']). ' - ' . trim(htmlentities($row['catName']), ' -'); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <!-- Search and Hero Banner Section -->
            <div class="col-lg-9"> <!-- Changed col-lg-7 to col-lg-9 -->
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form role="search" name="search" method="post" action="search-result.php">
                            <input type="text" id="searchInput" name="product">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>

                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+880 1540 505646</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Banner -->
                <img class="hero__item hero-bg" src="img1/hero/banner.jpg"/>
            </div>
        </div>
    </div>

    <!-- JavaScript for TypeWriter Effect -->
    <script src="assets/js/typewrite.js"></script>
    <script>
        new TypeWriter('#searchInput', [
            'Search by Product Name Ex: Honey, মধু, Ghee, ঘি ',
            'Search by Product Name Ex: Honey, মধু, Ghee, ঘি ',
            'Search by Product Name Ex: Honey, মধু, Ghee, ঘি '
        ], { writeDelay: 100 });
    </script>
</section>
