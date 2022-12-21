<?php
class DomDocumentParser {
    private $doc;
    public function __construct($url){
        $options = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"User-agent: poopleBot/0.1\n"
                )
        );
        $context = stream_context_create($options); //membuat stream
        $this->doc = new DOMDocument();
        @$this->doc->loadHTML(file_get_contents($url, false, $context));//mendapat / load html dari url
    }
    public function getLinks(){
        return $this->doc->getElementsByTagName("a");//mendapatkan url
    }
    public function getTitleTags(){
        return $this->doc->getElementsByTagName("title");//mendapatkan judul / title
    }
    public function getMetaTags(){
        return $this->doc->getElementsByTagName("meta"); //mendapatkan tag meta / untuk deskripsi/keyword biasanya
    }
    public function getImages(){
        return $this->doc->getElementsByTagName("img"); //mendapatkan gambar
    }
}