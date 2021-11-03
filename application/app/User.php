<?php

namespace App;
use App\Models\Wallet;
use Storage;
use App\Models\Ticketcomment;
use App\Models\Currency;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Support\Facades\Crypt;



class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use Impersonate;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar', 'whatsapp', 'phonenumber', 'first_name', 'last_name', 'verified','role_id', 'settings', 'merchant', 'currency_id' ,'social', 'account_status', 'verification_token', 'balance', 'json_data',   'is_ticket_admin' , 'identity_verified', 'referrer_id', 'referral_note', 'card_owner', 'card_cvv', 'card_number', 'card_company', 'card_address', 'card_state', 'card_city', 'card_zip', 'card_country', 'bank_checknum', 'bank_name', 'bank_accountnum', 'bank_routingnum'
    ];

    protected $with = ['profile'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getBankRoutingnumAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setBankRoutingnumAttribute($value)
    {
        $this->attributes['bank_routingnum'] = Crypt::encryptString($value);
    }

    public function getBankAccountnumAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setBankAccountnumAttribute($value)
    {
        $this->attributes['bank_accountnum'] = Crypt::encryptString($value);
    }

    public function getBankChecknumAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setBankChecknumAttribute($value)
    {
        $this->attributes['bank_checknum'] = Crypt::encryptString($value);
    }

    public function getBankNameAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setBankNameAttribute($value)
    {
        $this->attributes['bank_name'] = Crypt::encryptString($value);
    }


    public function getCardCountryAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardCountryAttribute($value)
    {
        $this->attributes['card_country'] = Crypt::encryptString($value);
    }

    public function getCardZipAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardZipAttribute($value)
    {
        $this->attributes['card_zip'] = Crypt::encryptString($value);
    }


    public function getCardCityAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardCityAttribute($value)
    {
        $this->attributes['card_city'] = Crypt::encryptString($value);
    }

    public function getCardStateAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardStateAttribute($value)
    {
        $this->attributes['card_state'] = Crypt::encryptString($value);
    }

    public function getCardAddressAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardAddressAttribute($value)
    {
        $this->attributes['card_address'] = Crypt::encryptString($value);
    }


    public function getCardCompanyAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardCompanyAttribute($value)
    {
        $this->attributes['card_company'] = Crypt::encryptString($value);
    }

    public function getCardOwnerAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardOwnerAttribute($value)
    {
        $this->attributes['card_owner'] = Crypt::encryptString($value);
    }

    public function getCardCvvAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardCvvAttribute($value)
    {
        $this->attributes['card_cvv'] = Crypt::encryptString($value);
    }

    public function getCardNumberAttribute($value)
    {
        if(!empty($value))
            return Crypt::decryptString($value);
        else
            return $value;
    }

    public function setCardNumberAttribute($value)
    {
        $this->attributes['card_number'] = Crypt::encryptString($value);
    }

    public function profile(){
        return $this->hasOne(\App\Models\Profile::class);
    }

    public function RecentActivity(){
        return $this->hasMany(\App\Models\Transaction::class);
    }

    // public function balance(){
    //    return $this->currentWallet()->amount;
    // }

    public function isAdministrator(){
         if (($this->role_id == 3) ||($this->role_id == 1) ||($this->role_id == 4)) {
           return true;
        }
        return false;
    }

    public function isLDAdmin() {
        if ($this->role_id == 3) {
            return true;
         }
         return false;
    }

    public function isExchangeRole() {
        if (($this->role_id == 3) ||($this->role_id == 1) ||($this->role_id == 4)) {
            return true;
         }
         return false;
    }

    public function currentCurrency(){
        if (!is_null($this->currentWallet())) {
             return $this->currentWallet()->currency;
        }

        $currency = Currency::first();
        $wallet = $this->newWallet($currency->id);

        $this->currency_id  =  $currency->id;
        $this->save();
        return $currency;
      
    }

    public function walletsCollection(){
         return $this->hasMany(\App\Models\Wallet::class);
    }

    public function wallets(){
        
        $collection = $this->walletsCollection()->with('Currency')->where('currency_id','!=', $this->currency_id)->get();

        foreach ($collection as $key => $value) {
             if(is_null($value->currency)){
                $collection->forget($key);
             }
        }
       
        return $collection ;
    }

    public function currentWallet(){

        // check if the user curency_id property is an existing currency id
        // if it returns NULL that mean the currency was deleted and the user is using an obsolet currency as a default currency

        if(Currency::where('id', $this->currency_id)->first() != NULL ){

            //check if the user has a wallet on that currency if true return that wallet, else create a new wallet on that currency
            
            $currentWallet = $this->walletsCollection()->with('Currency')->where('currency_id', $this->currency_id)->first();

            if ($currentWallet != NULL) {

                return $currentWallet;
            
            } else {
                // The currency exists in the database but the user does not have a wallet on that currency.
                //Create a new wallet on that currency and  return it

                $wallet = $this->newWallet( $this->currency_id);
                return Wallet::with('Currency')->where('currency_id', $this->currency_id)->where('user_id', $this->id)->first();

            }


        }

        $currency = Currency::orderBy('id','asc')->first();
        $wallet = $this->newWallet($currency->id);

        $this->currency_id  =  $currency->id;
        $this->save();
        return Wallet::with('Currency')->where('currency_id', $currency->id)->where('user_id', $this->id)->first();
    }

    public function currentWalletBalance(){
        return $this->currentWallet()->amount;
    }

    public function walletByCurrencyId($id){
        if (!is_null($this->walletsCollection()->with('Currency')->where('currency_id',$id)->first())) {
            return $this->walletsCollection()->with('Currency')->where('currency_id',$id)->first();
        }
        return $this->newWallet($id);
    }

    public function newWallet($currency_id){

        $wallet = Wallet::where('user_id', $this->id)->where('currency_id', $currency_id)->first();

        if (!is_null($wallet)) {
            return $wallet;
        }

        $currency = Currency::findOrFail($currency_id);

        return Wallet::create([
            'is_crypto' =>  $currency->is_crypto,
            'user_id'   =>  $this->id,
            'currency_id'   =>  $currency_id,
            'amount'    =>  0,
        ]);
    }

    //public function getBalanceAttribute($value){

        //return $this->currentWalletBalance();
    //}

    // public function setBalanceAttribute($value){
    //     $wallet = $this->currentWallet();
    //     $wallet->amount = $value;
    //     $wallet->save();
    // }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function avatar(){
        return $this->avatar;
    }
    public function isActivated(){
        return (bool)$this->verified;
    }

    public function canImpersonate()
    {
        // For example
        return $this->role_id == 1;
    }

    public function getAccountStatus()
    {
        if($this->account_status > 0)
            return "Normal";
        else if($this->account_status == 0)
            return "Suspended";
    }

    public function isSuspended()
    {
        return $this->account_status == 0;
    }

    /**
     * A user has a referrer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    /**
     * A user has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['referral_link'];

    /**
     * Get the user's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        // return $this->referral_link = route('register', ['ref' => $this->name]);
        return "https://ldrep.nl/".$this->name;
    }

    public function getReferralLinkAttributeSecondary()
    {
        return "https://ldrep.nl/User/Page?ref=".$this->name;
    }

    public function getReferralLinkAttributeThird()
    {
        return "https://ldrep.nl/User/Site/teotwawki?ref=".$this->name;
    }

}
