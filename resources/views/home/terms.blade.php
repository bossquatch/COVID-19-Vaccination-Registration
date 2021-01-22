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
                <h1 class="title">Terms of Use</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Effective date: December 4, 2020</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <p>Services that Polk County provides to you are subject to the following Terms of Use. Polk County reserves the right to update the Terms of Use at any time without notice to you.</p>
        <h2 id="a-definitions">A. Definitions</h2>
        <ol>
        <li>The &quot;Agreement&quot; refers, collectively, to all the terms, conditions, notices contained or referenced in this document (the &quot;Terms of Use&quot; or the &quot;Terms&quot;) and all other operating rules, policies (including the <a href="/content/site-policy/polkcounty-privacy-policy">Privacy Policy</a>) and procedures that we may publish from time to time on the Website.</li>
        <li>&quot;Polk County,&quot; &quot;We,&quot; and &quot;Us&quot; refer to Polk County, a political subdivision of the State of Florida, as well as its affiliates, directors, subsidiaries, contractors, licensors, officers, agents, and employees.</li>
        <li>&quot;The User,&quot; &quot;You,&quot; and &quot;Your&quot; refer to the individual person, company, or organization that has visited or is using the Website or Service; that accesses or uses any part of the Account; or that directs the use of the Account in the performance of its functions. A User must be at least 13 years of age.</li>
        <li>The &quot;Service&quot; refers to the applications, software, products, and services provided by Polk County.</li>
        <li>The &quot;Website&quot; refers to Polk County&#39;s website located at <a href="https://www.polk-county.net">polk-county.net</a>, and all content, services, and products provided by Polk County at or through the Website. It also refers to Polk County-owned subdomains of <a href="https://www.polk-county.net">polk-county.net</a>. Occasionally, websites owned by Polk County may provide different or additional terms of use. If those additional terms conflict with this Agreement, the more specific terms apply to the relevant page or service.</li>
        <li>An &quot;Account&quot; represents your legal relationship with Polk County. A &quot;User Account&quot; represents an individual User&#39;s authorization to log in to and use the Service and serves as a User&#39;s identity.</li>
        <li>&quot;Content&quot; refers to content featured or displayed through the Website, including without limitation code, text, data, articles, images, photographs, graphics, software, applications, packages, designs, features, and other materials that are available on the Website or otherwise available through the Service. &quot;Content&quot; also includes Services. &quot;User-Generated Content&quot; is Content, written or otherwise, created or uploaded by our Users. &quot;Your Content&quot; is Content that you create or own.</li>
        </ol>
        <h2 id="b-account-terms">B. Account Terms</h2>
        <ol>
        <li>You must be age 13 or older to use this Service. If we learn of any User under the age of 13, we will <a href="#f.-cancellation-and-termination">terminate that User’s Account immediately</a>.</li>
        <li>You must be a human to create an Account. Accounts registered by &quot;bots&quot; or other automated methods are not permitted.</li>
        <li>You must provide your name, a valid email address, and any other information requested in order to complete the registration process.</li>
        <li>Your login may only be used by one person — i.e., a single login may not be shared by multiple people.</li>
        <li>You are responsible for maintaining the security of your account and password. Polk County cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.</li>
        <li>You are responsible for all activity that occurs under your account.</li>
        <li>You may not use the Service for any illegal or unauthorized purpose. You must not, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright or trademark laws).</li>
        <li>You understand that Polk County uses third party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run the Service.</li>
        <li>You must not modify, adapt or hack the Service or modify another website so as to falsely imply that it is associated with the Service, Polk County, or any other Polk County service.</li>
        <li>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by Polk County.</li>
        <li>You understand that the technical processing and transmission of the Service, including your Content, may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices.</li>
        <li>You must not upload, post, host, or transmit unsolicited email, SMSs, or &quot;spam&quot; messages.</li>
        <li>You must not transmit any worms or viruses or any code of a destructive nature.</li>
        <li>You understand that the Service, including your Content, may be disclosed in accordance with Florida’s Public Records Law.</li>
        </ol>
        <h2 id="c-acceptable-use">C. Acceptable Use</h2>
        <p>Your use of the Website and Service must not violate any applicable laws, including copyright or trademark laws, export control or sanctions laws, or other laws in your jurisdiction. You are responsible for making sure that your use of the Service is in compliance with laws and any applicable regulations.</p>
        <h2 id="d-user-generated-content">D. User-Generated Content</h2>
        <h3 id="1-responsibility-for-user-generated-content">1. Responsibility for User-Generated Content</h3>
        <p>You may create or upload User-Generated Content while using the Service. You are solely responsible for the content of, and for any harm resulting from, any User-Generated Content that you post, upload, link to or otherwise make available via the Service, regardless of the form of that Content. We are not responsible for any public display or misuse of your User-Generated Content.</p>
        <h3 id="2-polk-county-may-remove-content">2. Polk County May Remove Content</h3>
        <p>We do not pre-screen User-Generated Content, but we have the right (though not the obligation) to refuse or remove any User-Generated Content that, in our sole discretion, violates any Polk County terms or policies.</p>
        <h2 id="e-intellectual-property-notice">E. Intellectual Property notice</h2>
        <h3 id="1-polk-county-s-rights-to-content">1. Polk County&#39;s Rights to Content</h3>
        <p>Polk County and our licensors, vendors, agents, and/or our content providers retain ownership of all intellectual property rights of any kind related to the Website and Service. We reserve all rights that are not expressly granted to you under this Agreement or by law. The look and feel of the Website and Service is copyright © Polk County Board of County Commissioners. All rights reserved.</p>
        <h2 id="f-cancellation-and-termination">F. Cancellation and Termination</h2>
        <h3 id="1-account-cancellation">1. Account Cancellation</h3>
        <p>It is your responsibility to properly cancel your Account with Polk County. You can cancel your Account at any time. We are not able to cancel Accounts in response to an email or phone request.</p>
        <h3 id="2-upon-cancellation">2. Upon Cancellation</h3>
        <p>We will retain and use your information as necessary to comply with our legal obligations, resolve disputes, and enforce our agreements.</p>
        <h3 id="3-polk-county-may-terminate">3. Polk County May Terminate</h3>
        <p>Polk County, in its sole discretion, has the right to suspend or terminate your account and refuse any and all current or future use of the Service, or any other Polk County service, for any reason at any time. Such termination of the Service will result in the deactivation or deletion of your Account or your access to your Account, and the forfeiture and relinquishment of all Content in your Account. Polk County reserves the right to refuse service to anyone for any reason at any time.</p>
        <h3 id="4-survival">4. Survival</h3>
        <p>All provisions of this Agreement which, by their nature, should survive termination <em>will</em> survive termination — including, without limitation: ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>
        <h2 id="g-modifications-to-the-service">G. Modifications to the Service</h2>
        <ol>
        <li>Polk County reserves the right at any time and from time to time to modify or discontinue, temporarily or permanently, the Service (or any part thereof) with or without notice.</li>
        <li>Polk County shall not be liable to you or to any third party for any modification, suspension or discontinuance of the Service.</li>
        </ol>
        <h2 id="h-disclaimer-of-warranties">H. Disclaimer of Warranties</h2>
        <p>Polk County provides the Website and the Service &quot;as is&quot; and &quot;as available,&quot; without warranty of any kind. Without limiting this, we expressly disclaim all warranties, whether express, implied or statutory, regarding the Website and the Service including without limitation any warranty of merchantability, fitness for a particular purpose, title, security, accuracy and non-infringement.</p>
        <p>Polk County does not warrant that the Service will meet your requirements; that the Service will be uninterrupted, timely, secure, or error-free; that the information provided through the Service is accurate, reliable or correct; that any defects or errors will be corrected; that the Service will be available at any particular time or location; or that the Service is free of viruses or other harmful components. You assume full responsibility and risk of loss resulting from your downloading and/or use of files, information, content or other material obtained from the Service.</p>
        <h2 id="i-limitation-of-liability">I. Limitation of Liability</h2>
        <p>You understand and agree that we will not be liable to you or any third party for any costs, claims, expenses, loss of profits, use, goodwill, or data, or for any incidental, indirect, special, consequential or exemplary damages, however arising, that result from</p>
        <ul>
        <li>the use, disclosure, or display of your User-Generated Content;</li>
        <li>your use or inability to use the Service;</li>
        <li>any modification, suspension or discontinuance of the Service;</li>
        <li>the Service generally or the software or systems that make the Service available;</li>
        <li>unauthorized access to or alterations of your transmissions or data;</li>
        <li>statements or conduct of any third party on the Service;</li>
        <li>any other user interactions that you input or receive through your use of the Service; or</li>
        <li>any other matter relating to the Service.</li>
        </ul>
        <p>Our liability is limited whether or not we have been informed of the possibility of such damages, and even if a remedy set forth in this Agreement is found to have failed of its essential purpose. We will have no liability for any failure or delay due to matters beyond our reasonable control.</p>
        <h2 id="j-changes-to-these-terms">J. Changes to These Terms</h2>
        <p>We reserve the right, at our sole discretion, to amend the Terms of Use at any time and will update the Terms of Use in the event of any such amendments. We will notify our Users of material changes to this Agreement at least 30 days prior to the change taking effect by posting a notice on our Website. For non-material modifications, your continued use of the Website constitutes agreement to our revisions of the Terms of Use.</p>
        <p>We reserve the right at any time and from time to time to modify or discontinue, temporarily or permanently, the Website (or any part of it) with or without notice.</p>
        <h2 id="k-questions">K. Questions</h2>
        <p>Questions about the Terms of Use should be sent to <a href="mailto:support@polk-county.net">support@polk-county.net</a>.</p>
    </div>
</section>
@endsection
