@extends('hub::layout', [
    'title' => trans('catalogue.collections'),
])
@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>{{trans('catalogue.collections')}}</h1>
@endsection

@section('header_actions')
    <candy-collection-create style="display: inline-block;"></candy-collection-create>
@endsection

@section('content')
    <candy-collections-table></candy-collections-table>
@endsection