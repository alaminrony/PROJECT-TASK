<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface UserInterface
{

    public function list(Request $request);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
