<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        Report::create($request->all() + ['user_id' => auth()->id()]);
    }

   
    public function show(Report $report)
    {
        //
    }

    
    public function edit(Report $report)
    {
        //
    }

    
    public function update(Request $request, Report $report)
    {
        //
    }

    
    public function destroy(Report $report)
    {
        //
    }
}
