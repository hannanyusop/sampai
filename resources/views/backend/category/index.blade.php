@extends('backend.layouts.app')

@section('title', __('Role Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Category Management')
        </x-slot>
        <x-slot name="body">
            <livewire:category.category-table />
        </x-slot>
    </x-backend.card>
@endsection
