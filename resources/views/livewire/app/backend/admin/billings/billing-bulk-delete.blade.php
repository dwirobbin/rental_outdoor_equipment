<div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-confirm-delete-selected-billing', (event) => {
                swalConfirm.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus!',
                    html: `Apakah anda ingin menghapus sebanyak <b>${event.totalIds}</b> Tagihan ?`,
                    confirmButtonText: 'Ya, hapus',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.dispatch('go-on-delete-selected-billing', {
                            selectedIds: event.selectedIds
                        })
                    }
                });
            });
        });
    </script>
</div>
