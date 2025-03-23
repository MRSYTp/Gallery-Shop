@extends('layout.frontend.master')

@section('content')


    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-t-30">
            <a href="index.html" class="mtext-106 cl8 hov-cl1 trans-04">
                خانه
                <i class="fa fa-angle-left m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="mtext-106 cl4">
				بازگشت از درگار پرداخت
			</span>
        </div>
    </div>


    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 text-center">
                    <i class="fa fa-check-circle text-success d-block m-b-50 fs-80"></i>
                    <h1 class="text-success">پرداخت شما با موفقیت انجام شد</h1>
                    <span class="pt-4 d-block fs-21">لینک های دانلود به ایمیل شما ارسال گردید</span>
                </div>
            </div>
        </div>
    </form>

@endsection

