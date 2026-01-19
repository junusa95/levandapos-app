
@extends('layouts.appweb')

@section('content')

 <div id="wrapper">
    <nav class="navbar navbar-fixed-top shadow">
        <div class="container">
            @include('website.layouts.topbar')
        </div>
    </nav>
    
    <div id="left-sidebar" class="sidebar">
      <div class="sidebar-scroll"> 
          @include('website.layouts.leftside')
      </div>
    </div>

    <section class="pt-3 mt-5 top-section">
  		<div class="container top-section-c">
  			<div class="row">
  				<div class="col-12 mt-5">
  					<h3><b>Privacy Policy</b></h3>
  					<div class="mb-4">
  						Please read the Levanda POS Terms of Use and Privacy Policy carefully before using Levanda POS (our/we/us) licenses, products, services, mobile applications and website. If you begin to use any of our licenses, products, services, mobile applications and our website, you agree to all the terms and policies. If you do not agree to all the terms and policies, you should not use the Levanda POS licenses, products, services, mobile applications and website.
  					</div>

  					<h5><b>Definitions of Terms</b></h5>
  					<div class="mb-2">
  						<b>‘’Services’’</b> means Levanda point of sale and inventory management services, and any features and technologies offered by us from time to time, including the Levanda POS, Levanda CDS applications ("Apps") and pos.levanda.co.tz ("Website").
  					</div>
  					<div class="mb-2">
  						<b>"Customer”</b> or <b>“Merchant’’</b> or <b>“User”</b> or <b>“Subscriber”</b> means the person or entity who registers to use the Service by creating an account. If you are creating an account or using the Services on behalf of a business, you agree that you are accepting these Terms and have the authority to enter into these Terms, on behalf of the business, which will be deemed to be the Customer, and will be bound by these Terms.
  					</div>
  					<div class="mb-2">
  						<b>"You"</b> means the Customer and (where the context permits) includes any Authorized Users
  					</div>
  					<div class="mb-2">
  						<b>“Reseller”</b> or <b>“Agent”</b> a fully independent company or person who provide support and installation service for Levanda POS licenses, products, services, mobile applications and websites.
  					</div>
  					<div class="mb-4">
  						<b>“Third Parties”</b> Represents the software’s, applications, devices and services that integrated with some of the products of Levanda POS and is produced by independent companies.
  					</div>

  					<h5><b>What Information do we Cllect</b></h5>
  					<div class="mb-2">
  						We collect information about you when you register an account or sign up to our services (Information such as name, phone number, email address and country). Such information might be used different to improve our service without harming confidentiality.
  					</div>
  					<div class="mb-2">
  						<b>Operational data.</b> We store the information you upload to or send through our Services, (Information about products and services the Customer sells (including inventory, pricing, sale and other data and Information about the Customer or the Customer’s business (employees, consumers, and suppliers).
  					</div>
  					<div class="mb-2">
  						<b>Information for Support.</b> When you contact our customer support, where you may choose to submit information regarding a problem you are experiencing with a Service. (contact information, problem summary, any documentation, screenshots, or information that would help resolve the issue).
  					</div>
  					<div class="mb-2">
  						<b>Payment Information.</b> We collect certain payment and billing information when you subscribe to certain paid Services. You might also provide payment information, such as a receipt of your payment you paid for subscription.
  					</div>
  					<div class="mb-4">
  						<b>Other submissions.</b> We ask your consent to collect personal information from you when you submit web forms on our websites or when you participate in any interactive features of our Services, promotion, activity, or event, request customer support, communicate with us via third party social media sites, or otherwise communicate with us.
  					</div>

  					<h5><b>How we use your personal information</b></h5>
  					<div class="mb-2">
  						We are continually striving to improve Services. We may use information about you for purposes such as:
  					</div>
  					<ul class="mb-4">
  						<li>Enabling you to access and use our Services</li>
  						<li>Displaying historical sale information</li>
  						<li>Sending you marketing, advertising, educational content and promotional messages, and other information that may be of interest to you, including information about us, our Services, or general promotions for business partner campaigns and services.</li>
  						<li>Measuring, customizing, and improving the Services and developing new products</li>
  						<li>Sending to you, service, support, and administrative messages, reminders, technical notices, updates, security alerts, and information requested by you</li>
  						<li>Investigating and preventing fraudulent transactions, unauthorized access to Services, and other illegal activities</li>
  						<li>Providing the capability for online discussion with other customers and/or users.</li>
  						<li>With your consent, we may use information about you for a specific purpose not listed above. For example, we may publish testimonials or featured customer stories to promote the Services, with your permission.</li>
  					</ul>

  					<h5><b>You have the Following Privacy Rights</b></h5>
  					<div class="mb-2">
  						Subject to the provisions of the Data Protection Regulation of the specific country (currently only Tanzania), you have the following rights in regard to your Personal Data: (Please note, these rights are not absolute and, in some cases, they are subjected to conditions as defined by law)
  					</div>
  					<div class="mb-2">
  						<b>Right of Access your Account:</b> You have the right to access your own Personal Information through Levanda POS website and/or Mobile Apps. 
  					</div>
  					<div class="mb-2">
  						<b>Right to Access your Data:</b> You have the right to access your data when your account is active (during the free trial period and when your subscription is active)
  					</div>
  					<div class="mb-2">
  						<b>Right to Erasure:</b> You have the right to delete your data from system anytime you wish to delete if you have access to the data you want to delete.
  					</div>
  					<div class="mb-4">
  						<b>Right to Restriction of Processing:</b> Request the restriction of the processing of your Personal Data in specific cases.
  					</div>

  					<h5><b>How long your Information are Retained.</b></h5>
  					<div class="mb-2">
  						We generally retain your information with no limit of time as long as your account is active in our system.
  					</div>
  					<div class="mb-2">
  						If you delete something such as (user, product, sale e.t.c) will be kept in system for 30 days only before permanent erasing.
  					</div>
  					<div class="mb-2">
  						If you delete your SHOP or STORE, all the records stored within it will be deleted permanently.
  					</div>
  					<div class="mb-4">
  						Once your SHOP or STORE ends free trial or its subscription expires. The shop or store and its data will be retained within a system for 60 days only before permanent erasing.
  					</div>

  					<h5><b>Security</b></h5>
  					<div class="mb-2">
  						We take appropriate security technical and organizational measures (including physical, electronic, and procedural measures) to safeguard your Personal Information from unauthorized access, unlawful use, intervention, modification, or disclosure under the requirements of the Regulation.
  					</div>
  					<div class="mb-2">
  						Every user is creating their own access passwords. The protection of login credentials is the responsibility of the user themselves. Levanda POS is not responsible for any damages that may arise if this information is shared with <b>unauthorized persons.</b>
  					</div>
  					<div class="mb-2">
  						Any content available in user`s account is created by the user and one who’s authorized by the user. Only the users who have access to specific accounts are responsible for the correctness and legality of uploaded information.
  					</div>
  					<div class="mb-2">
  						Levanda POS cannot see or change the confidential information provided by the user of our service (including log in passwords) otherwise authorized by the owner (for an emergency case that can’t be resolved without).
  					</div>
  					<div class="mb-2">
  						The user and the reseller know that the internet and computer environments are not 100% safe, and they are aware of the existence of third parties that use such systems in contravention of the law. Although Levanda POS takes measures to prevent third party illegal activities, it does not provide 100% protection. The user and the reseller know and accept this risk.
  					</div>
  					<div class="mb-2">
  						We reserve the right to change this Privacy Policy from time to time, and if we do we will post any changes on this webpage. If you disagree with these changes, you can cancel your account at any time and/or stop your use of our Services. Your continued use of the Services after any changes to the Privacy Policy constitutes your acceptance of such changes.
  					</div>
  				</div>
  			</div>
  		</div>
  	</section>
       

</div>
@endsection
