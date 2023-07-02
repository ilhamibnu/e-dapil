@extends('admin.layout.main')

@section('title', 'Report')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Report</h2>
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
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button>
                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Caleg</th>
                                        <th>Total Suara</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($bypemilih as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->caleg }}</td>
                                            <td>{{ $data->total }}</td>

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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Report</h2>
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
                            <table class="table datatables responsive nowrap" style="width:100%" id="dataTable-2">
                                <div class="align-right text-right mb-3">
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button>
                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Caleg</th>
                                        <th>Desa</th>
                                        <th>TPS</th>
                                        <th>Nama Relawan</th>
                                        <th>Total Suara</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($byrelawan as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->caleg }}</td>
                                            <td>{{ $data->desa }}</td>
                                            <td>{{ $data->tps }}</td>
                                            <td>{{ $data->relawan }}</td>
                                            <td>{{ $data->total }}</td>
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Report</h2>
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
                            <table class="table datatables responsive nowrap" style="width:100%" id="dataTable-3">
                                <div class="align-right text-right mb-3">
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button>
                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Caleg</th>
                                        <th>Nama Desa</th>
                                        <th>TPS</th>
                                        <th>Total Suara</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($bytps as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->caleg }}</td>
                                            <td>{{ $data->desa }}</td>
                                            <td>{{ $data->tps }}</td>
                                            <td>{{ $data->total }}</td>
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Report</h2>
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
                            <table class="table datatables responsive nowrap" style="width:100%" id="dataTable-4">
                                <div class="align-right text-right mb-3">
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button>
                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Caleg</th>
                                        <th>Nama Desa</th>
                                        <th>Total Suara</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($bydesa as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->caleg }}</td>
                                            <td>{{ $data->desa }}</td>
                                            <td>{{ $data->total }}</td>
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Report</h2>
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
                            <table class="table datatables responsive nowrap" style="width:100%" id="dataTable-5">
                                <div class="align-right text-right mb-3">
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#addModal">Add</button>
                                </div>

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Caleg</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Total Suara</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($bykecamatan as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->caleg }}</td>
                                            <td>{{ $data->kecamatan }}</td>
                                            <td>{{ $data->total }}</td>
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
<script>
    $('#dataTable-2').DataTable({
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
<script>
    $('#dataTable-3').DataTable({
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
<script>
    $('#dataTable-4').DataTable({
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
<script>
    $('#dataTable-5').DataTable({
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
@if(Session::get('update'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Data Berhasil Di Update',
        });

    </script>
@endif
@if(Session::get('delete'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Data Berhasil Di Hapus',
        });

    </script>
@endif
@if(Session::get('create'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Data Berhasil Di Tambahkan',
        });

    </script>
@endif
@if(Session::get('gagal'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good',
            text: 'Data Gagal Di Tambahkan',
        });

    </script>
@endif

@endsection
