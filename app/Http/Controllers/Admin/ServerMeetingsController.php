<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServerMeeting\BulkDestroyServerMeeting;
use App\Http\Requests\Admin\ServerMeeting\DestroyServerMeeting;
use App\Http\Requests\Admin\ServerMeeting\IndexServerMeeting;
use App\Http\Requests\Admin\ServerMeeting\StoreServerMeeting;
use App\Http\Requests\Admin\ServerMeeting\UpdateServerMeeting;
use App\Models\ServerMeeting;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ServerMeetingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexServerMeeting $request
     * @return array|Factory|View
     */
    public function index(IndexServerMeeting $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ServerMeeting::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'server_id', 'meeting_id', 'meeting_name', 'status', 'start_time'],

            // set columns to searchIn
            ['id', 'meeting_id', 'meeting_name', 'status']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.server-meeting.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.server-meeting.create');

        return view('admin.server-meeting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServerMeeting $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreServerMeeting $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ServerMeeting
        $serverMeeting = ServerMeeting::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/server-meetings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/server-meetings');
    }

    /**
     * Display the specified resource.
     *
     * @param ServerMeeting $serverMeeting
     * @throws AuthorizationException
     * @return void
     */
    public function show(ServerMeeting $serverMeeting)
    {
        $this->authorize('admin.server-meeting.show', $serverMeeting);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServerMeeting $serverMeeting
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ServerMeeting $serverMeeting)
    {
        $this->authorize('admin.server-meeting.edit', $serverMeeting);


        return view('admin.server-meeting.edit', [
            'serverMeeting' => $serverMeeting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServerMeeting $request
     * @param ServerMeeting $serverMeeting
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateServerMeeting $request, ServerMeeting $serverMeeting)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ServerMeeting
        $serverMeeting->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/server-meetings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/server-meetings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyServerMeeting $request
     * @param ServerMeeting $serverMeeting
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyServerMeeting $request, ServerMeeting $serverMeeting)
    {
        //$serverMeeting->delete();

        try {
            endMeeting($serverMeeting->meeting_id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        
        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyServerMeeting $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyServerMeeting $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ServerMeeting::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
