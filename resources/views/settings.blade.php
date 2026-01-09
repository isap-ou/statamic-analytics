@php use function Statamic\trans as __; @endphp

@extends('statamic::layout')
@section('title', __('Google Analytics settings'))

@section('content')
    <isapp-analytics-settings
            :blueprint="{{ json_encode($blueprint) }}"
            :initial-values="{{ json_encode($values) }}"
            :meta="{{ json_encode($meta) }}"
            url="{{ cp_route('isapp-ga.config.update') }}"
            class="-mb-8"
    ></isapp-analytics-settings>
@stop