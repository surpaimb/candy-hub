@extends('hub::layout', [
    'title' => trans('editProduct'),
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;">{{trans('catalogue.save')}} {{trans('catalogue.product')}}</candy-button>
    <candy-delete
      element="product"
      endpoint="/products/{{ $id }}"
      id="{{ $id }}"
      redirect="/{{ config('getcandy.hub_prefix', 'hub') }}/catalogue-manager/products"
      style="display: inline-block;"
    ></candy-delete>
@endsection

@section('content')
  <candy-product-edit product-id="{{ $id }}"></candy-product-edit>
@endsection