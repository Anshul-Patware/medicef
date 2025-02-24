@extends('frontend.layout.main')
@section('container')
    @include('frontend.TMS.head')




    {{-- ======================================
                MANAGE QUESTION BANK
    ======================================= --}}
    <div id="manage-quizzes">
        <div class="container-fluid">

            <div class="create-block">
                <a href="{{ route('quize.create') }}">
                    <i class="fa-solid fa-plus"></i>&nbsp;Create Quiz
                </a>
            </div>

            <div class="inner-block quiz-table">
                <div class="main-head">
                    <div>Quiz</div>
                    {{-- <div>
                        <button>Print</button>
                    </div> --}}
                </div>
                <div class="inner-block-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($data))
                        @foreach ($data as $temp)
                            <tr>
                                <td>{{ $temp->title }}</td>
                                <td>{{ $temp->description }}</td>
                                <td>{{ $temp->category }}</td>
                                <td>{{ $temp->status }}</td>
                                <td>
                                    <div class=" btn btn action-buttons">
                                    <a href="{{ route('quize.edit', $temp->id) }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    
                                        <form action="{{ route('quize.destroy', $temp->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"><i class=" fa fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            </div>

        </div>
    </div>
    <style>
    .inner-block-content {
        padding: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .table th, .table td {
        padding: 15px;
        text-align: left;
    }

    .table th {
        background-color: #007bff;
        color: white;
        font-weight: 600;
       
    }

    .table td {
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table thead {
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .action-buttons form,
    .action-buttons a {
        margin: 0;
    }

    .action-buttons button {
        background-color: #dc3545;
        border: none;
        color: #ffffff;
        padding: 6px 6px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
    }

    .action-buttons button:hover {
        background-color: #c82333;
    }

    .action-buttons a {
        background-color: #007bff;
        color: #ffffff;
        padding: 6px 6px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .action-buttons a:hover {
        background-color: #0056b3;
    }

    .action-buttons i {
        margin-right: 5px; 
    }
</style>
@endsection
