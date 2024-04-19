<div>
    <script>
        function deleteConfirm(id, name) {
            return swalConfirm.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus!',
                html: `Apakah anda ingin menghapus Peralatan: <b>${name}</b> ?`,
                confirmButtonText: 'Ya, hapus',
            }).then(function(result) {
                if (result.isConfirmed) {
                    @this.dispatch('go-on-delete-equipment', {
                        equipmentId: id
                    })
                }
            });
        }
    </script>
</div>
