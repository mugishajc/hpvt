@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>New Visitors</h1>   
         
        {{ Breadcrumbs::render('visitors') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    @can('visitors_create')
                        <div class="card-header">
                            <a href="{{ url('admin/visitors') }}" class="btn btn-icon icon-left btn-warning"><i
                                    class="fas fa-undo"></i> Back</a>
                        </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                           
                            <form action="{{ route('check_slots') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                   
                                    <div class="form-row">
                                       
                                        <div class="form-group col">
                                            <label>Pick a Date</label> <span class="text-danger">*</span>
                                            <input type="date" required name="check_in_date" class="form-control @error('expected_date') is-invalid @enderror" >
                                        </div>
                                        {{--  <div class="form-group col">
                                            <label>Choose Day</label> <span class="text-danger">*</span>
                                            <select name="check_day" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                                <option disabled>Choose visiting day</option>

                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                                
                                            </select>
                                        </div>  --}}

                                        <div class="form-group col">
                                            <label for="employee_id">Select Patient</label> <span class="text-danger">*</span>
                                             <select id="employee_id" name="employee_id" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                                @foreach($employees as $key => $employee)
                                                    <option value="{{ $employee->id }}" {{ (old('employee_id') == $employee->id) ? 'selected' : '' }}>{{ $employee->id }}.{{ $employee->name }} </option>
                                                @endforeach
                                            </select> 
    
                      
                                            
                                        </div>


                                        <div class="form-group col">
                                            <label for="expected_time">Choose Time Slot</label> <span class="text-danger">*</span>
                                            <select name="check_time_slot" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                                <option disabled>Please choose visiting time slot</option>
                                                @foreach ($Slots as $slot)
                                                    
                                                
                                                <option value="{{ $slot->check_in_time }} - {{ $slot->check_out_time }}">{{ $slot->check_in_time }} - {{ $slot->check_out_time }}</option>
                                               


                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
    
                                </div>
    
                                <div class="card-footer ">
                                    <button class="btn btn-success mr-1" type="submit">Continue</button>
                                    <button class="btn btn-danger mr-1" type="reset">Cancel</button>
                                </div>
                            </form>

                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
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
