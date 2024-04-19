<div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-confirm-delete-selected-user', (event) => {
                swalConfirm.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus!',
                    html: `Apakah anda ingin menghapus sebanyak <b>${event.totalIds}</b> Akun User ?`,
                    confirmButtonText: 'Ya, hapus',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.dispatch('go-on-delete-selected-user', {
                            selectedIds: event.selectedIds
                        })
                    }
                });
            });
        });
    </script>
</div>
