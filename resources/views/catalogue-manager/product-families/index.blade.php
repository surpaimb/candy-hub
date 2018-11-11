@extends('hub::layout', [
    'title' => trans('catalogue.productFamilies'),
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>{{trans('catalogue.productFamilies')}}</h1>
@endsection

@section('header_actions')
    <candy-product-family-create></candy-product-family-create>
@stop

@section('content')
    <candy-product-families-table></candy-product-families-table>
@endsection