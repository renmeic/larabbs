<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use App\Models\Image;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{
    public function me()
    {
    	return $this->response->item($this->user(), new UserTransformer());
    }

    public function update(UserRequest $request)
    {
    	$user = $this->user();

    	$attributes = $request->only(['name', 'email', 'introduction']);
    	if($request->avatar_image_id) {
    		$image = Image::find($request->avatar_image_id);

    		$attributes['avatar'] = $image->path;
    	}

    	$user->update($attributes);

    	return $this->response->item($user, new UserTransformer());
    }
}
