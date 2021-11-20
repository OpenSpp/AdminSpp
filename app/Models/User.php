<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'formattedCreatedAt',
        'formattedUpdatedAt',
        'permissions',
        'isAdmin',
        'isSuperAdmin',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function getIsAdminAttribute($value)
    {
        $permission = ['admin', 'super-admin'];
        if(in_array($this->role, $permission)) {
            return true;
        }

        return false;
    }

    public function getIsSuperAdminAttribute($value)
    {
        $permission = ['super-admin'];
        if(in_array($this->role, $permission)) {
            return true;
        }

        return false;
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }
        
    public function getFormattedUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->updated_at)->format('d M Y H:i:s');
    }

    public function getPermissionsAttribute()
    {
        $arrPermission = [
            'admins' => [
                'view' => $this->cannot('index', User::class),
            ],
        ];

        if($this->role === 'super-admin') {
            $arrPermission['admins'] = [
                'view' => $this->can('index', User::class),
            ];
        }

        return $arrPermission;
    }

    public function scopeWhereRole($query, $search)
    {
        $query->where('users.role', $search);
    }

    public function scopeWhereRoleIn($query, $search = [])
    {
        $query->whereIn('users.role', $search);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where('users.name', 'LIKE', '%'.$term.'%')
                ->orWhere('users.email', 'LIKE', '%'.$term.'%');
        }
    }
    
    public function scopeApplyFilters($query, array $filters)
    {
        $filters = collect($filters);
        if ($filters->get('search')) {
            $query->whereSearch($filters->get('search'));
        }
    }

    public function scopePaginateData($query, $limit)
    {
        if ($limit == 'all') {
            return collect(['data' => $query->get()]);
        }

        return $query->paginate($limit);
    }

    public static function createUser($request) {        
        $data = $request;

        $data['password'] = Hash::make($data['password']);

        $user = self::create($data);

        return $user;
    }

    public function updateUser($request) {
        $data = $request;
        
        if($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->update($data);

        return $user;
    }
}
