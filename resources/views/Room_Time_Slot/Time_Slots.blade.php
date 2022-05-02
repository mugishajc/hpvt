@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>Room Time Availablity</h1>   
         
        
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    @can('visitors_create')
                        <div class="card-header">
                            <a href="{{ route('create_slot') }}" class="btn btn-icon icon-left btn-primary"><i
                                    class="fas fa-plus"></i> Add Room Time Slot</a>
                        </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                           


                            <table class="table table-striped" id="datatable">
                                <thead>
                                <tr>
                                    <th width="5px">ID</th>
                                    <th>Room name</th>
                                    <th>Day</th>
                                    <th>Time Slots</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                
                                    @foreach ($data as $ploti)
                                    <tr>
                                    <td>#{{ $ploti->id }}</td>
                                    <td>{{ $ploti->room_name}}</td>
                                    <td>{{ $ploti->day }}</td>
                                    <td><button class="btn  {{ ($ploti->status == 'available')
                                        ?'btn-primary':'btn-danger'
                                        
                                  }} waves-effect waves-light">{{$ploti->check_in_time}} - {{ $ploti->check_out_time}} &nbsp; <i id="loading" class="fa fa fa-spin"></i></button>
                
                                    </td>
                                    <td class="text-primary">{{ $ploti->status}}</td>
                                    <td>
                                      Allowed number of Visitors:  {{ $ploti->number_visitors}} <br>

                                       Support number : {{ $ploti->room_support_number}} <br><br>
                                       Note : {{ $ploti->note}}

                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/visitor/index.js') }}"></script>
@endsection
