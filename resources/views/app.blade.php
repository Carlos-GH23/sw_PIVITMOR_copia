<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="canonical" href="{{ url()->current() }}" />

    <title inertia>{{ config('app.name', 'PIVITMor') }}</title>

    <meta name="description" content="Sistema de información web inteligente que gestiona la vinculación de capacidades y necesidades tecnológicas del sector productivo de Morelos.">
    <meta name="keywords" content="PIVITMor, CCYTEM, Cenidet, Morelos, Vinculación Tecnológica, Investigación, Posgrado">
    <meta name="author" content="CCYTEM">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('app.name', 'PIVITMor') }}">
    <meta property="og:description" content="Plataforma de vinculación tecnológica del sector productivo en Morelos.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ config('app.name', 'PIVITMor') }}">
    <meta property="twitter:description" content="Plataforma de vinculación tecnológica del sector productivo en Morelos.">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    @routes
    @vite(['resources/js/app.js', "resources/js/Modules/{$page['component']}.vue", 'resources/css/app.css'])

    @inertiaHead
</head>

<body class="font-twogether antialiased">
    @inertia
</body>

</html>
