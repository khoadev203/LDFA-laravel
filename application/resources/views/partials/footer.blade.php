<section id="footer" class="hidden">
		<div class="container">
			<div class="row text-center text-xs-center text-sm-left text-md-left">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="card l-blue">
                    <div class="body block-header">
                    	<h5>{{__('Help and Support')}}</h5>
                    	<ul class="list-unstyled quick-links">
						<li><a href="{{url('/')}}/page/3"><i class="fa fa-angle-double-right"></i>{{__('About')}}</a></li>
						<li><a href="{{url('/')}}/page/6""><i class="fa fa-angle-double-right"></i>{{__('FAQ')}}</a></li>
						<li><a href="{{url('/')}}/page/4"><i class="fa fa-angle-double-right"></i>{{__('Terms of Use')}}</a></li>
						<li><a href="{{url('/')}}/page/5"><i class="fa fa-angle-double-right"></i>{{__('Privacy Policy')}}</a></li>
					</ul>
                    </div>
                	</div>
					
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="card overflowhidden l-seagreen">
		        		<div class="body">
		        			<h5 class="text-purple">{{__('Accepting Liberty Dollars in-store')}}</h5>
			            	<p>{{__('Outdo your online competition by giving your customers a better way to pay. Modernize your brick-and-mortar store by letting your customers pay with')}} {{ setting('site.site_name') }} Silver. Use your computer or our forthcoming Android APP for POS Transactions, or take LDFA Silver Certificates like cash!</p>
			            	
			            	<p>Put LDFA On Your Home Screen: <a href="{{route('download', 'ldfa.zip')}}" style="color:#3f00ff; text-decoration:underline;"><b>Download the app</b></a></p>

			            	<div class="clearfix"></div>
			        	</div>
		    		</div>
					
				</div>
				
		</div>
</section>
<section id="footer2">
	<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center ">
					{!! setting('footer.footer_text') !!}
				</div>
			</div>	
		</div>
</section>