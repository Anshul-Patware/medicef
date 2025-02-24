<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        /* background: linear-gradient(to right, #eca73f, #fad0c4); */
        background: #eca73f;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 95%;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-height: 100%;
        /* Adjust the height as needed */
        overflow-y: auto;
        /* Enables vertical scrolling */
    }

    .progress-bar {
        display: flex;
        justify-content: space-between;
        gap: .5%;
        align-items: center;
        margin-bottom: 20px;
        flex-direction: row;
    }

    .progress-bar .step {
        width: 30%;
        text-align: center;
        padding: 10px;
        border-radius: 20px;
        background: #eee;
        color: #555;
    }

    .progress-bar .step.active {
        background: #6a67ce;
        color: #fff;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    input,
    textarea,
    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    button {
        background: #6a67ce;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #5a57b7;
    }

    /* Active step */
    .progress-bar .step.active {
        background-color: #65c168;
        color: white;
        cursor: pointer;

    }

    /* Hover effect */
    .progress-bar .step:hover {
        background-color: #79a3d0;
        color: white;
        cursor: pointer;
    }

    /* Transition effect */
    .progress-bar .step:not(.active):hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;

    }

    .prev-step {
        width: 30%
    }

    .next-step {

        width: 30%
    }

    .save_btn_all {
        width: 30%
    }



    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    tr{
        cursor: pointer;
    }
    th {
        background-color: #f2f2f2;
    }
</style>


<body>
    {{-- Flash message section --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @php
        use Carbon\Carbon;
    @endphp
    <div class="container">
        <div class="progress-bar">
            <div class="step active">Dashboard</div>
            <a href="{{ route('recall',1) }}" class="step" style="text-decoration: none">Insert Data</a>
        </div>

        <div>
            <table style="border: 1" width="30" id="myTable">
                <tr>
                    <th>Id</th>
                    <th>Division</th>
                    <th>Short Desc</th>
                    <th>Date Opened</th>
                    <th>Assigned To</th>
                    <th>Batch/Lot No</th>
                    <th>Depart Group</th>

                </tr>
                <tbody>
                    @foreach ($all_data as $index => $user)
                        {{-- <tr data-email="{{ $user->email }}" id="cli"> --}}
                        {{-- <td>{{ $index + 1 }}</td> --}}
                        <tr data-id="{{ $user->id }}">
                            <td> {{ $user->id }} </td>
                            <td> {{ $user->loca_code }}
                            </td>

                            <td> {{ $user->short_desc }} </td>

                            <td>
                                {{-- {{ $user->date_of_init }} --}}
                                {{ Carbon::createFromFormat('Y-m-d', $user->date_of_init)->format('d-M-Y') }}
                            </td>
                            <td>
                                {{ $user->assign_to }}
                            </td>
                            <td>
                                {{ $user->batch_lot_no }}
                            </td>

                            <td>
                                {{ $user->depart_group }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var rows = document.querySelectorAll("#myTable tr[data-id]");
            rows.forEach(function(row) {
                row.addEventListener("click", function() {
                    var id = row.getAttribute("data-id");
                    var baseUrl = "http://127.0.0.1:8000/recall_update";
                    var queryParams = new URLSearchParams({
                        id: id
                    });
                    var fullUrl = baseUrl + "?" + queryParams.toString();
                    window.location.href = fullUrl;
                });
            });
        });
    </script>
</body>

</html>
