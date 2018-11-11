@extends('hub::layout', [
    'title' => trans('catalogue.editAttributeGroup'),
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.settings')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;" event="save-attribute">{{trans('catalogue.save')}}</candy-button>
@stop


@section('content')
    <candy-attribute-groups-edit id="{{ $id }}"></candy-attribute-groups-edit>
@endsection