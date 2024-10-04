{{-- <link rel="icon" href="{{ asset('assets/theme/images/favicon.ico')}}">
    
<!-- Vendors Style-->
<link rel="stylesheet" href="{{ asset('assets/theme/css/vendors_css.css')}}"> --}}
    
<!-- Style-->  
<link rel="stylesheet" href="{{ asset('assets/theme/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('assets/theme/css/deep.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    #suggestions {
        max-height: 300px;
        overflow-y: auto;
        text-align: left;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        position: absolute;
        z-index: 1000;
        width: 100%;
    }

    #suggestions .list-group-item {
        cursor: pointer;
    }

    #suggestions .list-group-item:hover {
        background-color: #f0f0f0;
    }
</style>