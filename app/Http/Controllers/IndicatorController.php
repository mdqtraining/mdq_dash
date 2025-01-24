<?php

namespace App\Http\Controllers;

use App\DataTables\LeadFollowupDataTable;
use Carbon\Carbon;
use App\Models\Lead;
use App\Helper\Reply;
use App\Models\LeadAgent;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Imports\LeadImport;
use App\Jobs\ImportLeadJob;
use App\Models\GdprSetting;
use App\Models\LeadCategory;
use App\Models\LeadFollowUp;
use Illuminate\Http\Request;
use App\Models\PurposeConsent;
use App\DataTables\LeadsDataTable;
use App\Models\PurposeConsentLead;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommonRequest;
use App\DataTables\LeadGDPRDataTable;
use App\DataTables\ProposalDataTable;
use App\DataTables\LeadNotesDataTable;
use App\Http\Requests\Lead\StoreRequest;
use App\Http\Requests\Lead\UpdateRequest;
use App\Http\Requests\Admin\Employee\ImportRequest;
use App\Http\Requests\Admin\Employee\ImportProcessRequest;
use App\Http\Requests\FollowUp\StoreRequest as FollowUpStoreRequest;
use App\Models\LeadCustomForm;
use App\Models\LeadNote;
use App\Models\LeadProduct;
use App\Models\Product;
use App\Traits\ImportExcel;

class LeadController extends Controller
{
    use ImportExcel;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.indicator';
        $this->middleware(function ($request, $next) {
            abort_403(!in_array('indicator', $this->user->modules));
            return $next($request);
        });
    }
}