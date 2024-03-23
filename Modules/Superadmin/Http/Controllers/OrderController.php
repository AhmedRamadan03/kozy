<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Http\Requests\StoreColorAndSizeRequest;
use Modules\Superadmin\Http\Requests\ChangeStatus;

class OrderController extends Controller
{
    protected $model ;

    public function __construct(Order $model){
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $title = __('lang.delete_item');
        $text = __('lang.are_you_sure');
        confirmDelete($title, $text);


        return view('superadmin::orders.index',[
            'data' => $this->model->forDrobDown()->filter()->latest()->paginate(20),
            'statuses' =>  $this->model->statuses(),

        ]);
    }






    /**
     * Show the  resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $resource = $this->model->findOrFail($id);
        $resource->show = 1;
        $resource->save();
        return view('superadmin::orders.show' ,[
            'data' => $resource,
            'statuses' =>  $this->model->statuses(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreColorAndSizeRequest $request
     * @param int $id
     * @return Renderable
     */
    public function status( $id)
    {
        $resource =  $this->model->findOrFail($id);
        $old = $resource->toArray();


        $resource->update([
            'status' => request('status'),
            'show' => 1
        ]);

        $logData = ['old_data' => $old,'new_data'=> $resource->toArray()];
        setLogs('update', 'order', $resource, $logData );

        toast(__('lang.updated'), 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        setLogs('delete', 'color', $data,$data->toArray()  );
        $data->delete();
        toast(__('lang.deleted'), 'success');
        return back();
    }


    public function getNotesModal($id)
    {
        $data = $this->model->findOrFail($id);
        return view('superadmin::orders.notes_modal', compact('data'));
    }

    public function saveAdminNotes(Request $request)
    {
        $data = $this->model->findOrFail($request->id);
        $data->admin_notes = $request->notes;
        $data->save();
        toast(__('lang.updated'), 'success');
        return back();
    }


    public function pdfview(Request $request, $id)
    {
        // Get & Check Data
        $data = $this->model
            ->withCount('details')
            ->findOrFail($id);
        // Update Order Show


            $html = View('superadmin::orders.pdf_page', compact('data'));

            //return $html;
            $stylesheet = file_get_contents('assets/css/pdf.css');
            //$pdf = PDF::loadHTML($html);
            $pdf = new \Mpdf\Mpdf();
            $pdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            //$pdf->WriteHTML($stylesheet2,\Mpdf\HTMLParserMode::HEADER_CSS);
            $pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

            return $pdf->Output('order-details.pdf', 'D');


        return view('superadmin::orders.pdf_page', compact('data'));
    }

}
