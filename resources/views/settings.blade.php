@php use function Statamic\trans as __; @endphp

@extends('statamic::layout')
@section('title', __('Google Analytics settings'))

@section('content')
    <sites-edit-form
            :blueprint='@json($blueprint) }}'
            :initial-values='@json($values) }}'
            :meta='@json($meta)'
            url="{{ cp_route('isapp-ga.config.update') }}"
            class="-mb-8"
    ></sites-edit-form>
@stop