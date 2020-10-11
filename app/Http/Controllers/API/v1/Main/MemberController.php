<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Main\Member;
use App\Http\Resources\Main\MemberResource;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::orderBy('id', 'DESC')->get();

        return $this->sendResponse(MemberResource::collection($member), 'Retrieve member successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $member = Member::create([
            'code'          => $this->getCodeMember(),
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'bop'           => $request->bop,
            'bod'           => date('Y-m-d', strtotime($request->bod)),
            'phone'         => $request->phone,
            'address'       => $request->address,
            'gender_id'     => $request->gender_id
        ]);

        return $this->sendResponse(new MemberResource($member), 'Insert member successfully');
    }

    public function edit($id)
    {
        $member = $this->findById($id);

        if (!$member)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new MemberResource($member), 'Get member successfully');
    }

    public function update(Request $request, $id)
    {
        $member = $this->findById($id);

        if (!$member)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $member->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'bop'           => $request->bop,
            'bod'           => $request->bod,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'gender_id'     => $request->gender_id
        ]);

        return $this->sendResponse(new MemberResource($member), 'Update member successfully');
    }

    public function destroy($id)
    {
        $member = $this->findById($id);

        if (!$member)
        {
            return $this->sendNoData();
        }

        $member->delete();

        return $this->sendSuccess("Delete member successfully");
    }

    public function findById($id)
    {
        $member = Member::find($id);

        return $member;
    }

    public function getCodeMember()
    {
        // format code MBR202010001 ("MBR", "tahun", "bulan", "increment")
        $month  = date('m');
        $year   = date('Y');

        $member = Member::where('code', 'like', 'MBR'.$year.$month.'%')->count();

        if ($member > 0)
        {
            $count = $member+1;
        }
        else {
            $count = 1;
        }

        $digit  = sprintf("%04s", $count);
        $code   = "MBR".$year.$month.$digit;

        return $code;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'first_name' => 'required|string',
            'email' => 'required|email|unique:tm_member',
            'bop'   => 'required|string',
            'bod'   => 'required|date',
            'phone' => 'required|unique:tm_member',
            'address' => 'required',
            'gender_id' => 'required|numeric|exists:tm_gender,id'
        ]);
    }
}
