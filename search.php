<!--Page untuk nambah data / Crawling url-->
<?php
include("config.php");
include("classes/SiteResultsProvider.php");
include("classes/ImageResultsProvider.php");
    if(isset($_GET["term"])){
        $term = $_GET["term"]; // term yang di inputkan user akan dimasukkan dalam variabel $term
    }else{
        exit("please letter search > 0");
    }
    $type = isset($_GET["type"]) ? $_GET["type"] : "sites";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Caari</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="headerContent">
                <div class="logoContainer">
                    <a href="index.php"><img src="assets/images/logo-caari.png" alt="Google Title"></a>
                </div>
                <div class="searchContainer">
                    <form action="search.php" method="get">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="text" class="searchBox" name="term" value="<?php echo $term; ?>" required>
                        <button class="searchButton"><img height="24px" src="assets/images/icons/search.png"></button>
                    </form>
                </div>
            </div>
            <div class="tabsContainer">
                <ul class="tabList">
                    <li class="<?php echo $type == 'sites' ? 'active' : '' ?>">
                        <a href="<?php echo "search.php?term=$term&type=sites"; ?>">
                            All
                        </a>
                    </li>
                    <li class="<?php echo $type == 'images' ? 'active' : '' ?>">
                        <a href="<?php echo "search.php?term=$term&type=images"; ?>">
                            Images
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mainResultsSection">
            <?php
                if($type == "sites"){
                    $resultsProvider = new SiteResultsProvider($con);
                    $pageLimit = 20;
                }else{
                    $resultsProvider = new ImageResultsProvider($con);
                    $pageLimit = 30;
                }
                $numResults = $resultsProvider->getNumResults($term);
                echo "<p class='resultsCount'>About $numResults results</p>";
                echo $resultsProvider->getResultsHtml($page, $pageLimit, $term);
                echo "<br><br>";
            ?>
        </div>
        <div class="paginationContainer">
            <div class="pageButtons">
                <?php
                $pagesToShow = 10; //menampilkan 10 halaman
                $pageSize = 20; //setiap halaman 20 konten
                $numPages = ceil($numResults / $pageSize);//jumlah halaman
                $pageLefts = min($pagesToShow, $numPages); //sisa halaman
                $currentPage = $page - floor( $pagesToShow / 2 ); //halaman yang sedang dikunjungi
                if($currentPage < 1){
                    $currentPage = 1;
                }
                if($currentPage + $pageLefts > $numPages + 1) { // jika halaman saat ini ditambah jumlah halaman yang tersisa kurang dari jumlah halaman ditambah 1
                    $currentPage = $numPages + 1 - $pageLefts; //maka jumlah halaman saat ini sama dengan jumlah total halaman + 1 - jumlah halaman yang tersisa
                }
                while($pageLefts != 0 && $currentPage <= $numPages) { // jika jumlah halaman yang tersisa tidak nol dan jumlah halaman saat ini kurang dari atau sama dengan jumlah halaman total
                    if($currentPage == $page){
                        echo "<div class='pageNumberContainer'>
                            <span class='pageNumber'>$currentPage</span> &emsp;
                          </div>";
                    }else{
                        echo "<div class='pageNumberContainer'>
                                  <a href='search.php?term=$term&type=$type&page=$currentPage'>
                                    <span class='pageNumber'>$currentPage</span> &emsp;
                                  </a>
                              </div>";
                    }
                    $currentPage++;
                    $pageLefts--;
                }

                ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>