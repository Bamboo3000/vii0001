<?php namespace Sative\Contact\Components;

use Cms\Classes\ComponentBase;
use Input;
use Flash;
use Redirect;
use Request;
use Mail;
use Validator;
// use \Anhskohbo\NoCaptcha\NoCaptcha;

class Form extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Form Component',
            'description' => 'No description provided yet...'
        ];
    }

    // public function onRun()
	// {
    //     // $this->page['cvCaptcha'] = app('captcha')->display(['data-callback' => 'cvCaptchaCallback']);
    //     // $this->page['appCaptcha'] = app('captcha')->display(['data-callback' => 'appCaptchaCallback']);
	// }

    /*
    *
    * Form submit script
    *
    */
    protected function onFormSubmit()
    {

        $form_data = [
            'names'     => Input::get('names'),
            'company'   => Input::get('company'),
            'email'     => Input::get('email'),
            'phone'     => Input::get('phone'),
            'info'      => Input::get('message')
        ];

        $rules = [
			'names'	        => 'required|min:3',
			'email'		    => 'required|email',
			'message'       => 'required|min:10'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            $messages = $validator->messages();
            foreach ($messages->all() as $message) {
                Flash::error($message);
            }
		} else {

            $this->sendMail($form_data, 'Thanks for sending your enquiry', 'enquiry');
            Flash::success('Thank you! Your enquiry was submitted successfully.');

        }
        
        return Redirect::back();
        die();
    }

    protected function sendMail($inputs, $subject, $template)
    {
        Mail::send('sative.contact::mail.'.$template, $inputs, function($message) use ($inputs, $subject){

            $message->from('info@viiproductions.com', 'Vii Productions');
            $message->to($inputs['email'], $inputs['names']);
            $message->subject($subject);

        });

        Mail::send('sative.contact::mail.'.$template, $inputs, function($message) {

            $message->from('web@viiproductions.com', 'Vii Productions');
            $message->to('info@viiproductions.com');
            $message->subject('Enquiry from Vii Productions website.');

        });
    }

}