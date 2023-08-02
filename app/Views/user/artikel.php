<!-- Judul -->
<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-dark">
                        <li class="breadcrumb-item"><a href="/" style="text-decoration:none">Beranda</a></li>
                        <li class="breadcrumb-item fw-bold" aria-current="page">
                            <?php echo $artikel["judul"]; ?>
                        </li>
                    </ol>
                </nav>
                <h1 class="fw-bold">
                    <?php echo $artikel["judul"]; ?>
                </h1>

                <p>
                    <i class="fas fa-calendar-alt"></i>
                    <?php echo date('d M Y H:i', strtotime($artikel["timestamp"])); ?>
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Gambar -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/img/<?php echo $artikel['gambar']; ?>" alt="Sampul" class="img-fluid rounded-1" />
                <div class="mt-3">
                    <?php echo (htmlspecialchars_decode($artikel["konten"])); ?>
                </div>
            </div>
            <div class="col-4">
                <h4 class="mb-0">Baca juga</h4>
                <div class="row row-cols-1 row-cols-md-1 mt-1 g-4">
                    <?php
                    $host = 'localhost';
                    $user = 'root';
                    $password = '';
                    $database = 'artikel';

                    $conn = mysqli_connect($host, $user, $password, $database);
                    if (!$conn) {
                        die('Koneksi ke database gagal: ' . mysqli_connect_error());
                    }

                    // Mendapatkan artikel yang sedang dibaca
                    $currentArticleId = $artikel['id'];

                    // Query untuk mendapatkan artikel terkait
                    $query = "SELECT * FROM tb_artikel WHERE id <> $currentArticleId LIMIT 4";

                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die('Query tidak berhasil: ' . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = $row['judul'];
                            $image = '/img/' . $row['gambar'];
                            $timestamp = $row['timestamp']; // Kolom timestamp pada tabel
                    
                            // Mengubah format timestamp menjadi format tanggal dan jam yang sesuai
                            $uploadedDate = date('d M Y', strtotime($timestamp));
                            $uploadedTime = date('H:i', strtotime($timestamp));

                            // Membatasi panjang judul
                            $max_title_length = 40; // Panjang maksimum judul yang diinginkan
                            if (strlen($title) > $max_title_length) {
                                $title = substr($title, 0, $max_title_length) . "..."; // Menyimpan substring judul dengan panjang maksimum dan menambahkan titik-titik
                            }

                            echo '<div class="col-lg-12">';
                            echo '<a href="' . base_url('user/artikel/' . $row['id']) . '" style="text-decoration:none">';
                            echo '<div class="card">';
                            echo '<img src="' . $image . '" class="card-img-top img-fluid" alt="Card Image">';
                            echo '<div class="card-body">';                          
                            echo '<h5 class="card-title fs-5 fw-semibold">' . $title . '</h5>';
                            echo '<p class="card-text mb-0 fs-6">' . '<i class="fa-solid fa-calendar-days" style="color: black;"></i> ' . $uploadedDate . ' ' . $uploadedTime . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                        }
                    } else {
                        $empty = "Tidak ada data yang ditemukan.";
                        echo '<p class="mt-5 text-center fs-6 pt-5">' . $empty . '</p>';
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Isi Artikel -->
<div class="container-fluid mt-4">
    <div class="container">
        <div class="row">
            <div class="col-8"></div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="container">
        <div class="col-12">
            <h4>Baca juga</h4>
        </div>
        <div class="row row-cols-1 row-cols-md-4 mt-1 g-4 mb-5">
            <?php
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'artikel';

            $conn = mysqli_connect($host, $user, $password, $database);
            if (!$conn) {
                die('Koneksi ke database gagal: ' . mysqli_connect_error());
            }

            // Mendapatkan artikel yang sedang dibaca
            $currentArticleId = $artikel['id'];

            // Query untuk mendapatkan artikel terkait
            $query = "SELECT * FROM tb_artikel WHERE id <> $currentArticleId LIMIT 4";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Query tidak berhasil: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['judul'];
                    $content = $row['konten'];
                    $image = '/img/' . $row['gambar'];
                    $timestamp = $row['timestamp']; // Kolom timestamp pada tabel
            
                    // Mengubah format timestamp menjadi format tanggal dan jam yang sesuai
                    $uploadedDate = date('d M Y', strtotime($timestamp));
                    $uploadedTime = date('H:i', strtotime($timestamp));

                    // Membatasi panjang judul
                    $max_title_length = 40; // Panjang maksimum judul yang diinginkan
                    if (strlen($title) > $max_title_length) {
                        $title = substr($title, 0, $max_title_length) . "..."; // Menyimpan substring judul dengan panjang maksimum dan menambahkan titik-titik
                    }

                    // Membatasi panjang deskripsi
                    $max_desc_length = 60; // Panjang maksimum deskripsi yang diinginkan
                    if (strlen($content) > $max_desc_length) {
                        $content = substr($content, 0, $max_desc_length) . "..."; // Menyimpan substring deskripsi dengan panjang maksimum dan menambahkan titik-titik
                    }

                    echo '<div class="col-lg-3 gy-4 gx-3 col-md-4 col-sm-6">';
                    echo '<a href="' . base_url('user/artikel/' . $row['id']) . '" style="text-decoration:none">';
                    echo '<div class="card">';
                    echo '<img src="' . $image . '" class="card-img-top img-fluid" alt="Card Image">';
                    echo '<div class="card-body">';
                    echo '<p class="card-text mb-0 fs-6">' . $uploadedDate . ' ' . $uploadedTime . '</p>';
                    echo '<h5 class="card-title fs-5 fw-semibold">' . $title . '</h5>';
                    echo '<p class="card-text fs-6">' . $content . '</p>';

                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                $empty = "Tidak ada data yang ditemukan.";
                echo '<p class="mt-5 text-center fs-6 pt-5">' . $empty . '</p>';
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>