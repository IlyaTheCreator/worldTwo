<?php

namespace App\Http\Controllers;

use App\Application;
use App\Template;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index() {
        return view('app');
    }

    public function login(Request $request) {
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            return redirect('/admin/home');
        } else {
            return redirect()->back();
        }
    }

    public function getUser() {
        return Auth::user();
    }

    public function apply(Request $request) {
        // storage/app/public
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'type' => 'required'
        ]);

        $application = new Application();
        $application->name = $request->name;
        $application->email = $request->email;
        $application->template = $request->template;
        $application->type = $request->type;
        $application->start_date = $request->startDate;
        $application->end_date = $request->endDate;
        $application->purpose_of_visit = $request->purposeOfVisit;

        $application->status = 'waiting'; // waiting, accepted, declined

        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time().'.'.'png';

        if ($image != '') {
            File::put(public_path() . '/uploads/images/' . $imageName, base64_decode($image));
            $application->path = asset('/uploads/images/'. $imageName) ;
            $application->save();

            return response()->json(['success' => 'заявка успешно принята'], 201);
        } else {
            response()->json(['error' => 'ошибка'], 401);
        }
    }

    public function getApplications() {
        if ($this->loginCheck()) {
            return Application::orderBy('id', 'desc')->get();
        } else {
            return response()->json(['message' => 'not logged in'], 403);
        }
    }

    public function getTemplates() {
        return response()->json(Template::orderBy('id', 'desc')->get(), 200);
    }

    public function createTemplate(Request $request) {
        $request->validate([
            'template' => 'required|mimes:html'
        ]);


        if ($request->hasFile('template')) {
            // get filename with the extension
            $filenameWithExt = $request->file('template')->getClientOriginalName();
            // get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // get just ext
            $ext = $request->file('template')->getClientOriginalExtension();
            // filename to store
            $filenameToStore = $filename.'_'.time().'.'.$ext;
            // upload
            $path = $request->file('template')->move(public_path('/uploads/form-templates/'), $filenameToStore);

            if ($path) {
                Template::create(['path' => 'http://localhost:8000/uploads/form-templates/'.$filenameToStore]);
                return redirect('/admin/templates');
            } else {
                return redirect()->back();
            }
        }

    }

    public function deleteTemplate(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);
        $template = Template::where('id', $request->id)->get()[0];
        $serverPath = $template->path;
        $fileName = substr($serverPath, 45);
        $localPath = public_path('/uploads/form-templates/'). $fileName;

        if (file_exists($localPath)) {
            @unlink($localPath);

            $template->delete();
            return response()->json(['success', 'success'], 200);
        }

        return response()->json(['error', 'error'], 403);

    }

    public function decline(Request $request) {
        $request->validate([
            'id' => 'required',
            'declineReason' => 'required'
        ]);

        Application::where('id', $request->id)->update(['status' => 'declined', 'decline_reason' => $request->declineReason]);
        return response()->json(['success' => $request->declineReason], 200);
    }

    public function accept(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        Application::where('id', $request->id)->update(['status' => 'accepted']);
        return response()->json(['success' => 'успех'], 200);
    }

    public function printApplication(Request $request) {
        $request->validate([
            'id' => 'required'
        ]);

        Application::where('id', $request->id)->update(['status' => 'ready']);
        return response()->json(['success' => 'успех'], 200);
    }

    public function sort(Request $request) {
        $request->validate([
            'status' => 'required'
        ]);

        if ($request->status == 'all') {
            return Application::orderBy('id', 'desc')->get();
        }

        return Application::where('status', $request->status)->orderBy('id', 'desc')->get();
    }

    public function loginCheck() {
        if (Auth::check()) {
            return response()->json(['ok' => 'ok'], 200);
        } else {
            return response()->json(['error' => 'not ok'], 403);
        }
    }
}
