<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionController extends Controller
{
    
    public function index()
    {
    	return view('question.index');
    }
}
