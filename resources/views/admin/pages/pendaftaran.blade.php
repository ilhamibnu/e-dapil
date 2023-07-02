@extends('admin.layout.main')

@section('title', 'Data Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Data Pendaftaran</h2>
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

                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Tiket</th>
                                        <th>Paket</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Checkin</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($pendaftaran as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->phone }}</td>
                                            <td>{{ $data->tiket }}</td>
                                            <td>{{ $data->paket->name }}</td>
                                            <td>Rp. {{ number_format($data->paket->harga) }}</td>
                                            <td>

                                                @if($data->status == 'paid')
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Bayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($data->checkin == 'sudah')
                                                    <span class="badge badge-success">Checkin</span>
                                                @else
                                                    <span class="badge badge-danger">Belum Checkin</span>
                                                @endif
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
</div> <!-- .container-fluid -->
@endsection

@section('script')
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

{{-- @section('sweetalert')
@if(Session::get('update'))
    <script>
        Swal.fire(
            'Success',
            'Data Berhasil Di Update',
            'success'
        )

    </script>
@endif
@if(Session::get('delete'))
    <script>
        Swal.fire(
            'Success',
            'Data Berhasil Di Hapus',
            'success'
        )

    </script>
@endif
@if(Session::get('create'))
    <script>
        Swal.fire(
            'Success',
            'Data Berhasil Ditambahkan',
            'success'
        )

    </script>
@endif
@if(Session::get('gagal'))
    <script>
        Swal.fire(
            'Success',
            'Data Gagal Ditambahkan',
            'error'
        )

    </script>
@endif

@endsection--}}
