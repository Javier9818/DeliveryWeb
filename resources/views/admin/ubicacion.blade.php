@extends('layouts.admin')
@section('title') Configuraciones  @endsection
@section('nav')
    {{-- @include('admin.components.nav') --}}
@endsection

@section('sideNav')
    <x-side-nav tab="7" selected='2'/>
@endsection

@section('header')
    <div class="content-header row">
        <div class="content-header-left col-md-4 col-12 mb-2">
            <h3 class="content-header-title">Ubicación del negocio</h3>
        </div>
        <div class="content-header-right col-md-8 col-12">
            <div class="breadcrumbs-top float-md-right">
                <div class="breadcrumb-wrapper mr-1">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/intranet">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">Ubicación del negocio
                    </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <ubicacion-component></ubicacion-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        let empresa = @json($empresa);
    </script>
@endsection
