@extends('frontend.layouts.frontend')

@section('content')
    <!-- Default Page -->
    <section id="pm-banner-1" class="custom-css-step">
        <div class="container">
            <div class="card" style="margin-top:40px;" >
                <div class="card-header" id="Details" align="center">
                    <h4 style="color: #111570;font-weight: bold">Register new Visitor Account</h4>
                </div>
               
<div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('register_visitor') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="first_name">First name </label> <span class="text-danger">*</span>
                                        <input id="first_name" required type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? " is-invalid " : '' }}" value="{{ old('first_name') }}">
                                        @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="last_name"> Lastname</label> <span class="text-danger">*</span>
                                        <input id="last_name" type="text" required name="last_name" class="form-control {{ $errors->has('last_name') ? " is-invalid " : '' }}" value="{{ old('last_name') }}">
                                        @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('E-Mail Address') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('Phone') }}</label> <span class="text-danger">*</span>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                       <input type="hidden" autocomplete="off" id="date-picker" name="date_of_joining" class="form-control @error('date_of_joining') is-invalid @enderror" value="{{ old('date_of_joining') }}">
                                        @error('date_of_joining')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="gender">{{ __('Gender') }}</label> <span class="text-danger">*</span>
                                        <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                            @foreach(trans('genders') as $key => $gender)
                                                <option value="{{ $key }}" {{ (old('gender') == $key) ? 'selected' : '' }}>{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                                

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>{{ __('Password') }}</label> <span class="text-danger">*</span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('Confirm Password') }}</label> <span class="text-danger">*</span>
                                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="about">{{ __('About') }}</label>
                                        <textarea name="about"
                                                  class="summernote-simple form-control height-textarea @error('about')
                                                  is-invalid @enderror"
                                                  id="about" >
                                            {{ old('about') }}
                                        </textarea>
                                        @error('about')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    {{--  <div class="form-group col">
                                        <label for="customFile">{{ __('Image') }}</label>
                                        <div class="custom-file">
                                            <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
                                            <label  class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                                        </div>
                                        @if ($errors->has('image'))
                                            <div class="help-block text-danger">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                       <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/user.png') }}" alt="your image"/>
                                    </div>  --}}
                                </div>
                            </div>

                            <div class="card-footer ">
                                <button class="btn btn-primary mr-1" type="submit">Register</button>

                                <button class="btn btn-danger mr-1" type="reset">Cancel</button>

                            </div>
                        </form>
                    </div>
                </div>

                
            </div>
        </div>
    </section>
@endsection

