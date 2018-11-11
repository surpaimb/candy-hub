@extends('hub::layout', [
    'title' => trans('marketing.discounts'),
])
@section('side_menu')
    @include('hub::marketing-suite.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('marketing.title')}}</small>
    <h1>{{trans('marketing.discounts')}}</h1>
@endsection

@section('header_actions')
    <candy-create-discount style="display: inline-block;"></candy-create-discount>
@endsection

@section('content')
    <candy-discounts-table></candy-discounts-table>
@endsection