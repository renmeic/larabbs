<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
    public function me()
    {
    	return $this->response->item($this->user(), new UserTransformer());
    }
}
