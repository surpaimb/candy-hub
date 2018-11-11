@extends('hub::layout', [
    'title' => trans('catalogue.editCollection'),
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-delete
      element="collection"
      endpoint="/collections/{{ $id }}"
      id="{{ $id }}"
      redirect="/{{ config('getcandy.hub_prefix', 'hub') }}/catalogue-manager/collections"
      redirect="/hub/catalogue-manager/collections"
      style="display: inline-block;"
    ></candy-delete>
    <candy-button style="display: inline-block;" event="save-collection">{{trans('catalogue.save')}}</candy-button>
@endsection

@section('content')
  <candy-collection-edit id="{{ $id }}"></candy-collection-edit>
@endsection