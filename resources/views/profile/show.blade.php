@extends('layouts.app')

@section('title', 'Profil - ZENERGY')

@section('content')
<div class="profile-container">
    <a href="{{ url()->previous() }}" class="back-button">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2