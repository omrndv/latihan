<div class="container">
    <div class="row mt-4">
        <h4 class="display-6 mb-3 fw-semibold">Tambah Artikel</h4>
        <form method="post" action="<?= site_url('Admin/simpanData') ?>" class="col-lg-12 mb-4"
            enctype="multipart/form-data">
            <!-- Tambahkan input hidden untuk menyimpan id_kategori -->
            <input type="hidden" name="id_kategori" value="<?= $_GET['id_kategori'] ?>">
            <div class="input-group">
                <input type="text" name="judul" class="form-control" placeholder="Judul Artikel" required>
            </div>
            <div class="input-group mt-2 col-6">
                <textarea name="konten" class="form-control" placeholder="Konten Artikel" id="konten" required></textarea>
            </div>
            <div class="input-group mt-4">
                <input type="file" name="gambar" class="form-control" id="gambar" required>
            </div>
            <div class="mt-4 text-end">
            <a href="<?= site_url('Admin/kategori/' . $_GET['id_kategori']) ?>" class="btn btn-danger" style="text-decoration: none;">Batal</a>
                <button type="button" class="btn btn-primary" onclick="validateForm()">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan ini pada bagian head halaman Anda -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
    // Inisialisasi CKEditor
    CKEDITOR.replace('konten');

    // Fungsi untuk melakukan validasi sebelum mengirimkan formulir
    function validateForm() {
        var editorData = CKEDITOR.instances.konten.getData();
        var judulInput = document.querySelector('input[name="judul"]');
        var gambarInput = document.getElementById('gambar');

        if (editorData.trim() === '') {
            alert('Konten Artikel tidak boleh kosong.');
            return;
        }

        if (judulInput.value.trim() === '') {
            alert('Judul Artikel tidak boleh kosong.');
            return;
        }

        if (gambarInput.files.length === 0) {
            alert('Anda harus memilih gambar untuk artikel.');
            return;
        }
        document.querySelector('form').submit();
    }
</script>