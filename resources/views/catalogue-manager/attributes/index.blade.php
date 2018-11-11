@extends('hub::layout', [
    'title' => 'Attributes',
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>{{trans('catalogue.title')}}</small>
    <h1>{{trans('catalogue.attributes')}}</h1>
@endsection

@section('header_actions')
    <candy-attribute-create></candy-attribute-create>
@stop

@section('content')
    <candy-attributes-table></candy-attributes-table>
@endsection