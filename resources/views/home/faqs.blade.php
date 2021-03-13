@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }}
@endsection

@section('content')
<!-- Header -->
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Support
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Frequently Asked Questions</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Common questions related to COVID-19 vaccinations</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row mb-9 mb-md-10">
            <div class="col-12">
                <!-- Card Accordion -->
                <div class="card card-accordion accordion mb-4 mb-md-5" id="helpAccordionOne">
                    <div class="list-group">
                    <div class="list-group-item">
                            <span class="badge badge-pill badge-danger-soft mb-3">
                                <span class="text-uppercase">
                                    Update
                                </span>
                            </span>
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFour" role="button" aria-expanded="false" aria-controls="helpFour">
                                <!-- Title -->
                                <h3 class="collapse-title">Who is eligible for the COVID-19 Vaccine?</h3>

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
                                    The Florida Department of Health Polk County's COVID-19 vaccine portal is now open for reservations and,
                                    starting March 15, will expand the eligibility to those 60 years old and older, who wish to be inoculated
                                    once vaccine becomes available, according to the most recent executive order from Florida Gov. Ron DeSantis.
                                    COVID-19 vaccinations also will include:
                                    </p>
                                    <ul>
                                        <li>Long-term care facility residents and staff</li>
                                        <li>Health care personnel with direct patient contact</li>
                                        <li>K-12 school employees 50 years of age and older</li>
                                        <li>Sworn law enforcement officers 50 years of age and older</li>
                                        <li>Firefighters 50 years of age and older</li>
                                    </ul>
                                    <p class="collapse-content">
                                    Through the portal, you can create an account and upload your personal information for a future appointment.
                                    You can also learn more about the vaccine being administered by the Florida Department of Health and have other
                                    frequent questions answered.
                                    </p>
                                    <p class="collapse-content">
                                        Advanced practice registered nurses and pharmacists may also vaccinate persons determined by a physician to be extremely vulnerable to COVID-19.
                                        This determination from a physician must be documented using the <a href="/docs/EO-21-47-Form.pdf" target="_blank" rel="noopener" download aria-download="true">EO-21-47-Form</a>
                                        and include a statement from the physician that the patient meets eligibility criteria outlined on the <a href="https://floridahealthcovid19.gov/high-risk-populations/">
                                        Florida Department of Health website</a>.
                                    </p>
                                    <p class="collapse-content">
                                        Those who meet criteria for the extremely vulnerable group may receive a COVID-19 vaccine at a local pharmacy or register on Polk County's vaccination portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <span class="badge badge-pill badge-danger-soft mb-3">
                                <span class="text-uppercase">
                                    Update
                                </span>
                            </span>
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpSixty" role="button" aria-expanded="false" aria-controls="helpSixty">
                                <!-- Title -->
                                <h3 class="collapse-title">I need to be a Florida resident to be vaccinated at these appointments?</h3>
                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>
                            <!-- Collapse -->
                            <div class="collapse" id="helpSixty" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        By <a href="https://floridahealthcovid19.gov/wp-content/uploads/2021/01/Prioritization-of-Floridans-for-Covid-19-Vaccinations.pdf">advisory</a> from the State Surgeon General and State Health Officer, Scott A. Rivkees, M.D., prior to providing the first dose of the COVID-19 vaccine to the intended recipient, every vaccine provider in Florida should ensure the recipient of the vaccine is either:
                                    </p>
                                    <ol class="text-gray-dark">
                                        <li>a resident of the State of Florida able to demonstrate residency consistent with the criteria set forth in <a href="http://www.leg.state.fl.us/statutes/index.cfm?App_mode=Display_Statute&URL=0300-0399/0381/Sections/0381.986.html">&#167 381.986(5)(b), Fla Stat.</a>; or</li>
                                        <li>an individual present in Florida for the purpose of providing health care services involving direct contact with patients.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFourteen" role="button" aria-expanded="false" aria-controls="helpFourteen">
                                <!-- Title -->
                                <h3 class="collapse-title">Do I need to be a Polk County resident to be vaccinated at these appointments?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpFourteen" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                        No; however, an appointment is mandatory. We do ask that those who receive their first dose of vaccine from us also be local/in county to receive their second dose from us 28 days later.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpOne" role="button" aria-expanded="false" aria-controls="helpOne">
                                <!-- Title -->
                                <h3 class="collapse-title">Is there a cost to be vaccinated?</h3>

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
                                        There is no cost to be vaccinated with the health department and insurance is not required.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTwo" role="button" aria-expanded="false" aria-controls="helpTwo">
                                <!-- Title -->
                                <h3 class="collapse-title">Where are the current locations to be vaccinated?</h3>

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
                                        DOH-Polk is scheduling vaccine appointments weekly at various locations across the county. There are no walk-in vaccine locations in Polk at this time. You will receive a testing location and time when you are called back by our staff to schedule your vaccine appointment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpThree" role="button" aria-expanded="false" aria-controls="helpThree">
                                <!-- Title -->
                                <h3 class="collapse-title">Are walk-ins accepted?</h3>

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
                                        No. Appointments are mandatory to receive a COVID-19 vaccine.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFive" role="button" aria-expanded="false" aria-controls="helpFive">
                                <!-- Title -->
                                <h3 class="collapse-title">Am I immune once I have received the vaccine?</h3>

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
                                        No. The vaccine takes a few weeks for antibodies to develop. A second dose of the vaccine will need to administered 28 days after the first as a booster. We encourage you to continue following healthy prevention measures after receiving the vaccine. This includes continuing to:
                                    </p>
                                    <ul>
                                        <li>Wash your hands</li>
                                        <li>Wear a mask in public</li>
                                        <li>Continue social distancing while out in public</li>
                                        <li>Cleaning and wiping down surfaces</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpSix" role="button" aria-expanded="false" aria-controls="helpSix">
                                <!-- Title -->
                                <h3 class="collapse-title">How will members of the public know when appointments become available?</h3>

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
                                        Residents can continue monitoring the health department's website for updates regarding appointments. Here is a link: <a href="http://polk.floridahealth.gov/" target="__blank">Florida Health - Polk County</a>. Residents may also call our Polk County COVID-19 vaccine hotline at 863-298-7500 to check on availability.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpSeven" role="button" aria-expanded="false" aria-controls="helpSeven">
                                <!-- Title -->
                                <h3 class="collapse-title">How long will it take for me to get a call about a vaccine appointment?</h3>

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
                                        Once your information is shared on our registration list, someone will be calling you back at a future date when appointments are available. Appointments are contingent on vaccine supply . We are unsure of our future schedule. If you have an opportunity to receive a vaccine before you are called for an appointment, please feel free to go ahead and get one.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpEight" role="button" aria-expanded="false" aria-controls="helpEight">
                                <!-- Title -->
                                <h3 class="collapse-title">Why aren't there more appointments available?</h3>

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
                                        Quantities of the vaccine are limited and are in great demand. Please be assured that we are making every effort to vaccinate residents as quickly as possible based on the quantities of vaccine that are provided by the State of Florida. As availability of the vaccine grows and demand evens out, it will be easier to ensure everyone who qualifies receives an appointment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpNine" role="button" aria-expanded="false" aria-controls="helpNine">
                                <!-- Title -->
                                <h3 class="collapse-title">When will more appointments become available?</h3>

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
                                        DOH-Polk expects new supplies of vaccine from the State weekly. Vaccination appointments will be available based on supply.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTen" role="button" aria-expanded="false" aria-controls="helpTen">
                                <!-- Title -->
                                <h3 class="collapse-title">Which vaccine is the health department in Polk providing?</h3>

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
                                        We are currently giving the Moderna vaccine.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpEleven" role="button" aria-expanded="false" aria-controls="helpEleven">
                                <!-- Title -->
                                <h3 class="collapse-title">How many doses is the Moderna vaccine?</h3>

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
                                        The Moderna vaccine is a two-dose series separated by 28 days.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpTwelve" role="button" aria-expanded="false" aria-controls="helpTwelve">
                                <!-- Title -->
                                <h3 class="collapse-title">How will I know when I should return for the second dose of the vaccine?</h3>

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
                                        Your second appointment will be scheduled after you receive your first dose, before you leave the vaccination appointment. It is important to follow the instructions exactly as they are provided to you so that the vaccine administered in the follow-up appointment is the same kind as the initial dose, and to achieve maximum effectiveness of the vaccine.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpThirteen" role="button" aria-expanded="false" aria-controls="helpThirteen">
                                <!-- Title -->
                                <h3 class="collapse-title">If I made the appointment as a caretaker for an elderly person, can I get the details for the follow­ up dose sent to me?</h3>

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
                                        This can be arranged at the time the appointment for the second dose is made (during the exit process). If you are not accompanying the person who is receiving the vaccine, please be sure he/she brings your contact information with them to the site, so this can be provided to the staff who will be arranging the follow-up appointment.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpFifteen" role="button" aria-expanded="false" aria-controls="helpFifteen">
                                <!-- Title -->
                                <h3 class="collapse-title">What do I need to bring with me to the appointment?</h3>

                                <!-- Metadata -->
                                <div class="ml-auto">
                                    <!-- Chevron -->
                                    <span class="collapse-chevron text-muted"><span class="fas fa-chevron-down"></span></span>
                                </div>
                            </a>

                            <!-- Collapse -->
                            <div class="collapse" id="helpFifteen" data-parent="#helpAccordionOne">
                                <div class="py-4">
                                    <!-- Text -->
                                    <p class="collapse-content">
                                    </p>
                                    <ul>
                                        <li>Proof of residency of the State of Florida consistent with the criteria set forth in <a href="http://www.leg.state.fl.us/statutes/index.cfm?App_mode=Display_Statute&URL=0300-0399/0381/Sections/0381.986.html">&#167 381.986(5)(b), Fla Stat.</a>; or</li>
                                        <li>A photo ID with your name and date of birth (for example: Florida driver's license, state-issued ID, or passport)</li>
                                        <li>Proof of your appointment (printed copy or screenshot of the confirmation email or text message)</li>
                                        <li>Completed <a href="/docs/consent_moderna.pdf" target="_blank" rel="noopener" download aria-download="true">Moderna Consent form</a></li>
                                        <li>If you are receiving the inoculation as extremely vulnerable you must bring a completed <a href="/docs/EO-21-47-Form.pdf" target="_blank" rel="noopener" download aria-download="true">EO-21-47-Form</a>
                                        <li>The Centers for Disease Control and Prevention recommends that people wear a mask that covers their nose and mouth when receiving any vaccine, including a COVID-19 vaccine. Anyone who has trouble breathing or is unable to remove a mask without assistance should not wear a mask.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <!-- Toggle -->
                            <a class="d-flex align-items-center text-reset text-decoration-none" data-toggle="collapse" href="#helpOne" role="button" aria-expanded="false" aria-controls="helpSixteen">
                                <!-- Title -->
                                <h3 class="collapse-title">What are the ingredients in the Moderna vaccine?</h3>

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
                                        Please reference this <a href="https://www.fda.gov/media/144638/download">document</a> on the Food and Drug Administration <a href="https://www.fda.gov/home">website</a>.
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
