<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOrganizerRequest;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use App\Models\Organizer;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OrganizerController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('organizer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Organizer::query()->select(sprintf('%s.*', (new Organizer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'organizer_show';
                $editGate      = 'organizer_edit';
                $deleteGate    = 'organizer_delete';
                $crudRoutePart = 'organizers';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.organizers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('organizer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.organizers.create');
    }

    public function store(StoreOrganizerRequest $request)
    {
        $organizer = Organizer::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $organizer->id]);
        }

        return redirect()->route('admin.organizers.index');
    }

    public function edit(Organizer $organizer)
    {
        abort_if(Gate::denies('organizer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(UpdateOrganizerRequest $request, Organizer $organizer)
    {
        $organizer->update($request->all());

        return redirect()->route('admin.organizers.index');
    }

    public function show(Organizer $organizer)
    {
        abort_if(Gate::denies('organizer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.organizers.show', compact('organizer'));
    }

    public function destroy(Organizer $organizer)
    {
        abort_if(Gate::denies('organizer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizer->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrganizerRequest $request)
    {
        $organizers = Organizer::find(request('ids'));

        foreach ($organizers as $organizer) {
            $organizer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('organizer_create') && Gate::denies('organizer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Organizer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
