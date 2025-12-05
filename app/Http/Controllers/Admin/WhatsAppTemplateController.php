<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWhatsAppTemplateRequest;
use App\Http\Requests\StoreWhatsAppTemplateRequest;
use App\Http\Requests\UpdateWhatsAppTemplateRequest;
use App\Models\WhatsAppTemplate;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WhatsAppTemplateController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('whats_app_template_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WhatsAppTemplate::query()->select(sprintf('%s.*', (new WhatsAppTemplate)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'whats_app_template_show';
                $editGate      = 'whats_app_template_edit';
                $deleteGate    = 'whats_app_template_delete';
                $crudRoutePart = 'whats-app-templates';

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
            $table->editColumn('template_name', function ($row) {
                return $row->template_name ? $row->template_name : '';
            });
            $table->editColumn('subject', function ($row) {
                return $row->subject ? $row->subject : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.whatsAppTemplates.index');
    }

   public function create()
{
    abort_if(Gate::denies('whats_app_template_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('admin.whatsAppTemplates.create');
}

public function store(StoreWhatsAppTemplateRequest $request)
{
    $template = WhatsAppTemplate::create($request->validated());

    // Attach CKEditor uploaded media
    if ($media = $request->input('ck-media', false)) {
        Media::whereIn('id', $media)->update(['model_id' => $template->id]);
    }

    return redirect()->route('admin.whats-app-templates.index')
                     ->with('success', 'Template created successfully.');
}


    public function edit(WhatsAppTemplate $whatsAppTemplate)
    {
        abort_if(Gate::denies('whats_app_template_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsAppTemplates.edit', compact('whatsAppTemplate'));
    }

    public function update(UpdateWhatsAppTemplateRequest $request, WhatsAppTemplate $whatsAppTemplate)
    {
        $whatsAppTemplate->update($request->all());

        return redirect()->route('admin.whats-app-templates.index');
    }

    public function show(WhatsAppTemplate $whatsAppTemplate)
    {
        abort_if(Gate::denies('whats_app_template_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsAppTemplates.show', compact('whatsAppTemplate'));
    }

    public function destroy(WhatsAppTemplate $whatsAppTemplate)
    {
        abort_if(Gate::denies('whats_app_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsAppTemplate->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsAppTemplateRequest $request)
    {
        $whatsAppTemplates = WhatsAppTemplate::find(request('ids'));

        foreach ($whatsAppTemplates as $whatsAppTemplate) {
            $whatsAppTemplate->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('whats_app_template_create') && Gate::denies('whats_app_template_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new WhatsAppTemplate();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
