@extends('layouts.app')

@section('content')

    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9 " >
			<div class="card">
				<div class="header">
					<h2>Program Details</h2>
				</div>
				<div class="body">
					<h3>INCOME OPPORTUNITY!</h3>
					<p>Liberty Dollar Financial Association is now one of the hottest income opportunities on the Internet!! With Liberty Dollar Financial Association's automatic Affiliate Program, you will soon earn Liberty Dollars each time someone you refer opens an account and purchases Silver</p>
					<p>You read it correctly. You'll receive 5% of our transaction fee on every transaction from anyone you refer, deposited directly and instantly into your account, and we'll do that three levels deep!</p>
					<p class="text-center">Your affiliate link is:</p>
					<p class="text-center"><a href="{{Auth::user()->getReferralLinkAttribute()}}" target="_blank">{{Auth::user()->getReferralLinkAttribute()}}</a></p>
					<p class="text-center">Right-Click and Copy Shortcut to copy the link</p>
					<hr>
					<p>There's no limit to the number of people you can refer, so this could be an incredible opportunity. You'll be helping your friends and family preserve their own money against inflation and find fantastic deals with Silver, and they'll learn about Liberty Dollars and the potential for them in their own communities.</p>
					<p class="text-center"></p>

					<h3>Liberty Dollar Financial Affiliate Program Terms of Service</h3>

					<h4>Agreement</h4>
					<p>By participating as an Affiliate in the Liberty Dollar Financial Association Affiliate Program ("Program") you are agreeing to be bound by the following terms and conditions ("Terms of Service").</p>
					<p><strong>Liberty Dollar Financial Association</strong> reserves the right to update and change these Terms of Service from time to time without notice. Any new features that augment or enhance the current Program, including the release of new tools and resources, shall be subject to the Terms of Service. Continued use of the Program after any such changes shall constitute your consent to such changes.</p>
					<p>Violation of any of the terms below will result in the termination of your Account and forfeiture of any outstanding affiliate commission payments earned during the violation. You agree to use the Affiliate Program at your own risk.</p>

					<h4>Account Terms</h4>
					<ul>
						<li>You must be an Active Account Holder of Liberty Dollar Financial Association</li>
						<li>You must be of legal age in your jurisdiction to be part of this Program.</li>
						<li>You must be a human. Accounts registered by "bots" or other automated methods are not permitted.</li>
						<li>You must provide your legal full name, a valid e-mail address, and any other information requested in order to complete the signup process.</li>
						<li>You are responsible for maintaining the security of your account and password. Liberty Dollar Financial Association cannot and will not be liable for any loss or damage from your failure to comply with this security obligation.</li>
						<li>You are responsible for all products and/or content posted and activity that occurs under your account.</li>
						<li>You agree to accept Referral Commissions in Silver, deposited to your Liberty Dollar Financial Association account.</li>
						<li>You may not use the Affiliate Program for any illegal or unauthorized purpose. You must not, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright or Unsolicited E-mail laws).</li>
						<li>You may not use the Affiliate Program to earn money on your own <strong>Liberty Dollar Financial Association</strong> product accounts.</li>
					</ul>

					<h4>Links/graphics on your site, in your emails, or other communications</h4>
					<p>Once you have decided to participate in the Affiliate Program, you will be assigned a unique Affiliate Code. You are permitted to place links, banners, or other graphics we provide with your Affiliate Code on your site, in your emails, or in other communications. We will provide you with guidelines, link styles, and graphical artwork to use in linking to <strong>LDFA</strong>. We may change the design of the artwork at any time without notice, but we won't change the dimensions of the images without proper notice.</p>
					<p>To permit accurate tracking, reporting, and referral fee accrual, we will provide you with special link formats to be used in all links between your site and the Liberty Dollar Financial Association. You must ensure that each of the links between your site and the <strong>Liberty Dollar Financial Association</strong> properly utilizes such special link formats. Links to the <strong>Liberty Dollar Financial Association</strong> placed on your site pursuant to this Agreement and which properly utilize such special link formats are referred to as "Special Links." You will earn referral fees only with respect to New <strong>Liberty Dollar Financial Association</strong> Membership Signups occurring directly through your Special Links; we will not be liable to you with respect to any failure by you or someone you refer to use your Special Links or incorrectly type your Affiliate Code, including to the extent that such failure may result in any reduction of amounts that would otherwise be paid to you pursuant to this Agreement.</p>
					<p>Affiliate links point directly to the New Member Sales Page.</p>

					<h4>Referral fees/commissions and payment</h4>
					<p>For a Referral to be eligible to earn a referral fee, the customer must click-through a Special Link from your site, email, or other communications to <a href="https://ldfa.nl" target="_blank">https://ldfa.nl</a> and complete registration within thirty days.</p>
					<p>We will only pay commissions on links that are automatically tracked and reported by our systems. We will not pay commissions if someone says they purchased or someone says they entered a referral code if it was not tracked by our system. We can only pay commissions on business generated through properly formatted special links that were automatically tracked by our systems.</p>
					<p>We reserve the right to disqualify commissions earned through fraudulent, illegal, or overly aggressive, questionable sales or marketing methods.</p>
					<p>Referral Commissions are credited to your eLD account instantly when earned properly.</p>
					<p>You may not issue any press release with respect to this Agreement or your participation in the Program; such action may result in your termination from the Program. In addition, you may not in any manner misrepresent or embellish the relationship between us and you, say you develop our products, say you are part of <strong>LDFA</strong> or express or imply any relationship or affiliation between us and you or any other person or entity except as expressly permitted by this Agreement (including by expressing or implying that we support, sponsor, endorse, or contribute money to any charity or other cause).</p>
					<p>You may not purchase products through your affiliate links for your own use. Such purchases may result (in our sole discretion) in the withholding of referral fees and/or the termination of this Agreement.</p>

					<h4>Payment schedule</h4>
					<p>Your Commissions will accrue in your account, increasing the amount of Silver Bullion you own. You may redeem a minimum of One Troy Ounce of your Silver Bullion at any time through the Liberty Dollar Financial Association System, or you may withdraw Silver Certificates for local use.</p>

					<h4>Your responsibilities</h4>
					<p>You will be solely responsible for the development, operation, and maintenance of your site and for all materials that appear on your site. For example, you will be solely responsible for:</p>
					<ul>
						<li>The technical operation of your site and all related equipment</li>
						<li>Ensuring the display of Special Links on your site does not violate any agreement between you and any third party (including without limitation any restrictions or requirements placed on you by a third party that hosts your site)</li>
						<li>The accuracy, truth, and appropriateness of materials posted on your site (including, among other things, all Product-related materials and any information you include within or associate with Special Links)</li>
						<li>Ensuring that materials posted on your site do not violate or infringe upon the rights of any third party (including, for example, copyrights, trademarks, privacy, or other personal or proprietary rights)</li>
						<li>Ensuring that materials posted on your site are not libelous or otherwise illegal</li>
						<li>Ensuring that your site accurately and adequately discloses, either through a privacy policy or otherwise, how you collect, use, store, and disclose data collected from visitors, including, where applicable, that third parties (including advertisers) may serve content and/or advertisements and collect information directly from visitors and may place or recognize cookies on visitors' browsers.</li>
					</ul>

					<h4>Compliance with Laws</h4>
					<p>As a condition to your participation in the Program, you agree that while you are a Program participant you will comply with all laws, ordinances, rules, regulations, orders, licenses, permits, judgments, decisions or other requirements of any governmental authority that has jurisdiction over you, whether those laws, etc. are now in effect or later come into effect during the time you are a Program participant. Without limiting the foregoing obligation, you agree that as a condition of your participation in the Program you will comply with all applicable laws (federal, state or otherwise) that govern marketing email, including without limitation, the CAN-SPAM Act of 2003 and all other anti-spam laws.</p>

					<h4>Term of the Agreement and Program</h4>
					<p>The term of this Agreement will begin upon our acceptance of your Program application and will end when terminated by either party. Either you or we may terminate this Agreement at any time, with or without cause, by giving the other party written or electronic notice of termination. Upon the termination of this Agreement for any reason, you will immediately cease use of, and remove from your site, all links to <a href="https://republicktrust.com" target="_blank">https://republicktrust.com</a>, and all of our trademarks, trade dress, and logos, and all other materials provided by or on behalf of us to you pursuant hereto or in connection with the Program. LDFA reserves the right to end the Program at any time. Upon program termination, LDFA will pay any outstanding earnings accrued above $20.</p>

					<h4>Termination</h4>
					<p><strong>LDFA</strong>, in its sole discretion, has the right to suspend or terminate your account and refuse any and all current or future use of the Program, or any other <strong>LDFA</strong> service, for any reason at any time. Such termination of the Service will result in the deactivation or deletion of your Account or your access to your Account, and the forfeiture and relinquishment of all potential or to-be-paid commissions in your Account if they were earned through fraudulent, illegal, or overly aggressive, questionable sales or marketing methods. <strong>LDFA</strong> reserves the right to refuse service to anyone for any reason at any time.</p>
					<h4>Relationship of Parties</h4>
					<p>You and we are independent contractors, and nothing in this Agreement will create any partnership, joint venture, agency, franchise, sales representative, or employment relationship between the parties. You will have no authority to make or accept any offers or representations on our behalf. You will not make any statement, whether on your site or otherwise, that reasonably would contradict anything in this Section.</p>

					<h4>Limitations of Liability</h4>
					<p>We will not be liable for indirect, special, or consequential damages (or any loss of revenue, profits, or data) arising in connection with this Agreement or the Program, even if we have been advised of the possibility of such damages. Further, our aggregate liability arising with respect to this Agreement and the Program will not exceed the total referral fees paid or payable to you under this Agreement.</p>

					<h4>Disclaimers</h4>
					<p>We make no express or implied warranties or representations with respect to the Program or any products sold through the Program (including, without limitation, warranties of fitness, merchantability, noninfringement, or any implied warranties arising out of a course of performance, dealing, or trade usage). In addition, we make no representation that the operation of the <strong>LDFA</strong> will be uninterrupted or error-free, and we will not be liable for the consequences of any interruptions or errors.</p>

					<h4>Independent Investigation</h4>
					<p>YOU ACKNOWLEDGE THAT YOU HAVE READ THIS AGREEMENT AND AGREE TO ALL ITS TERMS AND CONDITIONS. YOU UNDERSTAND THAT WE MAY AT ANY TIME (DIRECTLY OR INDIRECTLY) SOLICIT CUSTOMER REFERRALS ON TERMS THAT MAY DIFFER FROM THOSE CONTAINED IN THIS AGREEMENT OR OPERATE WEB SITES THAT ARE SIMILAR TO OR COMPETE WITH YOUR WEB SITE. YOU HAVE INDEPENDENTLY EVALUATED THE DESIRABILITY OF PARTICIPATING IN THE PROGRAM AND ARE NOT RELYING ON ANY REPRESENTATION, GUARANTEE, OR STATEMENT OTHER THAN AS SET FORTH IN THIS AGREEMENT.</p>

					<h4>Arbitration</h4>
					<p>Any dispute relating in any way to this Agreement (including any actual or alleged breach hereof), any transactions or activities under this Agreement or your relationship with us or any of our affiliates shall be submitted to confidential arbitration, except that, to the extent you have in any manner violated or threatened to violate our intellectual property rights, we may seek injunctive or other appropriate relief in any state or federal court (and you consent to non-exclusive jurisdiction and venue in such courts) or any other court of competent jurisdiction. Arbitration under this agreement shall be conducted under the rules then prevailing of the American Arbitration Association. The arbitrator's award shall be binding and may be entered as a judgment in any court of competent jurisdiction. To the fullest extent permitted by applicable law, no arbitration under this Agreement shall be joined to an arbitration involving any other party subject to this Agreement, whether through class arbitration proceedings or otherwise.</p>

					<h4>Miscellaneous</h4>
					<p>This Agreement will be governed by the laws of The United States, without reference to rules governing choice of laws. You may not assign this Agreement, by operation of law or otherwise, without our prior written consent. Subject to that restriction, this Agreement will be binding on, inure to the benefit of, and be enforceable against the parties and their respective successors and assigns. Our failure to enforce your strict performance of any provision of this Agreement will not constitute a waiver of our right to subsequently enforce such provision or any other provision of this Agreement.</p>
					<p>The failure of <strong>LDFA</strong> to exercise or enforce any right or provision of the Terms of Service shall not constitute a waiver of such right or provision. The Terms of Service constitutes the entire agreement between you and <strong>LDFA</strong> and govern your use of the Service, superceding any prior agreements between you and <strong>LDFA</strong> (including, but not limited to, any prior versions of the Terms of Service).</p>
				</div>
			</div>

    	</div>

    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection

