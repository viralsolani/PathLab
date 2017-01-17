<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Access\Role\Role;
use App\Models\User;
use App\Repositories\DbRepository;

/**
 * Class UserRepository
 *
 */
class UserRepository extends DbRepository
{
    use FileUploadTrait;

    /**
     * Construct
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Create User
     *
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $request = $this->saveFiles($request);

        $user =  $this->model->create($request->all());

        if($user)
        {
            $this->sendConfirmationEmail($request);
        }

        return $user;
    }

    /**
     * Update User
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $request = $this->saveFiles($request);

        $user = $this->findOrThrowException($id);

        $user->update($request->all());
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
            $mail->SMTPSecure = 'tls';
            $mail->Host       = 'smtp.gmail.com';
            $mail->Port       = '587';
            $mail->Username   = 'solani.viral@gmail.com';
            $mail->Password   = '0288541828';
            $mail->Subject    = "ABC Pathology Lab : PASSCODE ";
            $mail->From       = "myemail@abcpathologylab.com";
            $mail->FromName   = "ABC Pathology lab";


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
