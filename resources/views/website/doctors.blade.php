@extends('layouts.main')

@push('extra-css')
<link rel="stylesheet" href="../css/doctors.css">
@endpush 

@section('content')
    <!-- Main Title -->
    <div class="container">
        <div class="top1">
            <div class="one">
                <h3>طاقم الأطباء</h3>
            </div>
            <div class="two"></div>
            <div class="three"></div>
        </div>
    </div>
    <!-- End Main Title -->

    <!-- Start Doctors Section -->
    <div class="doctors">
        <div class="container">
            <div class="row">
                @foreach($doctors as $doctor)
                <div class="col-sm-4 item-doc pb-5">
                    <a href="{{ route('web.doctors.show', $doctor->id) }}">
                        <img class="item-img rounded-circle"
                            src="../imgs/doctor-with-his-arms-crossed-white-background_1368-5790.jpg">
                        <h3>د/{{ $doctor->name }}</h3>
                        <p class="text-black-50">{{ $doctor->getDocSpecialty() }}</p>
                    </a>
                </div>
                @endforeach
            </div><!-- /.row -->
        </div>
    </div>
    <!-- End Doctors Section -->
@endsection