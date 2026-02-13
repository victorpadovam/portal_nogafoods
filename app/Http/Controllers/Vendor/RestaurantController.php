<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\Translation;
use App\Models\Module;


class RestaurantController extends Controller
{
    public function view()
    {
        $shop = Helpers::get_store_data();
        return view('vendor-views.shop.shopInfo', compact('shop'));
    }

    public function edit()
    {
        $store = Helpers::get_store_data();
        $shop = Store::withoutGlobalScope('translate')->findOrFail($store['id']);
        $modules = Module::where('status', 1)->get();
        $pagamentos = $shop->tipo_de_pagamento_da_loja;

        if (is_string($pagamentos)) {
            $pagamentos = json_decode($pagamentos, true);
        }

        if (!is_array($pagamentos)) {
            $pagamentos = [];
        }

        $horarios = $store->listaHorarioDeFuncionamentoDaLoja;

        if (is_string($horarios)) {
            $horarios = json_decode($horarios, true);
        }

        $horarios = $horarios ?? [];
        // dd( $shop);
        return view('vendor-views.shop.edit', compact('shop', 'modules', "pagamentos", "horarios"));
    }

public function update(Request $request)
{
    $shop = Store::findOrFail(Helpers::get_store_id());

    $data = $request->except([
        '_token',
        'image',
        'photo',
        'horarios', 
    ]);

    $data['phone'] = $request->contact;
    $data['meta_title'] = $request->name;

    $shop->fill($data);


        if ($request->hasFile('logo')) {
            $data['logo'] = Helpers::upload('store/', 'png', $request->file('logo'));
        }

            if ($request->hasFile('logo')) {
        $data['logo'] = Helpers::update(
            'store/',
            $shop->logo,
            'png',
            $request->file('logo')
        );
    }

    $shop->save();

    Toastr::success('Atualizado com sucesso');
    return redirect()->back();
}



    public function update_message(Request $request)
    {
        $request->validate([
            'announcement_message' => 'required|max:255',
        ]);
        $shop = Store::findOrFail(Helpers::get_store_id());
        $shop->announcement_message = $request->announcement_message;
        $shop->save();

        Toastr::success(translate('messages.store_data_updated'));
        return redirect()->route('vendor.shop.view');
    }

}
