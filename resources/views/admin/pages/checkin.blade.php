@extends('admin.layout.main')

@section('title', 'Checkin Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Data User</h2>
            {{-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool,
                    built upon the foundations of progressive enhancement, that adds all of these advanced features to any
                    HTML table. </p> --}}

            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span>
                                    </button>


                                    <?php
                                        
                                        $nomer = 1;
                                        
                                        ?>

                                    @foreach($errors->all() as $error)
                                        <li>{{ $nomer++ }}. {{ $error }}</li>
                                    @endforeach
                                </div>
                            @endif
                            <!-- table -->
                            <table class="table datatables responsive nowrap" style="width:100%" id="dataTable-1">
                                <div class="align-right text-right mb-3">
                                    <!-- <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button> -->
                

                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Paket</th>
                                        <th>Harga</th>
                                        <th>Status</th>

                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($checkin as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->phone }}</td>
                                            <td>{{ $data->namepaket }}</td>
                                            <td>Rp. {{ number_format($data->harga) }}</td>
                                            <td>{{ $data->status }}</td>

                                        </tr>


                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    <div id="reader" width="100px" height="100px"></div>
</div> <!-- .container-fluid -->

@endsection

@section('script')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {

        $('#reader').val(decodedText);
        let id = decodedText;

        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/checkin",
            type: "POST",
            data: {
                _token: csrf_token,
                pendaftaran_id: id,
            },
            success: function (response) {
                console.log(response);
                if (response == "success") {
                    Swal.fire({
                        title: 'Berhasil',
                        text: "Checkin Berhasil",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                } else {
                    Swal.fire({
                        title: 'Berhasil',
                        text: "Checkin Gagal",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
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
