<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */


namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
    ];
    public const BULK_ACTIVATION = 1;
    public const PREFIX = "USR";

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    public function getAvatarAttribute($value)
    {
        $avatar = !is_null($value) ? asset('storage/backend/users/'.$value) :
        'https://ui-avatars.com/api/?name='.$this->first_name.'&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($avatar);
        if (\Str::contains(request()->url(), '/api/vi')) {
            return asset($avatar);
        }
        return $avatar;
    }


    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUSES = [
        "0" => ['label' =>'Inactive','color' => 'danger'],
        "1" => ['label' =>'Active','color' => 'success'],
    ];

    public const ACTIVITY_LOGIN = 1;
    public const ACTIVITY_LOGOUT = 2;
    public const ACTIVITY_VIEW = 3;
    public const ACTIVITY_CREATE = 4;
    public const ACTIVITY_UPDATE = 5;
    public const ACTIVITY_DELETE = 6;
    public const ACTIVITY_STATUS_CHANGE = 7;
    public const ACTIVITES = [
        "1" => ['label' =>'Login','color' => 'danger'],
        "2" => ['label' =>'Logout','color' => 'success'],
        "3" => ['label' =>'View','color' => 'success'],
        "4" => ['label' =>'Create','color' => 'success'],
        "5" => ['label' =>'Update','color' => 'success'],
        "6" => ['label' =>'Delete','color' => 'success'],
        "7" => ['label' =>'Status Change','color' => 'success'],
    ];

    protected $appends = [
        'full_name' , 'name'
      ];
     public const ADMIN_MEMBER_DESIGNATION_NAME_SALES = 1;
    public const ADMIN_MEMBER_DESIGNATION_NAME_CUSTOMER_SUPPORT = 2;
    public const ADMIN_MEMBER_DESIGNATION_NAME_DATA_ENTRY = 3;
    public const ADMIN_MEMBER_DESIGNATION_NAME = [
        "1" => ['label' =>'Sales','color' => 'success'],
        "2" => ['label' =>'Customer Support','color' => 'success'],
        "3" => ['label' =>'Data Entry','color' => 'success'],
    ];
      public const ADMIN_MEMBER_PERMISSION = [
        User::ADMIN_MEMBER_DESIGNATION_NAME_SALES => 
            ['name' =>'Sales','permissions' => [
                "view_order", "add_order", "edit_order", "delete_order","view_payout",
                "add_payout","edit_payout","delete_payout","view_item", "add_item","edit_item","delete_item",  "bulk_upload_item",
               
           ]],

        User::ADMIN_MEMBER_DESIGNATION_NAME_CUSTOMER_SUPPORT => ['name' =>'Customer Support','permissions' => [
            "view_support_ticket","add_support_ticket","edit_support_ticket","show_support_ticket","delete_support_ticket",
         ]],
        User::ADMIN_MEMBER_DESIGNATION_NAME_DATA_ENTRY => ['name' =>'Data Entry','permissions' => [
            "view_enquiry",  "add_website_enquiry", "show_website_enquiry", "edit_website_enquiry","delete_website_enquiry",  "bulk_upload_enquiry","view_newsletter",
            "add_newsletter",
            "edit_newsletter",
            "delete_newsletter",
            "bulk_upload_newsletter","view_Lead",
            "add_Lead",
            "show_Lead",
            "edit_Lead",
            "delete_Lead",
            "bulk_upload_lead",
            "view_category_type",
            "add_category_type",
            "edit_category_type",
            "sync_category_type",
            "view_categories",
            "add_categories",
            "edit_categories",
            "view_slider_type",
            "add_slider_type",
            "edit_slider_type",
            "sync_slider_type",
            "view_slider",
            "add_slider",
            "edit_slider",
            "delete_slider",
            "bulk_upload_slider",
            "view_paragraph",
            "add_paragraph",
            "edit_paragraph",
            "delete_paragraph",
            "bulk_upload_paragraph",
            "view_faq",
            "add_faq",
            "edit_faq",
            "delete_faq",
            "bulk_upload_faq",
            "view_location",
            "add_location",
            "edit_location",
            "view_state",
            "add_state",
            "edit_state",
            "view_city",
            "add_city",
            "edit_city",
            "view_seo",
            "add_seo",
            "edit_seo",
            "delete_seo",
            "view_pages",
            "add_pages",
            "edit_pages","view_template",
            "add_template",
            "show_template",
            "edit_template",
            "delete_template",
            "view_resource","add_resource","edit_resource","delete_resource","view_blog","add_blog","edit_blog","show_blog","delete_blog",
            
         ]],

    ];
    protected function statusParsed(): Attribute
    {
        return  Attribute::make(
            get: fn ($value) =>  (object)self::STATUSES[$this->status],
        );
    }
    public function ekyStatus()
    {
        return $this->belongsTo(UserKyc::class, 'status');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function walletLogs()
    {
        return $this->hasMany(WalletLog::class);
    }
    public function pendingWalletRequest()
    {
        return $this->hasMany(WalletLog::class)->whereStatus(0);
    }
    public function payoutDetails()
    {
        return $this->hasMany(PayoutDetail::class, 'user_id', 'id');
    }
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'user_subscriptions');
    }
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    public function wishlists()
    {
        return $this->hasMany(MyWishlist::class);
    }
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function kycs()
    {
        return $this->hasMany(UserKyc::class);
    }
    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
    public function userNotes()
    {
        return $this->hasMany(UserNote::class, 'type_id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'type_id')->whereType('User');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
    public function getRoleNameAttribute()
    {
        if (!empty($this->roles)) {
            return $this->roles[0]->display_name;
        } else {
            return "No Role" ;
        }
    }
    public function getFullNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }
    public function getNameAttribute()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function getPrefix()
    {
        return "#USR".str_replace('_1', '', '_'.(100000 +$this->id));
    }

    public function scopeWhereRoleIsNot($query, $role = '', $team = null)
    {
        return $query->whereHas(
            'roles',
            function ($roleQuery) use ($role, $team) {
                $roleQuery->whereNotIn('name', $role);
                if (!is_null($team)) {
                    $roleQuery->whereNotIn('team_id', $team->id);
                }
            }
        );
    }
    /**
     * Ecrypt the user's google_2fa secret.
     *
     * @param  string $value
     * @return string
     */
    public function setGoogle2faSecretAttribute($value)
    {
         $this->attributes['google2fa_secret'] = encrypt($value);
    }

    /**
     * Decrypt the user's google_2fa secret.
     *
     * @param  string $value
     * @return string
     */
    public function getGoogle2faSecretAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        return decrypt($value);
    }
}
