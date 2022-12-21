<?php
//pemrosesan untuk hasil penelusuran situs atau site
class SiteResultsProvider{
    private $con;
    public function __construct($con){
        $this->con = $con;
    }
    public function getNumResults($term){ //fungsi untuk mendapatkan jumlah site atau situs yang sesuai dengan apa yang dicari user/term
        $term=$_GET['term']; //term yang dimasukkan user di ubah menjadi array
        $term=preg_split('/[\s]+/', $term); //array yang diperoleh dipisah lagi perkata, yang ditandai dengan spasi
        $total_term=count($term); //menghitung kata yang didapat
        foreach($term as $key=>$term){ //looping
        $where ="title LIKE '%$term%' OR url LIKE '%$term%' OR description LIKE '%$term%' OR keywords LIKE '%$term%'"; //dimana varibel where nanti menjadi kondisi dari query proses
        if($key != $total_term-1){
            //pembobotan dimana setiap ada kesamaan kata dengan setiap kata pada term maka nilai mirip akan ditambah 1
            //jadi semakin banyak kata dalam term yang terdapat dalam setiap situs maka situs tersebut bobot miripnya semakin besar
            $query = $this->con->prepare("UPDATE sites SET mirip = mirip + 1 WHERE $where"); 
            $query->execute();
            $where .= "OR";
        }
        }
        $query = $this->con->prepare("SELECT COUNT(*) as total from sites WHERE $where"); //query menghitung bayaknya situs yang sesuai dengan apa yang dicari user
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row["total"]; //hasil keluaran berupa jumlah total situs yang sesuai
    }
    public function getResultsHtml($page, $pageSize, $term) {
        $fromLimit = ($page - 1) * $pageSize;

        $term=$_GET['term'];
        $term=preg_split('/[\s]+/', $term);
        $total_term=count($term);
        foreach($term as $key=>$term){
            $where ="title LIKE '%$term%' OR url LIKE '%$term%' OR description LIKE '%$term%' OR keywords LIKE '%$term%'";
            if($key != $total_term-1)
            {
                $where .= "OR";
            }
        }
        $query = $this->con->prepare("SELECT * FROM sites WHERE $where ORDER BY mirip DESC, clicks DESC LIMIT :fromLimit, :pageSize"); 
        //query untuk memilih atau select situs yang sesuai
        //berdasarkan query diatas, maka hasil yang ditampilkan di urutkan berdasakan kemiripan yang paling banyak
        //kemudian diurutkan kembali berdasakan kunjungan terbanyak / situs terpopuler
        $query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
        $query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
        $query->execute();
        $resultsHtml = "<div class='siteResults'>";
        //menampilkan hasil dengan loopping
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $url = $row["url"];
            $title = $row["title"];
            $description = $row["description"];

            $title = $this->trimField($title, 120); //disini berarti jumlah judul yang ditampilkan maks 120 kata
            $description = $this->trimField($description, 230);
            $resultsHtml .= "<div class='resultContainer'>
								<h3 class='title'>
									<a class='result' href='$url' data-linkId='$id'>
										$title
									</a>
								</h3>
								<span class='url'>$url</span>
								<span class='description'>$description</span>
							</div>";
        }
        $resultsHtml .= "</div>";
        $query = $this->con->prepare("UPDATE sites SET mirip = 0"); //update atau mengatur ulang nilai mirip menjadi 0 lagi seperti semula
                $query->execute();
        return $resultsHtml;
    }
    private function trimField($string, $characterLimit){
        $dots = strlen($string) > $characterLimit ? "..." : ""; //menghitung panjang karakter
        return substr($string, 0, $characterLimit) . $dots; //memotong string 
    }
}