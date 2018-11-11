@extends('hub::layout', [
    'title' => trans('order.order'),
])

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.orderProcessing')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;" override="save-order">{{trans('order.save')}} {{trans('order.order')}}</candy-button>
@stop


@section('content')
    <candy-order-edit id="{{ $id }}"></candy-order-edit>
@endsection