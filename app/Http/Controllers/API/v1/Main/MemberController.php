<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Main\Member;
use App\Http\Resources\Main\Member\MemberResource;
use App\Http\Resources\Main\Member\MemberCollection;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{
    public $oriPath;
    public $thumbPath;

    public function __construct() {
        $this->oriPath      = public_path('images/member/');
        $this->thumbPath    = public_path('images/member/thumb/');
    }

    public function index()
    {
        // fetch data dari model Member order DESC berdasarkan id
        $member = Member::orderBy('id', 'DESC')
            ->get();

        // cek kondisi jika member kosong
        if ($member->isEmpty())
        {
            // maka akan return sendEmpty()
            return $this->sendEmpty();
        }

        // jika tidak maka akan direturn oleh json collection
        return $this->sendResponse(new MemberCollection($member), 1, 'Member');
    }

    public function store(Request $request)
    {
        // validasi request form
        $this->__validate($request);

        // cek kondisi apakah ada input gambar
        if ($request->hasFile('image'))
        {
            // jika ada, tampung dalam variable $img
            $img = $request->file('image');

            // panggil fungsi uploadImage dengan mengirimkan file dengan variable $img
            $imageName = $this->uploadImage($img);
        }
        else {
            // jika tidak maka tampung ke variabel $imageName dengan nilai null
            $imageName = "";
        }

        // membuat data baru dengan model Member
        $member = Member::create([
            'code'          => $this->getCodeMember(),
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'bop'           => $request->bop,
            'bod'           => date('Y-m-d', strtotime($request->bod)),
            'phone'         => $request->phone,
            'address'       => $request->address,
            'gender_id'     => $request->gender_id,
            'image'         => $imageName
        ]);

        // jika create data berhasil akan direturn oleh json resource
        return $this->sendResponse(new MemberResource($member), 2, 'Member');
    }

    public function edit($id)
    {
        // cari data berdasarkan id
        $member = $this->findMemberById($id);

        // cek kondisi jika data tidak ada
        if (!$member)
        {
            // maka direturn sendNoData
            return $this->sendNoData();
        }

        // di return dengan json resource
        return $this->sendResponse(new MemberResource($member), 0, 'Member');
    }

    public function update(Request $request, $id)
    {
        // cari data berdasarkan id
        $member = $this->findMemberById($id);

        // cek kondisi jika data tidak ada
        if (!$member)
        {
            // maka direturn sendNoData
            return $this->sendNoData();
        }

        // validasi form request
        $this->__validate($request);

        // cek apakah request mengirim file image
        if ($request->hasFile('image')) {
            // jika iya akan ditampung ke variable $img
            $img    = $request->file('image');

            // jalankan fungsi uploadImage dengan mengirimkan variable $img
            $imageName  = $this->uploadImage($img);
        }
        else {
            // jika tidak maka nama image menggunakan yang lama
            $imageName  = $member->image;
        }

        // jika member mempunyai image
        if ($member->image != "") {
            // maka file image yang ada di oriPath dan thumbPath akan dihapus
            File::delete($this->oriPath.$member->image);
            File::delete($this->thumbPath.$member->image);
        }

        // update data member
        $member->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'bop'           => $request->bop,
            'bod'           => $request->bod,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'gender_id'     => $request->gender_id,
            'image'         => $imageName
        ]);

        // return dengan json resource
        return $this->sendResponse(new MemberResource($member), 3, 'Member');
    }

    public function destroy($id)
    {
        // mencari data berdasarkan id
        $member = $this->findMemberById($id);

        // cek kondisi jika data tidak ada
        if (!$member)
        {
            // maka direturn sendNoData
            return $this->sendNoData();
        }

        // delete data yang ditemukan
        $member->delete();

        // return dengan message
        return $this->sendDeleteSuccess("Member");
    }

    public function findMemberById($id)
    {
        // eloquent untuk mendapatkan data Member berdasarkan id
        $member = Member::where('id', $id)
            ->first();

        // return dengan variabel $member
        return $member;
    }

    public function getCodeMember()
    {
        // format code MBR202010001 ("MBR", "tahun", "bulan", "increment")
        $month  = date('m');
        $year   = date('Y');

        // menghitung data member dimana codenya berisi MBRYYYYMM%
        $member = Member::where('code', 'like', 'MBR'.$year.$month.'%')
            ->count();

        // cek kondisi jika member > 0
        if ($member > 0)
        {
            // tampung ke variable count, lalu value dari perhitungan $member ditambah 1
            $count = $member+1;
        }
        // jika tidak
        else {
            // tampung nilai 1 ke variable $count
            $count = 1;
        }

        // atur angka ribuan
        $digit  = sprintf("%04s", $count);
        // penggabungan format yang sudah dibuat
        $code   = "MBR".$year.$month.$digit;

        // return format yang sudah jadi dalam variable $code
        return $code;
    }

    public function uploadImage($img)
    {

        // cek apakah folder path tidak ada
        if (!File::isDirectory($this->oriPath))
        {
            // jika tidak ada, maka bikin folder path baru
            File::makeDirectory($this->oriPath, 0777, true, true);
            // beserta dengan thumbnail pathnya
            File::makeDirectory($this->thumbPath, 0777, true, true);
        }

        // rename image file yang dikirim dengan format waktu.uniqid.extension
        $imageName  = time().'.'.uniqid().'.'.$img->getClientOriginalExtension();
        // buat gambar baru dari lokasi file image yang di upload
        $image      = Image::make($img->getRealPath());
        // meresize gambar menjadi 180x180, dengan closure $cons
        $image->resize(180, 180, function($cons)
            {
                // constraint with aspectratio
                $cons->aspectRatio();
            // simpan ke path thumbnail
            })->save($this->thumbPath.'/'.$imageName);
        // simpan ke original path
        $image->save($this->oriPath.'/'.$imageName);

        return $imageName;
    }

    public function __validate($request)
    {
        // validation rules
        return $this->validate($request, [
            'first_name'    => 'required|string',
            'email'         => 'required|email|unique:tm_member',
            'bop'           => 'required|string',
            'bod'           => 'required|date',
            'phone'         => 'required|unique:tm_member',
            'address'       => 'required',
            'gender_id'     => 'required|numeric|exists:tm_gender,id',
            'image'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    }
}
