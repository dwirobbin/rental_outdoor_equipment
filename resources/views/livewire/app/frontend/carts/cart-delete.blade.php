<div>
    <script>
        function confirmDeleteCartItem(id, name) {
            return Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Hapus!',
                html: `Apakah anda ingin menghapus Produk: <b>${name}</b> dari Keranjang anda ?`,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                customClass: {
                    cancelButton: 'order-1',
                    confirmButton: 'order-2',
                },
                buttonsStyling: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    @this.dispatch('go-on-delete-cart-item', {
                        cartItemId: id
                    })

                    @this.on('message', (event) => {
                        Swal.fire({
                            icon: event.type,
                            title: event.text,
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                    })
                }
            });
        }
    </script>
</div>
