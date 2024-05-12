<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteQueryRequest;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Reporters\NoteReporter;
use App\Services\NoteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;

    private const ITEMS_PER_PAGE = 20;

    public function index(NoteQueryRequest $request)
    {
        $this->authorize('viewAny', Note::class);
        $builder = app(NoteReporter::class)
            ->setUser(auth()->user())
            ->setLawsuitId($request->query->get('lawsuit_id'))
            ->builder();

        return NoteResource::collection(
            $builder->paginate(min($request->query->get('items_per_page'), self::ITEMS_PER_PAGE)),
        );
    }

    public function store(NoteRequest $request)
    {
        $this->authorize('create', Note::class);

        $note = app(NoteService::class)->create($request->validated(), auth()->user());

        return api_response(new NoteResource($note));
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);

        return api_response(new NoteResource($note->load(['lawsuit', 'customer'])));
    }

    public function update(NoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $note = app(NoteService::class, ['note' => $note])->update($request->validated());

        return api_response(new NoteResource($note));
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return api_response();
    }
}
