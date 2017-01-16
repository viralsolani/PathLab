<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class UsersController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_access')) {
            return abort(401);
        }
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        return view('users.create', $relations);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }

        $request = $this->saveFiles($request);
        $user = User::create($request->all());

       if($user)
       {
            $this->sendConfirmationEmail($request);
       }

        return redirect()->route('users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $user = User::findOrFail($id);

        return view('users.edit', compact('user') + $relations);
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('users.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }
        $relations = [
            'roles' => \App\Role::get()->pluck('title', 'id')->prepend('Please select', ''),
        ];

        $user = User::findOrFail($id);

        return view('users.show', compact('user') + $relations);
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Send Passcode To User whose role is patient
     *
     * @param  object $user
     * @return bool
     */
    public function sendConfirmationEmail($input)
    {
        try
        {
            # set up PHPMailer Library
            $mail = new \PHPMailer(true);

            # variables
            $title    = "Your Passcode for login";


            # set the PHPMailer properties
            $mail->isSMTP();
            $mail->CharSet    = "utf-8";
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = env('MAIL_ENCRYPTION','tls');
            $mail->Host       = env('MAIL_HOST','smtp.gmail.com');
            $mail->Port       = env('MAIL_PORT','587');
            $mail->Username   = env('MAIL_USERNAME','p.vansia@gmail.com');
            $mail->Password   = env('MAIL_PASSWORD','Aanya!l00k');
            $mail->Subject    = "Pathology Lab Report : PASSCODE ";
            $mail->From       = "myemail@gmail.com";
            $mail->FromName   = "Web Site";


            $mail->MsgHTML(
                'PASSCODE : '.$input->password
            );

            $mail->addAddress(
                $input->email, 'test'
            );

            # send email
            return $mail->send();
        }
        catch (phpmailerException $e)
        {
            return false;
        }
        catch (Exception $e)
        {
            return false;
        }

    }

}
