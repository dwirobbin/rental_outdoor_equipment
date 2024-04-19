<div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-confirm-delete-selected-equipment', (event) => {
                swalConfirm.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Hapus!',
                    html: `Apakah anda ingin menghapus sebanyak <b>${event.totalIds}</b> Peralatan ?`,
                    confirmButtonText: 'Ya, hapus',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.dispatch('go-on-delete-selected-equipment', {
                            selectedIds: event.selectedIds
                        })
                    }
                });
            });
        });
    </script>
</div>
