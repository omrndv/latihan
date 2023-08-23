<h1 class="fw-bolder my-5 text-center">Kumpulan Kategori</h1>

<div class="card">
    <div class="card-header col text-start">
        <div class="row">
            <!-- Button Tambah -->
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="text"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah Kategori</span>
                </button>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= site_url('Admin/addCategory') ?>">
                                <div class="mb-3 mt-2">
                                    <label class="form-label">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" class="form-control"
                                        placeholder="Masukkan Judul Kategori.." required>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-danger" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-trash" style="color: #ffffff;"></i> Hapus Kategori Terpilih</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="delete-form" action="<?= site_url('Admin/DeleteCategory') ?>" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Terakhir Update</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="category_to_delete[]" value="<?= $category['id_kategori'] ?>">
                            </td>
                            <td>
                                <?= $counter++; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('Admin/category/' . $category['id_kategori']) ?>"
                                    style="text-decoration: none; color:black">
                                    <?= $category['nama_kategori']; ?>
                                </a>
                            </td>

                            <td>
                                <?= $category['last_updated']; ?>
                            </td>
                            <td>
                                <span
                                    class="status-indicator <?= $category['status'] === 'aktif' ? 'aktif' : 'nonaktif' ?> mx-3"></span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="openEditModal(
                                    '<?= $category['id_kategori'] ?>',
                                    '<?= $category['nama_kategori'] ?>',
                                    '<?= $category['status'] ?>'
                                )">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="<?= site_url('Admin/edit_kategori') ?>" method="post">
                    <input type="hidden" name="kategori_id" id="edit-kategori-id">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" name="edit_nama" id="edit-nama" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select name="edit_status" id="edit-status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="confirmSave()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="category_to_delete[]"]');

    selectAllCheckbox.addEventListener('change', () => {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    function konfirmasiHapusMultiple() {
        const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

        if (selectedCheckboxes.length === 0) {
            Swal.fire({
                title: 'Tidak ada data yang dipilih',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data kategori terpilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }
    }
    function openEditModal(id_kategori, nama_kategori, status) {
        const editForm = document.getElementById('edit-form');
        document.getElementById('edit-kategori-id').value = id_kategori;
        document.getElementById('edit-nama').value = nama_kategori;
        document.getElementById('edit-status').value = status;

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmSave() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menyimpan perubahan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                const editForm = document.getElementById('edit-form');
                const statusDropdown = document.getElementById('edit-status');

                // Ambil nilai dropdown status dan tipe
                const selectedStatus = statusDropdown.value;

                // Tambahkan input tersembunyi untuk mengirim nilai status dan tipe
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'edit_status';
                statusInput.value = selectedStatus;

                editForm.appendChild(statusInput);

                // Submit formulir
                editForm.submit();
            }
        });
    }

    function toggleAdminStatus(kategoriId, newStatus) {
        const formData = new FormData();
        formData.append('kategori_id', kategoriId);
        formData.append('new_status', newStatus);

        fetch('<?= site_url('admin/toggleKategoriStatus') ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status kategori.');
                }
            });
    }
</script>