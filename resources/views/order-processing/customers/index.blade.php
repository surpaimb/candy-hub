@extends('hub::layout', [
    'title' => trans('order.customers')
])

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.title')}}</small>
    <h1>{{trans('order.customers')}}</h1>
@endsection

@section('header_actions')
    <candy-customer-create style="display: inline-block;"></candy-customer-create>
@endsection


@section('content')
    <candy-customers-table></candy-customers-table>
@endsection