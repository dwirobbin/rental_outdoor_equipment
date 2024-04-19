<div>
    <script>
        function confirmDeleteAccountUser(id, name) {
            return swalConfirm.fire({
                icon: 'warning',
                title: 'Konfirmasi hapus Akun User!',
                html: `Apakah anda ingin menghapus Akun User: <b>${name}</b> ?`,
                confirmButtonText: 'Ya, hapus',
            }).then(function(result) {
                if (result.isConfirmed) {
                    @this.dispatch('go-on-delete-user', {
                        userId: id
                    })
                }
            });
        }
    </script>
</div>
