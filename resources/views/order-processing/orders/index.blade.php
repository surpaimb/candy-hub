@extends('hub::layout', [
    'title' => trans('order.orders'),
])

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.title')}}</small>
    <h1>{{trans('order.orders')}}</h1>
@endsection

@section('content')
    <candy-orders-table></candy-orders-table>
@endsection