@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('order.orderProcessing')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;" override="save-shipping-zone">{{trans('order.save')}} {{trans('order.zone')}}</candy-button>

@stop


@section('content')
    <candy-shipping-zone-edit id="{{ $id }}"></candy-shipping-zone-edit>
@endsection