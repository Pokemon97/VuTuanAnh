@extends('layout.index')

@section('title', 'Giới thiệu')

@section('content')
<div class="container">

        @include('layout.slide')

        <div class="space20"></div>


        <div class="row main-left">
            @include('layout.menu')
           
            <div class="col-md-9">
                <div class="panel panel-default">            
                    <div class="panel-heading" style="background-color:#337AB7; color:white;" >
                        <h2 style="margin-top:0px; margin-bottom:0px;">Giới Thiệu</h2>
                    </div>
                        
                        <div class="break"></div>
                        <center><h4 class="contact-title"> Tác Giả: Vũ Tuấn Anh</h4></center>
                        <center><h2> Đại Học Bách Khoa Hà Nội</h2></center>

                        <center><h4><span class="glyphicon glyphicon-envelope"></span> Email : </h4></center>
                        <center><p>tuananh77717@gmail.com</p></center>

                        <center><h4><span class="glyphicon glyphicon-phone-alt"></span> Điện thoại : </h4></center>
                        <center><p>0961582848</p></center>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection