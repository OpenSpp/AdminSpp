<?php

namespace App\Http\Controllers\Jetstream\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Libraries\Helpers\Api;

class RoomJsonController extends Controller
{
    /**
     * Retrieve details of an expense receipt from storage.
     *
     * @param   \Crater\Models\Expense $expense
     * @return  \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $limit = $request->has('limit') ? $request->limit : 10;

            $model = Room::applyFilters($request->only([
                    'search',
                ]))
                ->select('rooms.*')
                ->latest()
                ->paginateData($limit);
            
            $paginate = [
                'total' => (int) $model->total(),
                'currentPage' => (int) $model->currentPage(),
                'lastPage' => (int) $model->lastPage(),
                'hasMorePages' => (boolean) $model->hasMorePages(),
                'perPage' => (int) $model->perPage(),
                'total' => (int) $model->total(),
                'lastItem' => (int) $model->lastItem(),
            ];
            
            $success = Api::message(true, [["msg" => ["items"]]], $model->items(),[$paginate]);
            return response()->json($success, 200);
            
        } catch (\Exception $ex) {
            $error = Api::message(false, [["message" => [$ex->getMessage()]]], [], [], []);
            return response()->json($error);
        }
    }
}
