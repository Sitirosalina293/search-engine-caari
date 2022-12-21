# Search Engine : Caari

Search engine ini dibuat sebagai prasayarat ujian akhir semester (UAS) semester ganjil 2021/2022 Mata Kuliah Kecerdasan Komputasional Kelas TI 2019.
program ini digunakan seperti search engine pada umumnya. Program ini dibuat menggunakan bahasa pemrograman **HTML (Hypertext Markup Language)**, **CSS (Cascading Style Sheet)**, **Javascript**, dan **PHP (Hypertext Preprocessor)**, dengan bantuan framework **bootsrap**.

3 Metode dalam search engine :
1. Crawling
2. Indexing
3. Ranking

Berikut struktur folder dalam aplikasi ini:

```
📦Caari
 ┣ 📂ajax
 ┃ ┣ 📜setBroken.php
 ┃ ┗ 📜updateLinkCount.php
 ┣ 📂assets
 ┃ ┣ 📂css
 ┃ ┃ ┗ 📜style.css
 ┃ ┣ 📂images
 ┃ ┃ ┣ 📂icons
 ┃ ┃ ┗ 📜logo-caari.png
 ┃ ┗ 📂js
 ┃   ┗ 📜script.js
 ┣ 📂classes
 ┃ ┣ 📜DomDocumentParser.php
 ┃ ┣ 📜ImageResultsProvider.php
 ┃ ┗ 📜SiteResultsProvider.php
 ┣ 📜config.php
 ┣ 📜crawl.php
 ┣ 📜formAdd.php
 ┣ 📜index.php
 ┣ 📜README.md
 ┣ 📜search.php
 ┗ 📜submit-url.php
```

## Requirements

* XAMPP : PHP >= 8.0.0
* Google Chrome >= 89.0.4389.114

## Instalation

* XAMPP

   Download [XAMPP](https://www.apachefriends.org/download.html) sesuai OS (Operating System) masing-masing, kemudian install sesuai petunjuk.
   
## Usage

1. Pastika terkoneksi dengan jaringan internet
2. Ekstrak ZIP
3. Letakan folder **Caari-Search-Engine** ke dalam 
    > *C:\xampp\htdocs*  (Windows).
4. Jalankan *XAMPP -> Apache dan MySQL*. 
5. Import *\assets\db_caari.sql* ke dalam database server.
6. Buka Browser ketikan 
   > *localhost/Caari-Search-Engine*.
7. Tuliskan keyword di field input.
8. Untuk crawl URL atau menambah data, ketik pada browser
    > *localhost/Caari-Search-Engine/submit-url.php*.

## Credits
   Dosen Pendamping : Yuni Yamasari, S.Kom., M.Kom.
   Author: Siti Rosalina - 073
   TI 2019 B

   Program Reference : 
   Perubahan yang dilakukan :
   1. UI
   2. Indexing : semula term utuh dari apa adanya yang user inputkan 
   -> saya ubah menjadi array dan memisahkan term menjadi per-kata untuk mengoptimalkan hasil pencarian
   -> saya tambahkan pembobotan pada setiap kesesuaian per term-kata
   3. ranking : semula di urutkan menurut yang paling sering dikunjungi, jadi belum tentu mendekati apa yang dicari user
   -> saya tambahkan sistem perankingan Simple Additive Weight (SAW) dengan memanfaatkan pembobotan kata, diurutkan berdasarkan kemiripan tertinggi dengan term yang di inputkan user
   -> 2 metode tersebut digabungkan untuk mengoptimalkan dan memudahkan user mendapatkan apa yang dicari
   4. penambahan form add data secara manual, karena hasil crawling masih kurang sempurna, tidak semua url mendapatkan hasil yang maksimal, bahkan tidak dapat dilakukan crawling.

   Saran untuk pengembangan selanjutnya :
   1. ditambahkan metode NLP, untu lebih memahami keinginan user, jika seketika terjadi salah ketik atau typo

## License
   [MIT](https://choosealicense.com/licenses/mit/)