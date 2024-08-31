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
<!-- <div class="vertical-tab-menu  my-5 py-5" data-aos="fade-down-right" data-aos-duration="1500">
    <div class="container">
        <div class="row d-flex align-items-start py-5">
            <div class="col-md-3">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">What is Lezzatos?</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                        aria-selected="false">How to order food in Lezzatos ?</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages"
                        aria-selected="false">Which food is the most delicious ?</button>
                    <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings"
                        aria-selected="false">How to book a table ?</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <h2>Do you offer dine-in, takeaway, and delivery options?  </h2>
                        <p>Absolutely! At Lana Desserts, we believe in providing flexibility for our customers. You can enjoy our delicious burgers and desserts in-house, take them to go, or have them delivered right to your doorstep.</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <h2>How will I know when my order is ready?</h2>
                        <p>Once your order is confirmed, we will provide you with updates about when to expect your goodies. You can count on us to keep you informed every step of the way!</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab">
                        <h2>Are my desserts fresh? </h2>
                        <p>Yes, indeed. We take pride in serving only the freshest desserts at Lana Desserts. Every item is made with care and attention to ensure you enjoy each delightful bite.</p>
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                        aria-labelledby="v-pills-settings-tab">
                        <h2>What are your opening hours?</h2>
                        <p>We are here to satisfy your sweet cravings every day of the week. Lana Desserts opens Monday to Sunday from 5 PM to 2 AM.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="page__wrapper">
		<div class="accordion">
			<details>
			  <summary><strong>Do you offer dine-in, takeaway, and delivery options?</strong></summary>
			  <p>Absolutely! At Lana Desserts, we believe in providing flexibility for our customers. You can enjoy our delicious burgers and desserts in-house, take them to go, or have them delivered right to your doorstep.</p>
			</details>
			<details>
			  <summary><strong>How will I know when my order is ready?</strong></summary>
			  <p>Once your order is confirmed, we will provide you with updates about when to expect your goodies. You can count on us to keep you informed every step of the way!</p>
			</details>
			<details>
			  <summary><strong>Are my desserts fresh?</strong></summary>
			  <p>Yes, indeed. We take pride in serving only the freshest desserts at Lana Desserts. Every item is made with care and attention to ensure you enjoy each delightful bite.</p>
			</details>
			<details>
			  <summary><strong>What are your opening hours?</strong></summary>
			  <p>We are here to satisfy your sweet cravings every day of the week. Lana Desserts opens Monday to Sunday from 5 PM to 2 AM.</p>
			</details>
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
