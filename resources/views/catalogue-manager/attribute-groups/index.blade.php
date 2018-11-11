@extends('hub::layout', [
    'title' => trans('catalogue.attributeGroups'),
])
@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>{{trans('catalogue.attributeGroups')}}</h1>
@endsection

@section('header_actions')
    <candy-attribute-group-create></candy-attribute-group-create>
@stop

@section('content')
    <candy-attribute-groups-table></candy-attribute-groups-table>
@endsection