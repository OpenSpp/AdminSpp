<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'name',
        'price',
        're_registration',
        'description',
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
        'priceRupiah',
        'reRegistrationRupiah',
        'formattedCreatedAt',
        'formattedUpdatedAt',
    ];


    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }
    
    public function getFormattedUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->updated_at)->format('d M Y H:i:s');
    }

    public function getPriceRupiahAttribute($value)
    {
        return rupiah($this->price);
    }

    public function getReRegistrationRupiahAttribute($value)
    {
        return rupiah($this->re_registration);
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->where('rooms.name', 'LIKE', '%'.$term.'%')
            ->orWhere('rooms.description', 'LIKE', '%'.$term.'%');
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

    public static function createRoom($request) {
        $data = $request->validated();

        $room = self::create($data);

        return $room;
    }

    public function updateRoom($request) {
        $data = $request->validated();

        $room = $this->update($data);
        return $room;
    }
}
