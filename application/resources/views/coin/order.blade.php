@extends('layouts.app')

@section('content')
    <div class="row clearfix">
        @include('partials.sidebar')
        <div class="col-md-9">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2><strong>Order</strong> Coin</h2>
                </div>
                <div class="body">
                    <h4>It's coming back!</h4>  

                    <p>
                        <img src="{{ asset('assets/images/ldfa_coin.png') }}" class="float-left w-25 rounded-circle">
                        &nbsp;&nbsp;Yes , the Silver Liberty is making a comeback, because Members of LDFA can legally use Silver Libertys to conduct business between them. They’ll be available in about six weeks, and this is allowing us to bring back one of the most important aspects of the old Liberty Dollar—the ability to get it at a discount, and use it at a profit!
                        <br>
                        &nbsp;&nbsp;Embossed on the back of every Silver Liberty is a QR code that, when scanned, leads directly to the LDFA Trade Value Page. In order to make Silver Libertys viable as a medium of exchange, it is necessary to establish a trade value. In order to do that, we have established a trade value at $10 over SPOT. Members can purchase Silver Libertys at only $7 over SPOT, leading to a small but far from negligible profit whenever it is spent or given out in change.
                        <br>
                        &nbsp;&nbsp;It is necessary to remember, however, that 18 USC 486 does make it a crime to use silver, gold or any other kind of metal coin as money in the public sphere. Within the Private Membership Association of LDFA, however, Members may use any medium of exchange they choose. Just be sure to only spend it with someone you know to be a Member.
                        <br>
                        &nbsp;&nbsp;On the other hand, you can show your Silver Liberty to anyone you like, including the guy who owns a business you would like to use it at. As Bernard loves to say, “Do the drop!” Simply drop the Silver Liberty onto the palm of the person you’re showing it to, and watch their eyes light up. There’s nothing like the feel of an ounce of silver smacking your hand.
                        <br>
                        &nbsp;&nbsp;And of course, you just opened the conversation that will lead to making them a Member of LDFA, and your referral. Think about how many of your friends and acquaintances you can approach with Silver Liberty in hand.
                        <br>
                        &nbsp;&nbsp;Silver Libertys will be available around Thanksgiving, but you can preorder them now at SPOT plus $7. Get your orders in now, while the SPOT Price is low.
                    </p>
                    <hr>
                    <form method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Shipping Address</label>
                                <input type="text" name="shipping_address" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Quantity</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success themeButton float-right" id="btn-order">Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
