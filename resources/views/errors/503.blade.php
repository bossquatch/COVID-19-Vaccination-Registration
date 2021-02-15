@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }}
@endsection

@section('header')
    <script src="{{ asset('js/analytics.js') }}"></script>
    <link href="{{ asset('css/analytics.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Header -->
    <div class="page-header header-filter page-header-default">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="title">Polk County COVID-19 Vaccinations</h1>
                    <p class="sub-title h4 mb-5">Welcome to the Florida Department of Health Polk County’s vaccination registration web portal. Here you can create an account and then submit your personal information for a future vaccine appointment.</p>
                    <div class="alert alert-primary mt-6 mb-6" role="alert">
                        <h4 class="alert-heading">Site Maintenance</h4>
                        <p>Please excuse the disruption. We are working hard to improve <i class="text-decoration-underline fw-bold">your</i> portal.</p>
                        <hr>
                        <p class="mb-0">Estimated completion time is 12:01AM February 15, 2021</p>
                    </div>
                    <p class="font-size-xs mt-4">
                        You must be able to provide proof of Florida residency at the time of your vaccination.  Please reference this <a href="https://floridahealthcovid19.gov/wp-content/uploads/2021/01/Prioritization-of-Floridans-for-Covid-19-Vaccinations.pdf" class="text-light font-weight-medium"><u>advisory</u></a> for more information.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="main pt-8 pt-md-11 pb-8 pb-md-12">
        <div class="container">
            <div class="row mb-6 mb-md-8">
                <div class="col-12 col-md-8 mb-6 mb-md-0">
                    <div class="row mb-6 mb-md-8">
                        <div class="col-12">
                            <!-- Heading -->
                            <h2 class="h3">
                                Overview
                            </h2>

                            <!-- Text -->
                            <p class="text-gray-dark">
                                To reduce the spread of COVID-19 and its impacts on health and society, a safe and effective vaccine is the most important intervention to end the pandemic. Many of the decisions regarding who gets the COVID-19 vaccine depends on the decisions of the state and federal government. This includes the amount of vaccine Polk County will receive, when, and how.
                            </p>

                            <p class="text-gray-dark">
                                The state’s allocation plan is based on a phased approach while the vaccine doses are in limited supply, as they are now. Polk County is following the required prioritization set by the federal government and the State of Florida in directing the first vaccinations to high-risk health care workers and residents of long-term care facilities at the highest risk of contracting COVID-19, as well as any person over the age of 65.
                            </p>
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
                                If you aren’t sure what you’re looking for, or need clarification, you can contact our COVID-19 Vaccine Hotline.
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
                                <span class="mr-1">Mon-Fri:</span> 8am - 5pm
                            </p>
                            <p class="font-size-sm text-gray-dark mb-0">
                                <span class="mr-1">Sat & Sun:</span> 8am - 2pm
                            </p>
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
                <div class="col-12 col-md-6 mb-8 text-left text-md-center">
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
@section('scripts')

@endsection
