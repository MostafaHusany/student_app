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
    
    <div class="container my-4">
        
        <div class="row">
        @if(session()->has('success'))
            <div class="col-12 my-2">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        </div>

        <div class="row">
            
            <div class="col-md-4">
                <div class="card card-body">
                    <img src="../imgs/doctor-holding-up-bottle-with-tablets-pills-treatment.jpg" class="img-thumbnail" alt="...">
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-body" style="display: block">
                    <h2>{{ $doctor->name }}</h2>
                    <p class="fw-bold">
                        {{ $doctor->description }}
                    </p>
                    
                    <h3>المواعيد المتاحة</h3>
                    <hr/>
                    <div class="row">
                        <div class="col-6">
                        @if(sizeof($doctor->doctor_schedule))
                            @foreach($doctor->doctor_schedule as $day)
                            <span class="badge bg-info text-dark">{{ $day->day }}</span>
                            @endforeach
                        @else 
                            <span>---</span>
                        @endif
                        </div>
                        <div class="col-6 text-start">
                            @auth()
                                @if(auth()->user()->user_meetings()->where('doctor_id', $doctor->id)->where('date', '>', Date('Y-m-d'))->count() )
                                <button class="btn btn-outline-dark" disabled="disabled" class="btn btn-primary">جاري تاكيد الحجز</button>
                                @else
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary">تحديد مواعيد</button>
                                @endif
                            @else
                                <a href="{{ url('login') }}" class="btn btn-outline-dark">تسجيل دخول</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr/>
        
        @auth()
        <div class="card card-body">
            <form action="{{ route('web.doctors.comment.store', $doctor->id) }}" method="POST">
                @csrf
                <legend>اضافة تعليق</legend>
                <textarea name="comment" required="required" class="form-control"></textarea>
                <button class="btn btn-primary mt-3 float-start">اضافة تعليق</button>
            </form>
        </div>
        @endauth

        <div class="card card-body mt-4">
            @foreach($doctor->doctor_comments as $comment)
            <hr/>

            <div class="row">
                <div class="col-md-3 text-center">
                    <img style="border-radius: 50%;width: 150px;" src="../imgs/doctor-with-his-arms-crossed-white-background_1368-5790.jpg" class="img-thumbnail" alt="...">
                    <h4>{{ $comment->user->name }}</h4>
                </div>
                <div class="col-md-8">
                    <p>{{ $comment->comment }}</p>
                </div>
                @auth()
                <form action="{{ route('web.doctors.comment.destroy', $comment->id) }}" method="POST" class="col-md-1 text-start">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </form>
                @endauth
            </div><!-- /.row -->
            @endforeach
        </div>
    </div><!-- /.container -->
    
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('request_date', $doctor->id) }}" method="POST">
                        @csrf 
                        <legend>حجز موعد</legend>
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                        <div class="form-group my-3">
                            <input type="date" name="date" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">حجز الموعد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection