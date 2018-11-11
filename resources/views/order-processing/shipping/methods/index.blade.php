@extends('hub::layout', [
    'title' => trans('order.shippingMethods'),
])

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.orderProcessing')}}</small>
    <h1>{{trans('order.shippingMethods')}}</h1>
@endsection

@section('header_actions')
    <candy-shipping-method-create style="display: inline-block;"></candy-shipping-method-create>
@endsection

@section('content')
    <candy-shipping-methods-table></candy-shipping-methods-table>
@endsection