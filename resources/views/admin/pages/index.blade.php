@extends('admin.layout.main')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title">Welcome!</h2>
                </div>
                {{-- <div class="col-auto">
                        <form class="form-inline">
                            <div class="form-group d-none d-lg-inline">
                                <label for="reportrange" class="sr-only">Date Ranges</label>
                                <div id="reportrange" class="px-2 py-2 text-muted">
                                    <span class="small"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm"><span
                                        class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                                <button type="button" class="btn btn-sm mr-2"><span
                                        class="fe fe-filter fe-16 text-muted"></span></button>
                            </div>
                        </form>
                    </div> --}}

            </div>
            <div class="mb-2 align-items-center">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="chartbox mr-4">
                            <div id="lineChart2"></div>
                        </div>
                    </div> <!-- .card-body -->
                </div> <!-- .card -->
            </div>


        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
@endsection

@section('script')
<script>


    var lineChart,
        lineChartoptions = {
            series: [{
                name: "Jumlah Suara",
                data: datatanggal
            }],
            chart: {
                height: 350,
                type: "line",
                background: !1,
                zoom: {
                    enabled: !1
                },
                toolbar: {
                    show: !1
                },
            },
            theme: {
                mode: colors.chartTheme
            },
            stroke: {
                show: !0,
                curve: "smooth",
                lineCap: "round",
                colors: chartColors,
                width: [3, 2, 3],
                dashArray: [0, 0, 0],
            },
            dataLabels: {
                enabled: !1
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: "bottom",
                        offsetX: -10,
                        offsetY: 0
                    },
                },
            }, ],
            markers: {
                size: 4,
                colors: base.primaryColor,
                strokeColors: colors.borderColor,
                strokeWidth: 2,
                strokeOpacity: 0.9,
                strokeDashArray: 0,
                fillOpacity: 1,
                discrete: [],
                shape: "circle",
                radius: 2,
                offsetX: 0,
                offsetY: 0,
                onClick: void 0,
                onDblClick: void 0,
                showNullDataPoints: !0,
                hover: {
                    size: void 0,
                    sizeOffset: 3
                },
            },
            xaxis: {
                // type: "datetime",
                categories: datapenghasilan,
                labels: {
                    show: !0,
                    trim: !1,
                    minHeight: void 0,
                    maxHeight: 120,
                    style: {
                        colors: colors.mutedColor,
                        cssClass: "text-muted",
                        fontFamily: base.defaultFontFamily,
                    },
                },
                axisBorder: {
                    show: !1
                },
            },
            yaxis: {
                labels: {
                    show: !0,
                    trim: !1,
                    offsetX: -10,
                    minHeight: void 0,
                    maxHeight: 120,
                    style: {
                        colors: colors.mutedColor,
                        cssClass: "text-muted",
                        fontFamily: base.defaultFontFamily,
                    },
                },
            },
            legend: {
                position: "top",
                fontFamily: base.defaultFontFamily,
                fontWeight: 400,
                labels: {
                    colors: colors.mutedColor,
                    useSeriesColors: !1
                },
                markers: {
                    width: 10,
                    height: 10,
                    strokeWidth: 0,
                    strokeColor: colors.borderColor,
                    fillColors: chartColors,
                    radius: 6,
                    customHTML: void 0,
                    onClick: void 0,
                    offsetX: 0,
                    offsetY: 0,
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0
                },
                onItemClick: {
                    toggleDataSeries: !0
                },
                onItemHover: {
                    highlightDataSeries: !0
                },
            },
            grid: {
                show: !0,
                borderColor: colors.borderColor,
                strokeDashArray: 0,
                position: "back",
                xaxis: {
                    lines: {
                        show: !1
                    }
                },
                yaxis: {
                    lines: {
                        show: !0
                    }
                },
                row: {
                    colors: void 0,
                    opacity: 0.5
                },
                column: {
                    colors: void 0,
                    opacity: 0.5
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
        },
        lineChart = document.querySelector("#lineChart2");
    lineChart &&
        (lineChart = new ApexCharts(lineChart, lineChartoptions)).render();

</script>
@endsection


@section('sweetalert')
@if(Session::get('loginberhasil'))
    <script>
        Swal.fire("Well Done", "Anda Berhasil Login", "success");

    </script>
@endif

@if(Session::get('updateprofil'))
    <script>
        Swal.fire("Well Done", "Profil Berhasil Diperbarui", "success");

    </script>
@endif

@if(Session::get('updateprofilerror'))
    <script>
        Swal.fire("Opps!!", "Password Anda Salah", "error");

    </script>
@endif

@if(Session::get('passwordtidaksama'))
    <script>
        Swal.fire("Opps!!", "Konfirmasi Password Anda Salah", "error");

    </script>
@endif

@if(Session::get('sudahlogin'))
    <script>
        Swal.fire("Notice", "Anda Masih Login", "success");

    </script>
@endif
@endsection
