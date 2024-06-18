<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Tools\Repositories\Crud;
use Illuminate\Http\Request;

class MetaManagementController extends Controller
{

    protected $metaModel;

    public function __construct(Meta $meta)
    {
        $this->metaModel = new Crud($meta);
    }

    public function metaIndex()
    {
        $data['pageTitle'] = 'Meta Management';
        $data['navApplicationSettingParentActiveClass'] = 'mm-active';
        $data['subNavMetaSettingActiveClass'] = 'mm-active';
        $data['subMetaIndexActiveClass'] = 'active';
        $data['metas'] = $this->metaModel->getOrderById('DESC', 25);
        return view('admin.setting.general.meta_manage.index', $data);
    }

    public function editMeta($uuid)
    {
        $data['pageTitle'] = 'Edit Meta';
        $data['navApplicationSettingParentActiveClass'] = 'mm-active';
        $data['subNavGeneralSettingActiveClass'] = 'mm-active';
        $data['subMetaIndexActiveClass'] = 'active';
        $data['meta'] = $this->metaModel->getRecordByUuid($uuid);
        return view('admin.setting.general.meta_manage.edit', $data);
    }

    public function updateMeta(Request $request, $uuid)
    {
        $this->metaModel->updateByUuid($request->only($this->metaModel->getModel()->fillable), $uuid);
        return redirect()->route('admin.setting.meta.index')->with('success', __('Updated Successfully'));
    }
}
