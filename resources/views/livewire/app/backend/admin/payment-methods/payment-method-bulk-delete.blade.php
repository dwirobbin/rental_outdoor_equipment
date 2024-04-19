<div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-confirm-delete-selected-paymentMethod', (event) => {
                swalConfirm.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus!',
                    html: `Apakah anda ingin menghapus sebanyak <b>${event.totalIds}</b> Metode Pembayaran ?`,
                    confirmButtonText: 'Ya, hapus',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.dispatch('go-on-delete-selected-paymentMethod', {
                            selectedIds: event.selectedIds
                        })
                    }
                });
            });
        });
    </script>
</div>
