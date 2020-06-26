@extends('layouts.front')

@section('title')
    TeEnvio - Negocios locales a un click de distancia
@endsection

@section('nav')
    @include('front.nav')
@endsection

@section('contenido') 
<section id="slider" class="slider slider-layout1">
    <div class="container slide-item align-v-h text-center">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <div class="slide__content">
                    <!-- <span class="slide__subtitle d-none">Text</span> -->
                    <h2 class="slide__title  text-dark">Negocios locales a <span class="title__spam">un click</span> de <span class="title__spam">Distancia!</span></h2>
                    <div class="containLine"> <div class="line-low bg1 n600" style="visibility: visible;"></div> </div>
                    <p class="slide__desc"></p>
                    <form action="{{ route('list') }}" method="get">
                    <input type="text"  name="search" class="input__search" placeholder="Busca tu ciudad o restaurant favorito">
                    <button type="submit" class="btn btn__primary my-5"><i class="fa fa-map-marker-alt fa-2x" aria-hidden="true"></i>Buscar restaurantes o negocios cercanos</button>
                    </form>
                </div><!-- /.slide-content -->
            </div><!-- /.col-lg-12 -->

            {{-- <div class="col-sm-12 col-md-6 col-lg-6">
                <img src="/img/pedir.png"  alt="slide img">
            </div> --}}

        </div><!-- /.row -->
    </div><!-- /.container -->
    {{-- <div class="bg-img"><img src="/img/pedir5.png"></div> --}}
    {{-- <svg class="slider__divider-shape" xmlns="http://www.w3.org/2000/svg" width="22" height="61" viewBox="0 0 22 61">
        <path
            d="M799,769h2v61h-2V769Zm8,24.8a0.969,0.969,0,0,0-1.911,0,3.012,3.012,0,0,1-.883,2.16,4.486,4.486,0,0,0,0,6.136,3.083,3.083,0,0,1,0,4.32,4.486,4.486,0,0,0,0,6.136,3.088,3.088,0,0,1,0,4.325,4.5,4.5,0,0,0,0,6.142,3.014,3.014,0,0,1,.884,2.163,0.969,0.969,0,0,0,1.911,0,4.414,4.414,0,0,0-1.213-3.07,3.091,3.091,0,0,1,0-4.328,4.491,4.491,0,0,0,0-6.14,3.08,3.08,0,0,1,0-4.319,4.488,4.488,0,0,0,0-6.137,3.081,3.081,0,0,1,0-4.32A4.407,4.407,0,0,0,807,793.8Zm0-20a0.969,0.969,0,0,0-1.911,0,3.014,3.014,0,0,1-.883,2.16,4.486,4.486,0,0,0,0,6.136,3.083,3.083,0,0,1,0,4.32,4.488,4.488,0,0,0,0,6.137,3.087,3.087,0,0,1,0,4.324,4.5,4.5,0,0,0,0,6.142,3.014,3.014,0,0,1,.884,2.163,0.969,0.969,0,0,0,1.911,0,4.414,4.414,0,0,0-1.213-3.07,3.089,3.089,0,0,1,0-4.327,4.491,4.491,0,0,0,0-6.14,3.081,3.081,0,0,1,0-4.32,4.488,4.488,0,0,0,0-6.137,3.081,3.081,0,0,1,0-4.32A4.409,4.409,0,0,0,807,773.8ZM793,793.8a0.969,0.969,0,0,1,1.911,0,3.012,3.012,0,0,0,.883,2.16,4.486,4.486,0,0,1,0,6.136,3.083,3.083,0,0,0,0,4.32,4.486,4.486,0,0,1,0,6.136,3.088,3.088,0,0,0,0,4.325,4.5,4.5,0,0,1,0,6.142,3.014,3.014,0,0,0-.884,2.163,0.969,0.969,0,0,1-1.911,0,4.414,4.414,0,0,1,1.213-3.07,3.091,3.091,0,0,0,0-4.328,4.491,4.491,0,0,1,0-6.14,3.08,3.08,0,0,0,0-4.319,4.488,4.488,0,0,1,0-6.137,3.081,3.081,0,0,0,0-4.32A4.407,4.407,0,0,1,793,793.8Zm0-20a0.969,0.969,0,0,1,1.911,0,3.014,3.014,0,0,0,.883,2.16,4.486,4.486,0,0,1,0,6.136,3.083,3.083,0,0,0,0,4.32,4.488,4.488,0,0,1,0,6.137,3.087,3.087,0,0,0,0,4.324,4.5,4.5,0,0,1,0,6.142,3.014,3.014,0,0,0-.884,2.163,0.969,0.969,0,0,1-1.911,0,4.414,4.414,0,0,1,1.213-3.07,3.089,3.089,0,0,0,0-4.327,4.491,4.491,0,0,1,0-6.14,3.081,3.081,0,0,0,0-4.32,4.488,4.488,0,0,1,0-6.137,3.081,3.081,0,0,0,0-4.32A4.409,4.409,0,0,1,793,773.8Zm-4,5.2h2v41h-2V779Zm20,0h2v41h-2V779Z"
            transform="translate(-789 -769)"></path>
    </svg> --}}
</section><!-- /.slider -->
<section id="blogGrid" class="blog blog-grid  ">
<h3 class=" text-center">Lo que necesitas, a tu alcance</h3>

<front-categories-component></front-categories-component>
</section><!-- /.blog Grid -->
@endsection

@section('script')

@endsection
