@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>New Room Time Availablity</h1>   
         
        
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <form action="{{ route('store_slots') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                

                                <div class="form-group col">
                                    <label for="employee_id">Select Room</label> <span class="text-danger">*</span>
                                    <select id="room_name" name="room_name" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                        @foreach($employees as $key => $employee)
                                            <option value="{{ $employee->name }}">{{ $employee->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="last_name">Select Day</label> <span class="text-danger">*</span>
                                    <select name="day" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                        <option value="Sunday">Sunday</option>
                                        
                                    </select>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Room Status</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control select2 @error('employee_id') is-invalid @enderror">
                                        <option value="available">Available</option>
                                        <option value="Renovation">Construction or Renovation Going on</option>
                                        <option value="busy">busy</option>
                                        <option value="closed">Closed</option>
                                         
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label>Room Support Phone</label> <span class="text-danger">*</span>
                                    <input type="number" required name="room_support_number" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Checkin Time</label> <span class="text-danger">*</span>
                                    <input type="time"name="check_in_time" class="form-control @error('expected_date') is-invalid @enderror" >
                                    @error('expected_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col">
                                    <label for="expected_time">Checkout Time</label> <span class="text-danger">*</span>
                                    <input  type="time" name="check_out_time"
                                           class="form-control  timepicker @error('expected_time') is-invalid @enderror">
                                    @error('expected_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-6">
                                    <label>Note</label> <span class="text-danger">*</span><br>
                                    <textarea  rows="4" cols="50"  name="note" >

                                    </textarea>
                                </div>
                                <div class="col-6">
                                    <label>Number of Visitors</label> <span class="text-danger">*</span><br>
                                    <input type="number"name="number_visitors" class="form-control @error('expected_date') is-invalid @enderror" >
                                   
                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer ">
                            <button class="btn btn-primary mr-1" type="submit">Save</button>
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
