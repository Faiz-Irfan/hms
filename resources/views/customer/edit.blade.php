@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- @dd($fleet) --}}

                        <h5 class="card-title">Customer Details</h5>
                        <!-- Vertical Form -->
                        @php
                            $userId = session('user_id');
                        @endphp
                        <form action="{{ route('customer.update', $customer->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" class="" id="staff_id" name="staff_id"
                                    value="{{ $userId }}">
                                <input type="hidden" class="" id="customer_id" name="customer_id" value="">
                                {{-- Customer Detail --}}
                                <div class="col-6">
                                    <h4>Customer Info</h4>
                                    <div class="col-12">
                                        <label for="name" class="form-label">Customer Name</label>
                                        <input type="text" placeholder="Ahmad Irfan" class="form-control" name="name"
                                            id="name" value="{{ $customer->name }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" placeholder="ahmad@graduate.utm.my" class="form-control"
                                                name="email" id="email" value="{{ $customer->email }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="ic" class="form-label">IC Number/Passport </label>
                                            <input type="string" placeholder="000627101198" class="form-control"
                                                name="ic" id="ic" value="{{ $customer->ic }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="matric" class="form-label">Matric</label>
                                            <input type="text" placeholder="A24EC0021" class="form-control"
                                                name="matric" id="matric" value="{{ $customer->matric }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="phone" class="form-label">Mobile Number </label>
                                            <input type="number" class="form-control" name="phone" id="phone"
                                                value="{{ $customer->phone }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="college" class="form-label">College </label>
                                            <select class="form-control" name="college" id="college"
                                                value="{{ old('college') }}">
                                                @foreach ($colleges as $college)
                                                    <option value="{{ $college }}"
                                                        {{ $customer->college == $college ? 'selected' : '' }}>
                                                        {{ $college }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('college')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="faculty" class="form-label">Faculty </label>
                                            <select class="form-control" name="faculty" id="faculty"
                                                value="{{ old('faculty') }}">
                                                @foreach ($faculties as $item)
                                                    <option value="{{ $item }}"
                                                        {{ $customer->faculty == $item ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="address" class="form-label">Address </label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                value="{{ $customer->address }}">
                                        </div>

                                    </div>
                                    <div class="row pt-2">
                                        <h5>Bank Details</h5>
                                        <div class="col-md-6">
                                            <label for="bank" class="form-label">Bank</label>
                                            <select class="form-control" name="bank" id="bank"
                                                value="{{ old('bank') }}">
                                                @foreach ($banks as $item)
                                                    <option value="{{ $item }}"
                                                        {{ $customer->bank == $item ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="acc_num" class="form-label"> Account Number</label>
                                            <input type="text" placeholder="" class="form-control" name="acc_num"
                                                id="acc_num" value="{{ $customer->acc_num }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="acc_num_name" class="form-label"> Account Number</label>
                                            <input type="text" placeholder="" class="form-control"
                                                name="acc_num_name" id="acc_num_name"
                                                value="{{ $customer->acc_num_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4>IC/Passport</h4>
                                    <div class="col-12">
                                        <label for="photo" class="form-label">Upload Photo</label>
                                        <input type="file" class="form-control" name="photo" id="photo">
                                        @if ($customer->photo_ic)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $customer->photo) }}"
                                                    alt="Customer Photo" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('customer.index') }}" class="btn btn-primary">Back</a>

                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
