<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Server\BulkDestroyServer;
use App\Http\Requests\Admin\Server\DestroyServer;
use App\Http\Requests\Admin\Server\IndexServer;
use App\Http\Requests\Admin\Server\StoreServer;
use App\Http\Requests\Admin\Server\UpdateServer;
use App\Models\Server;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexServer $request
     * @return array|Factory|View
     */
    public function index(IndexServer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Server::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'base_url', 'sec_secret', 'weight', 'enabled'],

            // set columns to searchIn
            ['id', 'base_url', 'sec_secret']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.server.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.server.create');

        return view('admin.server.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreServer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Server
        $server = Server::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/servers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/servers');
    }

    /**
     * Display the specified resource.
     *
     * @param Server $server
     * @throws AuthorizationException
     * @return void
     */
    public function show(Server $server)
    {
        $this->authorize('admin.server.show', $server);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Server $server
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Server $server)
    {
        $this->authorize('admin.server.edit', $server);


        return view('admin.server.edit', [
            'server' => $server,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServer $request
     * @param Server $server
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateServer $request, Server $server)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Server
        $server->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/servers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/servers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyServer $request
     * @param Server $server
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyServer $request, Server $server)
    {
        $server->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyServer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyServer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Server::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
