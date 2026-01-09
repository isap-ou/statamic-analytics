@php use function Statamic\trans as __; @endphp

@extends('statamic::layout')
@section('title', __('Google Analytics'))

@section('content')
    <div class="widgets @container flex flex-wrap -mx-4 py-2">
        <div class="widget w-full md:w-full mb-8 px-4">
            @include('isapp-analytics::widget', [
            compact('charts', 'property_id'),

        ])
        </div>
    </div>
@stop