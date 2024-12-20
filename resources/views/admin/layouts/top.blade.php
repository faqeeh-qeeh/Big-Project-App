<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link rel="icon" href="{{ asset('IMG/Logo KM white.png') }}" type="image/png" />  
    <title>@yield ('title')</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"   
      rel="stylesheet"   
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"   
      crossorigin="anonymous"  
    >  
    <link rel="stylesheet" href="{{ asset('css/navbar/style.css') }}">  
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />  
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  
    <style> 
    <style>
      body {
        background-color: #F6F6F6;
      }
      .search-results-dropdown {  
        position: absolute;  
        z-index: 1000;  
        width: 100%;  
        max-height: 300px;  
        overflow-y: auto;  
        display: none;  
        margin-top: 3rem;
    }  
    .search-results-dropdown.show {  
        display: block;  
    }  
    .search-results-item:hover {  
        background-color: #f8f9fa;  
        cursor: pointer;  
    } 
    .aniva1, .aniva2, .aniva3, .aniva4, .aniva5, .aniva6, .aniva7, .aniva8 {  
      animation: kiri-kanan ease-out forwards;  
      animation-fill-mode: forwards; /* Pastikan animasi mempertahankan posisi akhir */  
    }


    .aniva1 { animation-duration: 0.4s; animation-delay: 0s; }  
    .aniva2 { animation-duration: 0.5s; animation-delay: 0.1s; }  
    .aniva3 { animation-duration: 0.6s; animation-delay: 0.2s; }  
    .aniva4 { animation-duration: 0.7s; animation-delay: 0.3s; }  
    .aniva5 { animation-duration: 0.8s; animation-delay: 0.4s; }  
    .aniva6 { animation-duration: 0.9s; animation-delay: 0.5s; }  
    .aniva7 { animation-duration: 1s; animation-delay: 0.6s; }  
    .aniva8 { animation-duration: 1.1s; animation-delay: 0.7s; }  

    @keyframes kiri-kanan {  
      from {  
        transform: translateX(-150%);  
      }  
      to {  
        transform: translateX(0);  
      }  
    }
    </style>
  </head>
  <body>