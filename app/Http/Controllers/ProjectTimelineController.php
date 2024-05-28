<?php

namespace App\Http\Controllers;

use App\Models\ProjectTimeline;
use App\Models\ProductTimeline;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Influencer;
use App\Models\SubType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ProjectTimelineController extends Controller
{
    public function getList($id)
    {
        $Item = ProjectTimeline::where('project_id', $id)
            ->get()->toarray();

        if (!empty($Item)) {

            for ($i = 0; $i < count($Item); $i++) {
                $Item[$i]['No'] = $i + 1;
                $Item[$i]['project'] = Project::find($id);
            }
        }

        return $this->returnSuccess('เรียกดูข้อมูลสำเร็จ', $Item);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPage(Request $request)
    {
        $columns = $request->columns;
        $length = $request->length;
        $order = $request->order;
        $search = $request->search;
        $start = $request->start;
        $page = $start / $length + 1;


        $col = array('id', 'project_id', 'influencer_id', 'draft_link_1', 'client_feedback_1', 'admin_feedback_1', 'status_1', 'draft_link_2', 'client_feedback_2', 'admin_feedback_2', 'status_2', 'draft_status', 'post_date', 'post_status', 'post_link', 'post_code', 'stat_view', 'stat_like', 'stat_comment', 'stat_share', 'remark', 'created_at', 'updated_at');

        $orderby = array('id', 'project_id', 'influencer_id', 'draft_link_1', 'client_feedback_1', 'admin_feedback_1', 'status_1', 'draft_link_2', 'client_feedback_2', 'admin_feedback_2', 'status_2', 'draft_status', 'post_date', 'post_status', 'post_link', 'post_code', 'stat_view', 'stat_like', 'stat_comment', 'stat_share', 'remark', 'created_at', 'updated_at');

        $D = Project::select($col);

        if ($orderby[$order[0]['column']]) {
            $D->orderby($orderby[$order[0]['column']], $order[0]['dir']);
        }

        if ($search['value'] != '' && $search['value'] != null) {

            $D->Where(function ($query) use ($search, $col) {

                //search datatable
                $query->orWhere(function ($query) use ($search, $col) {
                    foreach ($col as &$c) {
                        $query->orWhere($c, 'like', '%' . $search['value'] . '%');
                    }
                });
            });
        }

        $d = $D->paginate($length, ['*'], 'page', $page);

        if ($d->isNotEmpty()) {

            //run no
            $No = (($page - 1) * $length);

            for ($i = 0; $i < count($d); $i++) {

                $No = $No + 1;
                $d[$i]->No = $No;
            }
        }

        return $this->returnSuccess('เรียกดูข้อมูลสำเร็จ', $d);
    }

    public function getProductTimelineByMonth(Request $request)
    {
        $project_id = $request->project_id;
        $month = $request->month;
        $year = $request->year;

        $item = ProductTimeline::where('project_id', $project_id)
            ->where('month', $month)
            ->where('year', $year)
            ->with('product_items')
            ->get();

        $productItems = $item->flatMap(function ($item) {
            return $item->product_items;
        });

        // Convert the result to an array
        $productItemsArray = $productItems->toArray();

        return $this->returnSuccess('เรียกดูข้อมูลสำเร็จ', $productItemsArray);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loginBy = "admin";

        DB::beginTransaction();

        try {
            $Item = new ProjectTimeline();

            $Item->project_id = $request->project_id;
            $Item->influencer_id = $request->influencer_id;
            $Item->product_item_id = $request->product_item_id;
            $Item->draft_link1 = $request->draft_link1;
            $Item->client_feedback1 = $request->client_feedback1;
            $Item->admin_feedback1 = $request->admin_feedback1;
            $Item->draft_link2 = $request->draft_link2;
            $Item->client_feedback2 = $request->client_feedback2;
            $Item->admin_feedback2 = $request->admin_feedback2;
            $Item->draft_link3 = $request->draft_link3;
            $Item->client_feedback3 = $request->client_feedback3;
            $Item->admin_feedback3 = $request->admin_feedback3;
            $Item->admin_status = $request->admin_status;
            $Item->client_status = $request->client_status;
            $Item->draft_status = $request->draft_status;
            $Item->post_date = $request->post_date;
            $Item->post_status = $request->post_status;
            $Item->post_link = $request->post_link;
            $Item->post_code = $request->post_code;
            $Item->stat_view = $request->stat_view;
            $Item->stat_like = $request->stat_like;
            $Item->stat_comment = $request->stat_comment;
            $Item->stat_share = $request->stat_share;
            $Item->note1 = $request->note1;
            $Item->contact = $request->contact;
            $Item->pay_rate = $request->pay_rate;
            $Item->sum_rate = $request->sum_rate;
            $Item->des_bill = $request->des_bill;
            $Item->content_style_id = $request->content_style_id;
            $Item->vat = $request->vat;
            $Item->withholding = $request->withholding;
            $Item->product_price = $request->product_price;
            $Item->transfer_amount = $request->transfer_amount;
            $Item->transfer_date = $request->transfer_date;
            $Item->bank_account = $request->bank_account;
            $Item->bank_id = $request->bank_id;
            $Item->bank_brand = $request->bank_brand;
            $Item->name_of_card = $request->name_of_card;
            $Item->id_card = $request->id_card;
            $Item->address_of_card = $request->address_of_card;
            $Item->product_address = $request->product_address;
            $Item->line_id = $request->line_id;
            $Item->image_card = $request->image_card;
            $Item->transfer_email = $request->transfer_email;
            $Item->transfer_link = $request->transfer_link;
            $Item->image_quotation = $request->image_quotation;
            $Item->ecode = $request->ecode;
            $Item->create_by = $loginBy;
            $Item->update_by = $loginBy;

            $Item->save();

            //log
            $userId = $loginBy;
            $type = 'เพิ่มข้อมูล';
            $description = 'ผู้ใช้งาน ' . $userId . ' ได้ทำการ ';
            $this->Log($userId, $description, $type);

            DB::commit();

            return $this->returnSuccess('ดำเนินการสำเร็จ', $Item);
        } catch (\Throwable $e) {
            DB::rollback();

            return $this->returnErrorData('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง ' . $e->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectTimeline  $projectTimeline
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Item = ProjectTimeline::find($id);
        if (!$Item) {
            return $this->returnErrorData('ไม่พบข้อมูลที่ท่านต้องการ', 404);
        }

        return $this->returnSuccess('เรียกดูข้อมูลสำเร็จ', $Item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectTimeline  $projectTimeline
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectTimeline $projectTimeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectTimeline  $projectTimeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectTimeline $projectTimeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectTimeline  $projectTimeline
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $Item = ProjectTimeline::find($id);
            $Item->delete();

            //log
            $userId = "admin";
            $type = 'ลบข้อมูล';
            $description = 'ผู้ใช้งาน ' . $userId . ' ได้ทำการ ' . $type;
            $this->Log($userId, $description, $type);
            //

            DB::commit();

            return $this->returnUpdate('ดำเนินการสำเร็จ');
        } catch (\Throwable $e) {

            DB::rollback();

            return $this->returnErrorData('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง ' . $e, 404);
        }
    }
}
