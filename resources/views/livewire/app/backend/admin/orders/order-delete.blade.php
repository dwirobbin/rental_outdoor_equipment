<div>
    <script>
        function confirmDeleteOrder(id, orderID) {
            return swalConfirm.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus!',
                html: `Apakah anda ingin menghapus Pesanan: <b>#${orderID}</b> ?`,
                confirmButtonText: 'Ya, hapus',
            }).then(function(result) {
                if (result.isConfirmed) {
                    @this.dispatch('go-on-delete-order', {
                        orderId: id
                    })
                }
            });
        }
    </script>
</div>
