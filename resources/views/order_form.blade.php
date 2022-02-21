<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Form</title>
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <div class="card-title">
                    <h4>Order Form</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                            href="#custom-tabs-four-home" role="tab"
                                            aria-controls="custom-tabs-four-home" aria-selected="true">New Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-four-profile" role="tab"
                                            aria-controls="custom-tabs-four-profile" aria-selected="false">Order
                                            List</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab">
                                        @if (session('message'))
                                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                </symbol>
                                            </svg>
                                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                                    aria-label="Success:">
                                                    <use xlink:href="#check-circle-fill" />
                                                </svg>
                                                <div>
                                                    {{ session('message') }}
                                                </div>
                                            </div>
                                        @endif
                                        <form action="/" method="POST">
                                            @csrf
                                            <div class="input-group mb-4">
                                                <input type="text" name="search" class="d-inline form-control">
                                                <input type="submit" value="Search" class="btn btn-primary d-inline">
                                            </div>
                                        </form>
                                        <form action="{{ route('order.submit') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                @foreach ($dishes as $dish)
                                                    <div class="col-12 col-md-4">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img src="{{ url('/images/' . $dish->image) }}"
                                                                    class="img-fluid"><br>
                                                                <label for="">{{ $dish->name }}</label>
                                                                <input type="number" name="{{ $dish->id }}"
                                                                    class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <label>Table</label>
                                            <div class="form-group mb-0">
                                                <select name="table_id" class="form-control d-inline"
                                                    style="width: 70px">
                                                    @foreach ($tables as $table)
                                                        <option value="{{ $table->id }}">{{ $table->number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="submit" value="submit" class="btn btn-primary"
                                                    value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-profile-tab">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>#</th>
                                                <th>Dish</th>
                                                <th>Table Id</th>
                                                <th>Status</th>
                                                <th style="width: 100px">Action</th>
                                             </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $order->dish->name }}</td>
                                                        <td>{{ $order->table_id }}</td>
                                                        <td>{{ $status[$order->status] }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="/order/{{ $order->id }}/serve"
                                                                    class="btn btn-success">Serve</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</body>

</html>
