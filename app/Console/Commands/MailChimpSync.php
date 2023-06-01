<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DrewM\MailChimp\MailChimp;
use App\User;
use Illuminate\Support\Facades\Mail;

class MailChimpSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailchimp:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync users with mailchimp list.';


    //protected $confirmed_list_id = 'a80624083c';
    protected $approved_list_id = 'eb077366ac';
    protected $unapproved_list_id = 'd5784040c5';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::with('mailchimp')->get();

        $MailChimp = new MailChimp('01ae3ab066471246a04f85c9f9fe4d5b-us11');

        foreach ($users as $user)
        {
            $email = md5(strtolower($user->email));

            if($user->approved == 'yes') {
                $check = $this->checkApprovedList($MailChimp, $email);
                if (!$check) {
                    if($check['status'] !== 'unsubscribed')
                    {
                        $this->addUserToList($MailChimp, $user, $this->approved_list_id);
                    } else {
                        $this->unsubscribeUser($MailChimp, $user, $this->approved_list_id);
                    }
                    $this->removeUserFromList($MailChimp, $user, $this->unapproved_list_id);
                }
                $this->addUserToList($MailChimp, $user, $this->approved_list_id);
            } else {
                $check = $this->checkUnapprovedList($MailChimp, $email);
                if (!$check) {
                    if($check['status'] !== 'unsubscribed')
                    {
                        $this->addUserToList($MailChimp, $user, $this->unapproved_list_id);
                    } else {
                        $this->unsubscribeUser($MailChimp, $user, $this->unapproved_list_id);
                    }
                    $this->removeUserFromList($MailChimp, $user, $this->approved_list_id);
                }
                $this->addUserToList($MailChimp, $user, $this->unapproved_list_id);
            }

        }

    }


    private function unsubscribeUser( MailChimp $mailChimp, $user, $list_id)
    {
        $mailchimpuser = \App\Models\Mailchimp::where('user_id', $user->id)->where('list_id', $list_id)->first();
        if(!is_null($mailchimpuser)) {
            $mailchimpuser->status = "unsubscribed";
            $mailchimpuser->save();
        }
    }

    private function removeUserFromList( MailChimp $mailChimp, $user, $list_id)
    {
        $subscriber_hash = $mailChimp->subscriberHash($user->email);
        $mailChimp->delete("lists/$list_id/members/$subscriber_hash");

        if($mailChimp->success())
        {
            \App\Models\Mailchimp::where('user_id', $user->id)->where('list_id', $list_id)->delete();
            return true;
        }
        return false;
    }


    private function checkApprovedList( MailChimp $mailChimp, $email)
    {
        $check = $mailChimp->get("lists/$this->approved_list_id/members/$email");
        if($mailChimp->success())
            return $check;
        return false;
    }


    private function checkUnapprovedList( MailChimp $mailChimp, $email)
    {
        $check = $mailChimp->get("lists/$this->unapproved_list_id/members/$email");
        if($mailChimp->success())
            return $check;
        return false;
    }


    private function addUserToList( MailChimp $mailChimp, $user, $list_id)
    {
        $result = $mailChimp->post("lists/$list_id/members", [
            'email_address' => $user->email,
            'status'        => 'subscribed',
            'merge_fields' => ['FNAME'=>$user->firstname, 'LNAME'=>$user->lastname],
            'timestamp_signup' => $user->created_at->toDateTimeString()
        ]);

        $mailchimpuser = \App\Models\Mailchimp::where('user_id', $user->id)->where('list_id', $list_id)->first();
        if(is_null($mailchimpuser)) {
            $mailchimpuser = new \App\Models\Mailchimp();
        }
        $mailchimpuser->list_id = $list_id;
        $mailchimpuser->user_id = $user->id;
        $mailchimpuser->email_address = $user->email;
        $mailchimpuser->firstname = $user->firstname;
        $mailchimpuser->lastname = $user->lastname;
        $mailchimpuser->status = 'subscribed';
        $mailchimpuser->save();

        return $result;
    }
}
