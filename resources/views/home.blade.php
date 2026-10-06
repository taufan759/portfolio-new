@extends('layouts.site')

@section('loader')
@include('partials.loader')
@endsection

@section('content')
@include('home.hero')
@include('home.about')
@include('home.process')
@include('home.works')
@include('home.services')
@include('home.certificates')
@include('home.journal')
@include('home.stats')
@endsection
