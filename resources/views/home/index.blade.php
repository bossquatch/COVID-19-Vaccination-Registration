@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<!-- Header -->
<div class="page-header header-filter page-header-default">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto text-center">
                <h1 class="title">Polk COVID-19 Vaccination Registration</h1>
                <p class="sub-title h4">Register for your vaccinations.</p>
                <br>
                @auth
                    <a class="btn btn-header btn-round btn-lg" href="/home">
                        @can('read_registration')
                        <span class="fad fa-tasks mr-1"></span> Management Console
                        @elsecan('create_registration')
                            @if(Auth::user()->registration)
                                <span class="fad fa-search mr-1"></span> View Your Registration
                            @else
                                <span class="fad fa-check mr-1"></span> Register
                            @endif
                        @endcan
                    </a>

                    <a class="btn btn-header btn-round btn-lg" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        <span class="fad fa-sign-out mr-1"></span> Sign out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a class="btn btn-header btn-round btn-lg" href="/login">
                        <span class="fad fa-search mr-1"></span> View Registration
                    </a>
                    <a class="btn btn-header btn-round btn-lg" href="/register">
                        <span class="fad fa-check mr-1"></span> Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row mb-6 mb-md-8">
            <div class="col-12 col-md-8 mb-6 mb-md-0">
                <div class="row mb-6 mb-md-8">
                    <div class="col-12">
                        <!-- Heading -->
                        <h2 class="h3">
                            What is Polk County CARES?
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark">
                            The Coronavirus Aid, Relief, and Economic Security Act, also known as the CARES Act, is a law meant to address the economic fallout of the COVID-19 pandemic in the United States. The Polk County CARES Program was created to assist households that have experienced a verifiable loss of income due to the impacts of the Novel Coronavirus (COVID-19), by providing rent, mortgage and/or public utilities payments to prevent eviction and homelessness as a result of the pandemic crisis.
                        </p>
                    </div>
                </div>

                <div class="row mb-6 mb-md-8">
                    <div class="col-12">
                        <!-- Heading -->
                        <h2 class="h3">
                            Do I qualify?
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark">
                            You must be a resident of Polk County. Individuals and/or households may apply for financial assistance. Individuals who have lost their job or income due to the COVID-19 pandemic may be eligible for $2,000 in assistance (one per household). Below is the criteria:
                        </p>

                        <!-- List -->
                        <div class="d-flex mt-5">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                You must be a resident of Polk County
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Must be at least 70 years old, OR disabled 18+ y/o and receiving social security disability benefits
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Attest to reduced income or increased expenses
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Have not received previous Polk CARES Individual assistance
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                ONE person per household (Except for dual bed apartment units)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <!-- Heading -->
                        <h2 class="h3">
                            What do I need to apply?
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark">
                            There are a number of items needed to verify your eligibility for the Polk County CARES Program (we reserve the right to request additional supporting documentation if case is questionable), including:
                        </p>

                        <!-- List -->
                        <div class="d-flex mt-5">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Government issued ID that includes birthdate (Florida ID or Driver's License, passport, etc.)
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Social Security Number
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Copy of SSA disability statement issued within the past 12 months (if applicable)
                            </p>
                        </div>
                        <div class="d-flex">
                            <!-- Badge -->
                            <div class="badge badge-rounded-circle badge-success-soft mt-1 mr-4">
                                <span class="fas fa-check"></span>
                            </div>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                Copy of Veteran Abatement Tax Letter showing disabled (if applicable)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <!-- Card -->
                <div class="card shadow-light-lg mb-5">
                    <div class="card-body">
                        <!-- Heading -->
                        <h2 class="h4">
                            Need help?
                        </h2>

                        <!-- Text -->
                        <p class="font-size-sm text-gray-dark mb-5">
                            Not sure exactly what you're looking for or just want clarification? We'd be happy to chat and clear things up for you.
                        </p>

                        <!-- Heading -->
                        <h3 class="h6 font-weight-bold text-uppercase mb-2">
                            Call center
                        </h3>

                        <!-- Text -->
                        <p class="font-size-sm text-gray-dark mb-5">
                            <a href="tel:863-298-7500">(863) 298-7500</a>
                        </p>

                        <!-- Heading -->
                        <h3 class="h6 font-weight-bold text-uppercase mb-2">
                            Call center hours
                        </h3>

                        <!-- Text -->
                        <p class="font-size-sm text-gray-dark mb-0">
                            <span class="mr-1">Mon-Fri:</span> 9am - 12pm
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-9 mb-md-10">
            <div class="col-12">
                <!-- Card Accordion -->
                <div class="card card-accordion accordion mb-4 mb-md-5" id="helpAccordionOne">
                    <div class="list-group">
                        <div class="list-group-item">
                            <!-- Header -->
                            <div class="d-flex align-items-center">
                                <div class="mr-auto">
                                    <!-- Heading -->
                                    <h2 class="title">Frequently Asked Questions</h2>
                                    <!-- Text -->
                                    <p class="sub-title">Quesions related to the Coronavirus Aid, Relief, and Economic Security (CARES) Act</p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpOne" role="button" aria-expanded="false" aria-controls="helpOne">
                                <!-- Title -->
                                <h3 class="collapse-title">I live outside Polk County's limits. Can I receive CARES assistance?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpOne" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Polk County can only provide CARES assistance to its residents.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTwo" role="button" aria-expanded="false" aria-controls="helpTwo">
                                <!-- Title -->
                                <h3 class="collapse-title">If I am eligible, how much assistance can I receive?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpTwo" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        The maximum per-household award for the CARES program is $2,000, for rent/mortgage and/or public utilities.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpThree" role="button" aria-expanded="false" aria-controls="helpThree">
                                <!-- Title -->
                                <h3 class="collapse-title">What utilities are eligible for assistance?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpThree" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Utility services eligible for assistance are electricity, water, wastewater (sewer), solid waste, and natural gas. Telephone service, including landline and cell phone, and internet service are not eligible.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFour" role="button" aria-expanded="false" aria-controls="helpFour">
                                <!-- Title -->
                                <h3 class="collapse-title">I don't have all the documentation required for my application. Can I submit it later?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpFour" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Yes. You can save your progress and return anytime. It is vitally important you gather all required documentation before starting your application. Funds are available on a first qualified, first come, first served basis.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFive" role="button" aria-expanded="false" aria-controls="helpFive">
                                <!-- Title -->
                                <h3 class="collapse-title">Is there a deadline to apply for assistance?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpFive" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        The application period opens on September 15, 2020 at 8am and will close once all funds have been expended, no later than November 15, 2020.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpSix" role="button" aria-expanded="false" aria-controls="helpSix">
                                <!-- Title -->
                                <h3 class="collapse-title">How many individuals/households will be awarded?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpSix" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        There will be a total of 5,000 individuals/households awarded assistance of $2,000.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpSeven" role="button" aria-expanded="false" aria-controls="helpSeven">
                                <!-- Title -->
                                <h3 class="collapse-title">Are disabled youth eligible?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpSeven" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        No, only adults are eligible to apply.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpEight" role="button" aria-expanded="false" aria-controls="helpEight">
                                <!-- Title -->
                                <h3 class="collapse-title">What type of documents can be used for identification?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpEight" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Valid Florida Driver's License, state-issued ID, or passport.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpNine" role="button" aria-expanded="false" aria-controls="helpNine">
                                <!-- Title -->
                                <h3 class="collapse-title">Can someone apply if they received financial assistance through United Way CARES program?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpNine" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Yes (United Way can serve more than 1 person per household).
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTen" role="button" aria-expanded="false" aria-controls="helpTen">
                                <!-- Title -->
                                <h3 class="collapse-title">What if applicant doesn't have recent copy of disability statement?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpTen" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Contact local SSA office or their website.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpEleven" role="button" aria-expanded="false" aria-controls="helpEleven">
                                <!-- Title -->
                                <h3 class="collapse-title">How does a veteran get a copy of their tax abatement statement?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpEleven" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Contact Veteran Services: (863) 534-5200 or (800) 780-5346
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTwelve" role="button" aria-expanded="false" aria-controls="helpTwelve">
                                <!-- Title -->
                                <h3 class="collapse-title">Will additional documents be required?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpTwelve" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        We have the right to request additional documents as needed to validate application.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpThirteen" role="button" aria-expanded="false" aria-controls="helpThirteen">
                                <!-- Title -->
                                <h3 class="collapse-title">Are Polk Board of County Commissioners employees eligible?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpThirteen" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        Yes, if they meet the criteria.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-8 mb-md-0">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        Google Translate
                    </span>
                </span>

                <!-- Heading -->
                <h2>
                    Google Translate available on Chrome, iOS and Android.
                </h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-6">
                    You can translate text, handwriting, photos, and speech in over 100 languages with the Google Translate app. You can also use Translate on the web.
                </p>

                <!-- Available in the Chrome Web Store Button -->
                <div>
                    <a class="text-reset d-inline-block mr-2 mb-4" href="https://chrome.google.com/webstore/detail/google-translate/aapbdbdomjkkjkaonfhkkikfgjllcleb?hl=en" title="Available in the Chrome Web Store" target="_blank" rel="noopener">
                        <img class="img-fluid" alt="Available in the Chrome Web Store" src="/images/chrome-web-store-badge.png" style="max-width: 321px;" />
                    </a>
                </div>

                <!-- Download on the App Store Button -->
                <a class="text-reset d-inline-block mr-2 mb-4" href="https://apps.apple.com/us/app/google-translate/id414706506" title="Download on the App Store" target="_blank" rel="noopener">
                    <img class="img-fluid" alt="Download on the App Store" src="/images/app-store-badge.png" style="max-width: 155px;" />
                </a>

                <!-- Get It On Google Play Button -->
                <a class="text-reset d-inline-block mr-2 mb-4" href="https://play.google.com/store/apps/details?id=com.google.android.apps.translate" title="Get it on Google Play" target="_blank" rel="noopener">
                    <img class="img-fluid" alt="Get it on Google Play" src="/images/google-play-badge.png" style="max-width: 155px;" />
                </a>
            </div>
            <div class="col-12 col-md-6 text-left text-md-center">
                <!-- Google Translate Logo -->
                <a class="text-reset d-inline-block" href="https://translate.google.com/" title="Google Translate" target="_blank" rel="noopener">
                    <svg width="240" enable-background="new 0 0 998.1 998.3" version="1.1" viewBox="0 0 998.1 998.3" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                        <path d="m931.7 998.3c36.5 0 66.4-29.4 66.4-65.4v-667.1c0-36-29.9-65.4-66.4-65.4h-648.1l260.1 797.9h388z" fill="#DBDBDB" />
                        <path d="m931.7 230.4c9.7 0 18.9 3.8 25.8 10.6 6.8 6.7 10.6 15.5 10.6 24.8v667.1c0 9.3-3.7 18.1-10.6 24.8-6.9 6.8-16.1 10.6-25.8 10.6h-366.2l-240.6-737.9h606.8m0-30h-648.1l260.1 797.9h388c36.5 0 66.4-29.4 66.4-65.4v-667.1c0-36-29.9-65.4-66.4-65.4z" fill="#DCDCDC" />
                        <polygon points="482.3 809.8 543.7 998.3 714.4 809.8" fill="#4352B8" />
                        <path d="m936.1 476.1v-39.1h-188.5v-63.2h-61.2v63.2h-120.3v39.1h239.4c-12.8 45.1-41.1 87.7-68.7 120.8-48.9-57.9-49.1-76.7-49.1-76.7h-50.8s2.1 28.2 70.7 108.6c-22.3 22.8-39.2 36.3-39.2 36.3l15.6 48.8s23.6-20.3 53.1-51.6c29.6 32.1 67.8 70.7 117.2 116.7l32.1-32.1c-52.9-48-91.7-86.1-120.2-116.7 38.2-45.2 77-102.1 85.2-154.2h84.6v0.1z" fill="#607988" />
                        <path d="M66.4,0C29.9,0,0,29.9,0,66.5v677c0,36.5,29.9,66.4,66.4,66.4h648.1L454.4,0H66.4z" fill="#4285F4" />
                        <linearGradient id="b" x1="534.3" x2="998.1" y1="433.2" y2="433.2" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fff" stop-opacity=".2" offset="0" />
                            <stop stop-color="#fff" stop-opacity=".02" offset="1" />
                        </linearGradient>
                        <path d="M534.3,200.4h397.4c36.5,0,66.4,29.4,66.4,65.4V666L534.3,200.4z" enable-background="new" fill="url(#b)" />
                        <path d="m371.4 430.6c-2.5 30.3-28.4 75.2-91.1 75.2-54.3 0-98.3-44.9-98.3-100.2s44-100.2 98.3-100.2c30.9 0 51.5 13.4 63.3 24.3l41.2-39.6c-27.1-25-62.4-40.6-104.5-40.6-86.1 0-156 69.9-156 156s69.9 156 156 156c90.2 0 149.8-63.3 149.8-152.6 0-12.8-1.6-22.2-3.7-31.8h-146v53.4l91 0.1z" fill="#eee" />
                        <radialGradient id="a" cx="65.208" cy="19.366" r="1398.3" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fff" stop-opacity=".1" offset="0" />
                            <stop stop-color="#fff" stop-opacity="0" offset="1" />
                        </radialGradient>
                        <path d="m931.7 200.4h-412.9l-64.4-200.4h-388c-36.5 0-66.4 29.9-66.4 66.5v677c0 36.5 29.9 66.4 66.4 66.4h415.9l61.4 188.4h388c36.5 0 66.4-29.4 66.4-65.4v-667.1c0-36-29.9-65.4-66.4-65.4z" fill="url(#a)" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
