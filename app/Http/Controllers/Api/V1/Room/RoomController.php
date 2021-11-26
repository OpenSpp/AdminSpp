<?php

namespace App\Http\Controllers\Api\V1\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Libraries\Helpers\Api;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
