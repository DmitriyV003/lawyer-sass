<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorityRequest;
use App\Http\Resources\AuthorityResource;
use App\Models\Authority;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuthorityController extends Controller
{
    use AuthorizesRequests;

    public function store(AuthorityRequest $request)
    {
        $this->authorize('create', Authority::class);

        return api_response(new AuthorityResource(Authority::create($request->validated())));
    }

    public function show(Authority $authority)
    {
        $this->authorize('view', $authority);

        return api_response(new AuthorityResource($authority));
    }

    public function update(AuthorityRequest $request, Authority $authority)
    {
        $this->authorize('update', $authority);

        $authority->update($request->validated());

        return api_response(new AuthorityResource($authority));
    }

    public function destroy(Authority $authority)
    {
        $this->authorize('delete', $authority);

        $authority->delete();

        return api_response();
    }
}
