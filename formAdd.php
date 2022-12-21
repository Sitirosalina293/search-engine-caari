<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Add url</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!--link framework bootsrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body> 
<div class="row justify-content-center"  style="margin-top:200px;">
    <div class="col-lg-4">
        <main class="form-signin">
          <h1 class="h3 mb-4 fw-bold text-center mt-5" style="color: red">Add Data Manually</h1>
          <form method="POST">
            <div class="form-floating">
              <input type="url" name="url" class="form-control" id="url" placeholder="http://example.com" autofocus required>
              <label for="url">URL</label>
            </div>
            <div class="form-floating">
              <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
              <label for="title">Title</label>
            </div>
            <div class="form-floating">
              <textarea name="desc" class="form-control" id="desc" placeholder="Decription" required></textarea>
              <label for="desc">Description</label>
            </div>
            <div class="form-floating">
              <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Keywords" required>
              <label for="keywords">Keyword</label>
            </div>
            <button class="w-100 btn btn-lg btn-danger" type="submit" name="submit">Submit</button>
            <a href="submit-url.php" class="mt-3">Back</a>
          </form>
            <?php
                include 'config.php';

                if (isset($_POST['submit'])) { //jika tombol submit ditekan/formnya di kumpulkan/submit
                $sql = "INSERT INTO sites(url, title, description, keywords) VALUES"; //memasukkan/input ke tabel sites
                $sql .= "('{$_POST['url']}', '{$_POST['title']}', '{$_POST['desc']}', '{$_POST['keywords']}')"; //value yang akan di input ke database

                $result = $con->prepare($sql);
        
                if ($result->execute()) { //eksekusi
                    echo "<script>alert('Data tersimpan'); window.location='submit-url.php'</script>"; //alert atau notif box jika success di input ke database
                } else {
                    echo "<script>alert('Terjadi kesalahan');</script>"; //jika gagal input
                }
            }
        ?>
        </main>
    </div>
</div>
</body>
</html>