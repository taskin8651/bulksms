<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWalletRequest;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\Wallet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Transaction;

class WalletController extends Controller
{
    use CsvImportTrait;

   public function index(Request $request)
{
    abort_if(Gate::denies('wallet_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    if ($request->ajax()) {
        $query = Wallet::with(['user'])
        ->where('created_by_id', auth()->user()->id)
        ->select(sprintf('%s.*', (new Wallet)->table));
        $table = Datatables::of($query);

        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', '&nbsp;');

        $table->editColumn('actions', function ($row) {
            $viewGate      = 'wallet_show';
            $editGate      = 'wallet_edit';
            $deleteGate    = 'wallet_delete';
            $crudRoutePart = 'wallets';

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
            return $row->id ? $row->id : '';
        });

        // Balance
        $table->editColumn('balance', function ($row) {
            return $row->balance ?? '0';
        });

        // Status
        $table->editColumn('status', function ($row) {
            return $row->status ? Wallet::STATUS_SELECT[$row->status] : '';
        });

        // User (Created By)
        $table->addColumn('user_name', function ($row) {
            return $row->user ? $row->user->name : '';
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.wallets.index');
}

   public function create()
{
    abort_if(Gate::denies('wallet_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('admin.wallets.create');
}

public function store(StoreWalletRequest $request)
{
    $userId = auth()->id();

    // Pehle check karo kya user ka wallet already exist karta hai
    $wallet = Wallet::where('created_by_id', $userId)->first();

    if ($wallet) {
        // Agar wallet hai to balance me add karo aur status pending rakho
        $wallet->update([
            'balance' => $wallet->balance + $request->balance,
            'status'  => 'pending',
        ]);
    } else {
        // Naya wallet create karo
        $wallet = Wallet::create([
            'balance'       => $request->balance,
            'status'        => 'pending',
            'created_by_id' => $userId,
        ]);
    }

    // ✅ Transaction entry create karo (pending state me)
    Transaction::create([
        'type'          => 'credit',
        'amount'        => $request->balance,
        'balance_after' => $wallet->balance,
        'description'   => 'Wallet top-up request',
        'reference_id'  => $wallet->id,
        'reference_type'=> Wallet::class,
        'created_by_id' => $userId,
    ]);
   

    return redirect()->route('admin.wallets.index')
                     ->with('success', 'Wallet request submitted, pending approval.');
}


    public function edit(Wallet $wallet)
    {
        abort_if(Gate::denies('wallet_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.wallets.edit', compact('wallet'));
    }

    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        $wallet->update($request->all());

        return redirect()->route('admin.wallets.index');
    }

    public function show(Wallet $wallet)
    {
        abort_if(Gate::denies('wallet_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.wallets.show', compact('wallet'));
    }

    public function destroy(Wallet $wallet)
    {
        abort_if(Gate::denies('wallet_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $wallet->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletRequest $request)
    {
        $wallets = Wallet::find(request('ids'));

        foreach ($wallets as $wallet) {
            $wallet->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
