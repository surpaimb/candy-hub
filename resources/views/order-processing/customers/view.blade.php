@extends('hub::layout', [
    'title' => trans('customer')
])

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.orderProcessing')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-customer-impersonate customer-id="{{ $id }}" style="display: inline-block;" override="save-customer"></candy-customer-impersonate>
    <candy-button style="display: inline-block;" override="save-customer">{{trans('order.save')}} {{trans('order.customer')}}</candy-button>
@stop

@section('content')
    <candy-customer-edit id="{{ $id }}"></candy-customer-edit>
@endsection