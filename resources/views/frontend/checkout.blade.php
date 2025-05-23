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
				سبد خرید
			</span>
        </div>
    </div>


    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85">
        <div class="container">
            @include('errors.message')
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div>
                        @if(count($products) > 0)
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">محصول</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">قیمت</th>
                                </tr>
                                @foreach ($products as $id =>$product)
                                <tr class="table_row"> 
                                    <td class="column-1">
                                        <form action="{{route('frontend.basket.remove', $id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="how-itemcart1">
                                                <img src="/storage/{{$product['demo_url']}}" alt="IMG">
                                            </button>
                                        </form>
                                    </td>
                                    <td class="column-2">{{$product['title']}}</td>
                                    <td class="column-3">{{number_format($product['price'])}} تومان</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        @endif
                        @if(count($products) == 0)
                            <div class="alert alert-danger">
                                سبد خرید شما خالی است
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            اطلاعات کاربری
                        </h4>

                        <form action="{{route('frontend.payment.pay')}}" method="post">
                            @csrf
                            <div class="flex-w flex-t">
                                <div class="w-full">
                                    <div class="p-t-15">

                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" placeholder="نام و نام خانوادگی">
                                        </div>
                                        <div class="bor8 bg0 m-b-12">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="mobile" placeholder="موبایل">
                                        </div>

                                        <div class="bor8 bg0 m-b-22">
                                            <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="email" placeholder="ایمیل">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="flex-w flex-t p-t-10 p-b-33">
                                <div class="size-208">
								<span class="mtext-101 cl2">
									جمع پرداختی:
								</span>
                                </div>

                                <div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									{{number_format($totalPrice)}} تومان
								</span>
                                </div>
                            </div>

                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" type="submit">
                                رفتن به صفحه پرداخت
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection