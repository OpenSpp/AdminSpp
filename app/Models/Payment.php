<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'user_id',
        'type',
        'year',
        'month',
        'amount',
    ];

    public $timestamps = true;

    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $appends = [
        'amountRupiah',
        'formattedCreatedAt',
        'formattedUpdatedAt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }
    
    public function getFormattedUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->updated_at)->format('d M Y H:i:s');
    }

    public function getAmountRupiahAttribute($value)
    {
        return rupiah($this->amount);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->whereHas('user', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%')
                        ->orWhere('email', 'LIKE', '%'.$term.'%');
            })->orWhereHas('student', function ($query) use ($term) {
                $query->where('nis', 'LIKE', '%'.$term.'%')
                        ->orWhere('nisn', 'LIKE', '%'.$term.'%');
            })->orWhereHas('student.room', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%');
            });
        }
    }

    public function scopeWhereTypeIn($query, $search = [])
    {
        $query->whereIn('type', $search);
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

    public static function createPayment($request) {        
        $data = $request->validated();
        $payment = self::create($data);

        return $payment;
    }

    public function updatePayment($request) {
        $data = $request->validated();
        $user = $this->update($data);

        return $user;
    }

}
