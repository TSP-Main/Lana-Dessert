<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="google-site-verification" content="7xGOcA3SC2yHRBoJTSaW3pFOG0gJyz7o7DqhIGCcy3Q" />

        @include('include.style')

        <!-- Schema Markup here -->
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Restaurant",
              "name": "Lana Desert",
              "image": "https://www.lanadessert.co.uk/assets/theme/images/lana-logo.png",
              "url": "https://lanadessert.co.uk/",
              "telephone": "+44 115 855 0583",
              "servesCuisine": "Cheese Burger,BBQ Burger,Taka Tuka Chicken Burger,Spicy F16 Chicken Burger, Double Cheese Burger, Halloumi Cheese Burger",
              "priceRange": "$$$",
              "address": {
                "@type": "PostalAddress",
                "streetAddress": "28 Southwark St",
                "addressLocality": "Nottingham",
                "addressRegion": "Basford",
                "postalCode": "NG6 0DA",
                "addressCountry": "United Kingdom"
              },
              "geo": {
                "@type": "GeoCoordinates",
                "latitude": 37.7749,  // Replace with actual coordinates
                "longitude": -122.4194
              },
              "hasMap": "https://maps.app.goo.gl/XRniK2STUtS1dF3u6",
              "openingHoursSpecification": [
                {
                  "@type": "OpeningHoursSpecification",
                  "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                  "opens": "17:00",  // 5:00 PM in 24-hour format
                  "closes": "02:00"   // 2:00 AM
                }
              ],
              "menu": "https://lanadessert.co.uk/menus",
              "acceptsReservations": true,
              "reservationFor": {
                "@type": "FoodEstablishmentReservation",
                "url": "https://lanadessert.co.uk/contact"
              },
              "offers": {
                "@type": "Offer",
                "url": "https://lanadessert.co.uk/menus",
                "priceCurrency": "GBP",
                "price": "00",
                "eligibleRegion": {
                  "@type": "Place",
                  "name": "Nottingham, UK"
                }
              },
              "specialDiet": ["Vegetarian", "Vegan", "GlutenFree"],
              "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "5", 
                "reviewCount": "150"
              },
              "review": [
                {
                  "@type": "Review",
                  "author": {
                    "@type": "Person",
                    "name": "John Doe"
                  },
                  "datePublished": "2024-01-15",
                  "reviewBody": "Amazing food and service!",
                  "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5"
                  }
                }
              ],
              "paymentAccepted": ["Cash", "Credit Card", "Apple Pay"],
              "potentialAction": {
                "@type": "OrderAction",
                "target": "https://lanadessert.co.uk/menus"
              },
              "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+44 115 855 0583",
                "contactType": "Customer Service",
                "areaServed": "28 Southwark St, Old Basford, Nottingham NG6 0DA, United Kingdom" 
              }
            }
        </script>            

    </head>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">
        <div class="wrapper">
            <div id="loader"></div>

            <!-- Topbar -->
            @include('include.navbar')

            <!-- Left Sidebar -->
            {{-- @include('layout.sidebar') --}}

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-full">
                <!-- Main content -->
                    @yield('content')
                <!-- /.content -->
                </div>
            </div>
            <!-- /.content-wrapper -->

            <!-- Rightbar -->
             {{-- @include('layout.rightbar') --}}

            <!-- Footer -->
            @include('include.footer')

        </div>

        @include('include.script')

        @yield('script')
    </body>

</html>
