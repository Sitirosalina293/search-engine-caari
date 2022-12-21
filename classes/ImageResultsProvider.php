<?php
//pemrosesan untuk hasil penelusuran gambar / image
class ImageResultsProvider {
    private $con;
    public function __construct($con){
        $this->con = $con;
    }
    public function getNumResults($term){ //fungsi untuk mendapatkan jumlah gambar yang sesuai dengan apa yang dicari user/term
        $query = $this->con->prepare("SELECT COUNT(*) as total from images 
                                        WHERE (title LIKE :term
                                        OR alt LIKE :term)
                                        AND broken = 0"); //query untuk menghitung total gambar dimana judul atau altnya ada kesamaan dengan term / apa yang dicari user
        $searchTerm = "%" . $term . "%"; // % menyatakan kata lain, jadi term bisa diapit oleh kata lain
        $query->bindParam(":term", $searchTerm);
        $query->execute(); //eksekusi
        $row = $query->fetch(PDO::FETCH_ASSOC); //row/baris dalam database yang gambarnya sesuai dengan term
        return $row["total"]; // jumlah row yang bisa diartikan jumlah gambar
    }
    public function getResultsHtml($page, $pageSize, $term) {
        $fromLimit = ($page - 1) * $pageSize; //untuk pengaturan halaman
 

        $query = $this->con->prepare("SELECT * from images 
                                        WHERE (title LIKE :term
                                        OR alt LIKE :term)
                                        AND broken = 0
                                        ORDER BY clicks DESC 
                                        LIMIT :fromLimit, :pageSize "); //kalau query sebelumnya untuk menghitung, yang ini untuk select atau memilih/menampilkan gambar

        $searchTerm = "%". $term . "%";
        $query->bindParam(":term", $searchTerm);
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
        $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
        $query->execute();

        $resultsHtml = "<div class='imageResults'>";
        $count = 0; //deklarsasi awal
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $count++; //looping gambar
            $id = $row["id"];
            $imageUrl = $row["imageUrl"];
            $siteUrl = $row["siteUrl"];
            $title = $row["title"];
            $alt = $row["alt"];
            if($title){
                $displayText = $title;
            }else if($alt ){
                $displayText = $alt;
            }else{
                $displayText = $imageUrl;
            }
            //hasil untuk setiap gridnya, akan diulang sesuai count. setiap grid menampilkan gambar dan teks yang merupakan alt dibagian bawah 
            $resultsHtml .= "<div class='gridItem image$count'> 
								<a href='$imageUrl' data-fancybox data-caption='$displayText' data-siteUrl='$siteUrl'>
								    <script>
								        $(document).ready(function() {
								            loadImage(\"$imageUrl\", \"image$count\");
								        })
                                    </script>
									<span class='details'>$displayText</span>
								</a>
							</div>";

        }
        $resultsHtml .= "</div>";

        return $resultsHtml;
    }

}