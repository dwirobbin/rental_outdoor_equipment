<div>
    <script>
        function confirmDeleteBill(id, orderID) {
            return swalConfirm.fire({
                icon: 'warning',
                title: 'Konfirmasi hapus Tagihan!',
                html: `Apakah anda ingin menghapus Tagihan: <b>#${orderID}</b> ?`,
                confirmButtonText: 'Ya, hapus',
            }).then(function(result) {
                if (result.isConfirmed) {
                    @this.dispatch('go-on-delete-bill', {
                        billingId: id
                    })
                }
            });
        }
    </script>
</div>
