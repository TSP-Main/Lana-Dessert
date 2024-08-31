@extends('layout.app')
@section('title', 'FAQs')
 <!-- <style>
    /* .nav-top-svg{
        display: none;
    } */
                .gradient-text {
    font-size: 3rem; /* Adjust the font size as needed */
    font-weight: bold; /* Optional: Make the text bold */
    background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text; 
    -webkit-text-fill-color: transparent; 
    background-clip: text; /* Apply grnt to text for non-webkit browsers */
    text-fill-color: transparent; /* Ensure compatibility */
}
</style> -->

@section('content')
<div class="faq-main" data-aos="fade-down" data-aos-duration="1500">
    <div class="container text-center d-flex justify-content-center align-items-center">
        <h2 class="about-title gradient-text" style="font-weight: bold; font-size: 3rem; background: linear-gradient(to top, rgba(87, 87, 87, 0.5), #ffffff);
    -webkit-background-clip: text;  -webkit-text-fill-color: transparent;">FAQ</h2>
    </div>
</div>

    <div class="container mt-5 mb-5">
  <div class="row">
    <div class="col-lg-9 mx-auto">
      <!-- Accordion -->
      <div id="accordionExample" class="accordion ">

        <!-- Accordion item 1 -->
        <div class="card">
          <div id="headingOne" class="card-header bg-white border-0">
            <h6 class="mb-0 font-weight-bold"><p data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Do you offer dine-in, takeaway, and delivery options?</p></h6>
          </div>
          <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse show">
            <div class="card-body p-5">
              <p class="font-weight-light m-0">Absolutely! At Lana Desserts, we believe in providing flexibility for our customers. You can enjoy our delicious burgers and desserts in-house, take them to go, or have them delivered right to your doorstep.</p>
            </div>
          </div>
        </div>

        <!-- Accordion item 2 -->
        <div class="card">
          <div id="headingTwo" class="card-header bg-white border-0">
            <h6 class="mb-0 font-weight-bold"><p data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">How will I know when my order is ready?</p></h6>
          </div>
          <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample" class="collapse">
            <div class="card-body p-5">
              <p class="font-weight-light m-0">Once your order is confirmed, we will provide you with updates about when to expect your goodies. You can count on us to keep you informed every step of the way!</p>
            </div>
          </div>
        </div>

        <!-- Accordion item 3 -->
        <div class="card">
          <div id="headingThree" class="card-header bg-white border-0">
            <h6 class="mb-0 font-weight-bold"><p data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Are my desserts fresh?</p></h6>
          </div>
          <div id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample" class="collapse">
            <div class="card-body p-5">
              <p class="font-weight-light m-0">Yes, indeed. We take pride in serving only the freshest desserts at Lana Desserts. Every item is made with care and attention to ensure you enjoy each delightful bite.</p>
            </div>
          </div>
        </div>

        <!-- Accordion item 4 -->
        <div class="card">
          <div id="headingFour" class="card-header bg-white border-0">
            <h6 class="mb-0 font-weight-bold"><p data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">What are your opening hours?</p></h6>
          </div>
          <div id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionExample" class="collapse">
            <div class="card-body p-5">
              <p class="font-weight-light m-0">We are here to satisfy your sweet cravings every day of the week. Lana Desserts opens Monday to Sunday from 5 PM to 2 AM.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="founder-about">
    <div class="container">
        <div class="row">
            <div class="col-md-6" data-aos="fade-right" data-aos-duration="1500">
                <div class="founder-img">
                    <img src="/assets/theme/images/Shoop.webp" width="100%" alt="">
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-duration="1500">
                <div class="founder-msg faq-msg px-5">
                    <h5>Discover</h5>
                    <h2>Our Crew Ready to Help You</h2>
                    <p style="text-align: justify;">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
                        architecto beatae vitae dicta sunt explicabo. </p>
                        <a href="">Contact us</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionItems = document.querySelectorAll('#accordion .card');

            accordionItems.forEach(item => {
                item.addEventListener('click', function() {
                    const collapseElement = item.querySelector('.collapse');
                    if (collapseElement.classList.contains('show')) {
                        return;
                    }

                    accordionItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherCollapseElement = otherItem.querySelector('.collapse');
                            if (otherCollapseElement.classList.contains('show')) {
                                $(otherCollapseElement).collapse('hide');
                            }
                        }
                    });
                });
            });
        });
    </script>