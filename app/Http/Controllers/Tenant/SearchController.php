<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Services\FrontendService;
use App\Http\Services\FrontendService\KnowledgeCategoryService;
use App\Http\Services\FrontendService\KnowledgeService;
use App\Models\Faq;
use App\Models\FrontendSection;
use App\Models\Knowledge;
use App\Models\KnowledgeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SearchController extends Controller
{
    public function knowledgeSearch(Request $request)
    {

        $request->validate([
            'search' => 'required',
        ]);

        $from = $request['from'];
        $search_text = $request['search'];

        if ($from == 'home') {
            $searchData = Faq::where('question', 'LIKE', '%' . $search_text . '%')
                ->where('created_by', getUserIdByTenant())
                ->get();

            if (count($searchData) > 0) {
                return Redirect::route('clients.show, $id')->with(['data' => $searchData]);
            } else {
                // not found
            }

        } elseif ($from == 'category') {

        } elseif ($from == 'knowledge') {
            $searchData = Knowledge::leftJoin('knowledge_categories', 'knowledge.knowledge_category_id', '=', 'knowledge_categories.id')
                ->where('knowledge.title', 'LIKE', '%' . $search_text . '%')
                ->where('knowledge.created_by', getUserIdByTenant())
                ->get([
                    'knowledge_categories.id as category_id',
                    'knowledge_categories.title as category_title',
                    'knowledge_categories.description as category_desc',
                    'knowledge.*',
                ]);
            if (count($searchData) > 0) {
                // got knowledge page
            } else {
                // not found
            }
        }

    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ]);
        $search_text = $request['search'];
        $data['pageTitle'] = 'Search Result';
        $data['faqs'] = Faq::where('question', 'LIKE', '%' . $search_text . '%')
            ->where('created_by', getUserIdByTenant())
            ->get();
        return view('tenant.search', $data);
    }


    public function searchKnowledge(Request $request)
    {

        $frontendSection = new FrontendService();
        $frontendSection = $frontendSection->getHomeFrontendSection();
        $data['section'] = ['knowledge_area' => $frontendSection->where('slug', 'knowledge_area')->first()];
        $data['lookingSupport'] = FrontendSection::where(['slug' => 'looking_support_area'])->first();
        $search_text = $request->get('query','');

        $data['searchKnowledgeCategory'] = KnowledgeCategory::join('knowledge', 'knowledge_categories.id', '=', 'knowledge.knowledge_category_id')
            ->where('knowledge.title', 'LIKE', '%' . $search_text . '%')
            ->get([
                'knowledge_categories.id as category_id',
                'knowledge_categories.title as category_title',
                'knowledge_categories.description as category_desc',
                'knowledge.*',
            ]);
        return view('tenant.knowledge.knowledge', $data);
    }


    public function searchKnowledgeDetails(Request $request,$id)
    {
        $data['categoryDetails'] = KnowledgeCategory::findOrFail($id);
        $data['knowledgeByCategory'] = $data['categoryDetails']->knowledge;

        $knowledgeCategory = new KnowledgeCategoryService();
        $data['knowledgeCategory'] = $knowledgeCategory->getHomeActiveKnowledgeCategory();

        $knowledge = new KnowledgeService();
        $data['knowledge'] = $knowledge->getHomeActiveKnowledge();


        $search_text  = $request->get('query','');

        $data['searchKnowledge'] = Knowledge::where('knowledge_category_id', $id)->where('title', 'LIKE', '%' . $search_text . '%')->get();

        return view('tenant.knowledge.knowledge-category', $data);
    }


}
