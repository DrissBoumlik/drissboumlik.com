@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid">
        <div class="privacy-policy section py-5">
            <div class="py-5" id="privacy-policy">
                <div class="testimonials">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                                <h4 class="block-title-header mt-0 mb-4">Privacy Policy</h4>
                                <p class="block-content">Last Updated: 11/20/2023</p>

                                <p class="block-content">Thank you for visiting
                                    <a href="{{ \URL::to('/') }}">drissboumlik.com</a> (the "Website").
                                    Your privacy is important to us,
                                    and we are committed to protecting your personal information.
                                    This Privacy Policy explains how we collect,
                                    use, and disclose personal information when you use our Website.</p>

                                <h4 class="block-title">Information Collection and Use</h4>
                                <p class="block-content">While using our Site, we may ask you to provide us with
                                    certain personally identifiable information that can be used to contact
                                    or identify you. Personally identifiable information may include,
                                    but is not limited to, your name, email address ("Personal Information").</p>
                                <p class="block-content"><span class="fw-bold">Google Analytics :</span> We use
                                    Google Analytics to analyze the traffic on our Website.
                                    Google Analytics collects information such as IP addresses, browser type,
                                    and operating system. This information is used to analyze trends, administer the site,
                                    track user movements, and gather demographic information.
                                    <a href="https://policies.google.com/privacy"
                                       rel="noopener">Link to Google's Privacy Policy</a>.</p>
                                <p class="block-content"><span class="fw-bold">Cloudflare :</span> We use Cloudflare to
                                    enhance the security and performance of our Website.
                                    Cloudflare may collect data such as IP addresses, system configuration information,
                                    and other traffic data. <a href="https://www.cloudflare.com/privacypolicy/"
                                                               rel="noopener">Link to Cloudflare's Privacy Policy</a>.</p>

								<h4 class="block-title">Data Sharing</h4>
                                <p class="block-content">We do not share, sell, trade, or rent users' personal information to any third parties. The information collected through the contact form (name, email, and message) is solely used for communication purposes and is not disclosed or shared with any external entities unless required by law.</p>
								
								<h4 class="block-title">GDPR Compliance</h4>								
								<p class="block-content">As the Data Controller, we collect and process the information you provide via the contact form (name, email, message) solely for communication purposes. We do not share this data with third parties. Users have the right to request correction, or deletion of their personal data at any time by contacting us.</p>
								
								<h4 class="block-title">Data Retention</h4>
								<p class="block-content">We retain the personal information collected via the contact form (name, email, and message) only for as long as necessary to fulfill the purpose of communication or as required by law. Once your inquiry is resolved or if you request deletion, your personal data will be securely erased.</p>

								<h4 class="block-title">Log Data</h4>
                                <p class="block-content">Like many site operators, we collect information that your
                                    browser sends whenever you visit our Site ("Log Data").
                                    This Log Data may include information such as your computer's Internet
                                    Protocol ("IP") address, the pages of our Site that you visit,
                                    the time and date of your visit, and other statistics.</p>

                                <h4 class="block-title">Cookies</h4>
                                <p class="block-content">Cookies are files with small amounts of data, which may
                                    include an anonymous unique identifier. Cookies are sent to your browser from
                                    a website and stored on your computer's hard drive.</p>
                                <p class="block-content">Like many sites, we use "cookies" to collect information.
                                    You can instruct your browser to refuse all cookies or to indicate when a cookie
                                    is being sent. However, if you do not accept cookies,
                                    you may not be able to use some portions of our Site.</p>

                                <h4 class="block-title">Security</h4>
                                <p class="block-content">The security of your Personal Information is important to us,
                                    but remember that no method of transmission over the Internet,
                                    or method of electronic storage, is 100% secure. While we strive to use commercially
                                    acceptable means to protect your Personal Information, we cannot guarantee
                                    its absolute security.</p>

                                <h4 class="block-title">Changes to This Privacy Policy</h4>
                                <p class="block-content">This Privacy Policy is effective as of 11/20/2023 and will
                                    remain in effect except with respect to any
                                    changes in its provisions in the future, which will be in effect immediately after
                                    being posted on this page.</p>
                                <p class="block-content">We reserve the right to update or change our Privacy Policy
                                    at any time, and you should check this Privacy Policy periodically.
                                    Your continued use of the Service after we post any modifications to
                                    the Privacy Policy on this page will constitute your acknowledgment of
                                    the modifications and your consent to abide and be bound by
                                    the modified Privacy Policy.</p>
                                <p class="block-content">If we make any material changes to this Privacy Policy,
                                    we will notify you either through the email address you have provided us or
                                    by placing a prominent notice on our website.</p>

                                <h4 class="block-title">Contact Us</h4>
                                <p class="block-content">If you have any questions about this Privacy Policy,
                                    please contact through:</p>
                                <ul class="ms-3">
                                    <li>Email : <a href="mailto:hi@drissboumlik.com">hi@drissboumlik.com</a></li>
                                    <li>Contact page: <a href="/contact">drissboumlik.com/contact</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
