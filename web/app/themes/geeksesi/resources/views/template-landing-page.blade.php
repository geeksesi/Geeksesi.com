{{--
  Template Name: Landing Page
--}}
@extends('layouts.app')

@section('content')
  <div class="header-container">
      @include('sections.hero')
      @include('sections.note-articles')
      @include('sections.deep-dive')
      @include('sections.projects')

      @include('partials.content-page')
  </div>
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection
