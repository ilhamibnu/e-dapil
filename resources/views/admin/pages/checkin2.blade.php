@extends('admin.layout.main')

@section('title', 'Checkin Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Checkin Ticket</h2>
            {{-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool,
                    built upon the foundations of progressive enhancement, that adds all of these advanced features to any
                    HTML table. </p> --}}

            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">

                            <form>
                                <div class="row">
                                    <h3>Scan QR Code</h3>
                                </div>
                                 <div class="row">
                                     <div id="reader" height="400px" width="400px"></div>
                                    </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Nama
                                    </label>
                                    <input disabled type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Email
                                    </label>
                                    <input disabled type="text" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Phone
                                    </label>
                                    <input disabled type="text" class="form-control" id="phone">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Paket
                                    </label>
                                    <input disabled type="text" class="form-control" id="paket">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Harga
                                    </label>
                                    <input disabled type="text" class="form-control" id="harga">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Status Pembayaran
                                    </label>
                                    <input disabled type="text" class="form-control" id="statuspembayaran">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Status Checkin
                                    </label>
                                    <input disabled type="text" class="form-control" id="statuscheckin">
                                </div>

                            </form>

                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->

@endsection

@section('script')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {

        $('#reader').val(decodedText);
        let id = decodedText;
        html5QrcodeScanner.clear();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/checkin2",
            type: "POST",
            data: {
                _token: csrf_token,
                pendaftaran_id: id,
            },
            success: function (response) {
                console.log(response);
                if (response.success == "berhasil") {
                    $('#name').val(response.pendaftaran.name);
                    $('#email').val(response.pendaftaran.email);
                    $('#phone').val(response.pendaftaran.phone);
                    $('#paket').val(response.paket.name);
                    $('#harga').val(response.paket.harga);
                    $('#statuspembayaran').val(response.pendaftaran.status);
                    $('#statuscheckin').val(response.pendaftaran.checkin);

                    Swal.fire({
                        title: 'Berhasil',
                        // text: "Checkin Berhasil",
                        icon: 'success',
                         html: '<p>Checkin Berhasil</p><br></br>'
                         +'<p>Name: ' + response.pendaftaran.name + '</p>'
                         +'<p>Paket: ' + response.paket.name + '</p>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                      location.reload();

                    })
                } else if (response.success == "belumbayar") {
                    $('#name').val(response.pendaftaran.name);
                    $('#email').val(response.pendaftaran.email);
                    $('#phone').val(response.pendaftaran.phone);
                    $('#paket').val(response.paket.name);
                    $('#harga').val(response.paket.harga);
                    $('#statuspembayaran').val(response.pendaftaran.status);
                    $('#statuscheckin').val(response.pendaftaran.checkin);
                    
                 
                    Swal.fire({
                        title: 'Gagal',
                        // text: "Checkin Gagal, Pembayaran Belum Lunas",
                        icon: 'error',
                        html: '<p>Checkin Gagal, Pembayaran Belum Lunas</p><br></br>'
                         +'<p>Name: ' + response.pendaftaran.name + '</p>'
                         +'<p>Paket: ' + response.paket.name + '</p>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                      location.reload();

                    })
                } else if (response.success == "sudahcheckin") {
                    $('#name').val(response.pendaftaran.name);
                    $('#email').val(response.pendaftaran.email);
                    $('#phone').val(response.pendaftaran.phone);
                    $('#paket').val(response.paket.name);
                    $('#harga').val(response.paket.harga);
                    $('#statuspembayaran').val(response.pendaftaran.status);
                    $('#statuscheckin').val(response.pendaftaran.checkin);
             
                    Swal.fire({
                        title: 'Gagal',
                        // text: "Checkin Gagal, Sudah Melakukan Checkin",
                        icon: 'error',
                          html: '<p>Checkin Gagal, Sudah Melakukan Checkin</p><br></br>'
                         +'<p>Name: ' + response.pendaftaran.name + '</p>'
                         +'<p>Paket: ' + response.paket.name + '</p>',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                         location.reload();

                    })
                } else {
                    $('#name').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#paket').val('');
                    $('#harga').val('');
                    $('#statuspembayaran').val('');
                    $('#statuscheckin').val('');
                 
                    Swal.fire({
                        title: 'Gagal',
                        text: "Checkin Gagal, Data Tidak Ditemukan",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                          location.reload();

                    })
                }
            },
        });

    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: 250
        });
    html5QrcodeScanner.render(onScanSuccess);

</script>


<script>
    $('#dataTable-1').DataTable({
        autoWidth: true,
        // "lengthMenu": [
        //     [16, 32, 64, -1],
        //     [16, 32, 64, "All"]
        // ]
        dom: 'Bfrtip',


        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],

        buttons: [{
                extend: 'colvis',
                className: 'btn btn-primary btn-sm',
                text: 'Column Visibility',
                // columns: ':gt(0)'


            },

            {

                extend: 'pageLength',
                className: 'btn btn-primary btn-sm',
                text: 'Page Length',
                // columns: ':gt(0)'
            },


            // 'colvis', 'pageLength',

            {
                extend: 'excel',
                className: 'btn btn-primary btn-sm',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },

            // {
            //     extend: 'csv',
            //     className: 'btn btn-primary btn-sm',
            //     exportOptions: {
            //         columns: [0, ':visible']
            //     }
            // },
            {
                extend: 'pdf',
                className: 'btn btn-primary btn-sm',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },

            {
                extend: 'print',
                className: 'btn btn-primary btn-sm',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },

            // 'pageLength', 'colvis',
            // 'copy', 'csv', 'excel', 'print'

        ],
    });

</script>
@endsection

@section('sweetalert')
@if(Session::get('create'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Check In Berhasil',
        });

    </script>
@endif
@if(Session::get('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Sudah Ada',
        });

    </script>
@endif
@if(Session::get('sudahlogin'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Anda Sudah Login',
        });

    </script>
@endif
@if(Session::get('datatidakada'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data Tidak Ada',
        });

    </script>
@endif
@if(Session::get('belumlunas'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Pembayaran Belum Lunas',
        });

    </script>
@endif

@endsection
