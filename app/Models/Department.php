<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\Uuid;
use App\Traits\HasCan;

class Department extends Model
{
    use HasFactory, Uuid, HasCan;

    protected $fillable = [
        'name',
        'queue_code',
        'logo',
        'services_per_day',
        'is_active'
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
        'formattedCreatedAt',
        'formattedUpdatedAt',
    ];

    public function services()
    {
        return $this->hasMany(DepartmentService::class, 'department_id');
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }
    
    public function getFormattedUpdatedAtAttribute($value)
    {
        return Carbon::parse($this->updated_at)->format('d M Y H:i:s');
    }

    public function scopeWhereSearch($query, $search)
    {
        foreach (explode(' ', $search) as $term) {
            $query->whereHas('services', function ($query) use ($term) {
                $query->where('name', 'LIKE', '%'.$term.'%');
            })
            ->orWhere('departments.name', 'LIKE', '%'.$term.'%')
            ->orWhere('departments.queue_code', 'LIKE', '%'.$term.'%');
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

    public static function createDepartment($request) {
        $data = $request->only([
            'name',
            'queue_code',
            'logo',
            'services_per_day',
            'is_active',
        ]);

        $services = $request->only([
            'services',
        ]);

        $department = self::create($data);
        $department->createService($services['services']);

        return $department;
    }

    public function updateDepartment($request) {
        $data = $request->only([
            'name',
            'queue_code',
            'logo',
            'services_per_day',
            'is_active',
        ]);

        $services = $request->only([
            'services',
        ]);

        $department = $this->update($data);
        $this->createService($services['services']);
        return $department;
    }

    public function createService($services) {
        foreach ($services as $key => $value) {
            try {
                $this->services()->updateOrCreate(
                    [
                        'id' => $value['id'] ?? null,
                    ],
                    [
                        'name' => $value['name'] ?? null,
                        'is_active' => $value['is_active'] ?? true,
                    ]
                );
            } catch (\Exception $error) {
                return true;
            }
        }
    }
}
