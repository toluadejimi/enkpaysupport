<?php

namespace App\Services;

use App\Models\Currency;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class CurrencyService
{
    use ResponseTrait;

    public function getAllData()
    {
        $currencies = Currency::orderBy('currency_code', 'ASC')->select('id', 'currency_code', 'current_currency', 'symbol', 'currency_placement');
        return datatables($currencies)
            ->addIndexColumn()
            ->editColumn('currency_code', function ($data) {
                $currencyCode = $data->currency_code;
                if($data->current_currency == STATUS_ACTIVE){
                    $currencyCode = $currencyCode.' <b>(Current Currency)';
                }

                return $currencyCode;
            })
            ->addColumn('action', function ($data) {
                return '<div class="action__buttons d-flex justify-content-end">
                    <button onclick="getEditModal(\'' . route('admin.setting.currencies.edit', $data->id).'\'' .', \'#edit-modal\')" class="btn-action mr-1 edit" data-toggle="tooltip" title="Edit">
                        <img src="'.asset('admin/images/icons/edit-2.svg').'" alt="edit">
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.currencies.delete', $data->id) . '\', \'commonDataTable\')" class="p-1 tbl-action-btn"   title="Delete"><span class="iconify" data-icon="ep:delete-filled"></span></button>
                </div>';
            })
            ->rawColumns(['action', 'currency_code'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            $currency = new Currency();
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->save();

            DB::commit();

            if ($request->current_currency)
            {
                Currency::where('id', $currency->id)->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('id', '!=', $currency->id)->update(['current_currency' => STATUS_PENDING]);
            }

            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $currency = Currency::findOrfail($id);
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->save();

            DB::commit();

            if ($request->current_currency)
            {
                Currency::where('id', $currency->id)->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('id', '!=', $currency->id)->update(['current_currency' => STATUS_PENDING]);
            }
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }

    public function getById($id)
    {
        return Currency::findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $currency =  Currency::findOrFail($id);
            $currency->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }
}
