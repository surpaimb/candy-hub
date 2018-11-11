@extends('hub::layout', [
    'title' => trans('catalogue.products'),
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>{{trans('catalogue.products')}}</h1>
@endsection

@section('header_actions')
    <candy-product-create style="display: inline-block;"></candy-product-create>
@endsection

@section('content')
  <candy-products-table></candy-products-table>
@endsection