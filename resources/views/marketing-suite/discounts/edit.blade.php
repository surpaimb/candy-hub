@extends('hub::layout', [
    'title' => trans('marketing.editDiscount'),
])

@section('side_menu')
    @include('hub::marketing-suite.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('marketing.title'}}</small>
    <h1>{{trans('marketing.editDiscount')}}</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;" event="save-discount">{{trans('marketing.save')}} {{trans('marketing.discount')}}</candy-button>
@stop

@section('content')
    <candy-edit-discount id="{{ $id }}"></candy-edit-discount>
@stop

