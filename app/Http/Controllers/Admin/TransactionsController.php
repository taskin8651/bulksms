<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TransactionsController extends Controller
{
    use CsvImportTrait;

   public function index(Request $request)
{
    abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        // Remove the user filter to show all transactions, not just the authenticated user's
        $query = Transaction::with(['created_by'])
            ->select(sprintf('%s.*', (new Transaction)->table));
        $table = Datatables::of($query);

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'transaction_show';
            $editGate      = 'transaction_edit';
            $deleteGate    = 'transaction_delete';
            $crudRoutePart = 'transactions';

            return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
        });

        // ID
        $table->editColumn('id', function ($row) {
            return $row->id ?? '';
        });

        // Type
       // Type
$table->editColumn('type', function ($row) {
    if ($row->type === 'credit') {
        return 'Credit';
    } elseif ($row->type === 'debit') {
        return 'Debit';
    }
    return '';
});


        // Amount
        $table->editColumn('amount', function ($row) {
            return $row->amount ?? '0';
        });

        // Balance after
        $table->editColumn('balance_after', function ($row) {
            return $row->balance_after ?? '0';
        });

        // Description
        $table->editColumn('description', function ($row) {
            return $row->description ?? '';
        });

        // Reference - improved to show more meaningful information
        $table->addColumn('reference', function ($row) {
            if (!$row->reference_type) return '';
            
            $modelName = class_basename($row->reference_type);
            return $modelName . ' #' . $row->reference_id;
        });

        // User
        $table->addColumn('user_name', function ($row) {
            return $row->created_by ? $row->created_by->name : '';
        });

        // Date
        $table->editColumn('created_at', function ($row) {
            return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '';
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.transactions.index');
}

    public function create()
    {
        abort_if(Gate::denies('transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.create');
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.edit', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');
    }

    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        $transactions = Transaction::find(request('ids'));

        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
