<?php

namespace App\Console\Commands;

use App\User;
use DrewM\MailChimp\MailChimp;
use Illuminate\Console\Command;

class MailChimpClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailchimp:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It check all the users with mailchimp list and delete all others.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    //protected $confirmed_list_id = 'a80624083c';
    protected $approved_list_id = 'eb077366ac';
    protected $unapproved_list_id = 'd5784040c5';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = array(0);

        $MailChimp = new MailChimp('01ae3ab066471246a04f85c9f9fe4d5b-us11');

        $listUsers = $MailChimp->get("lists/".$this->approved_list_id."/members/?offset=0");
        $count = $listUsers['total_items'];
        for ($i = 0; $i <= (int) round( ($count / 10), 0, PHP_ROUND_HALF_UP); $i++)
        {
            $listUsers = $MailChimp->get("lists/".$this->approved_list_id."/members/?offset=".$i)['members'];
            foreach ($listUsers as $listUser)
            {
                array_push( $emails, [ 'list_id' => $this->approved_list_id, 'email' => $listUser['email_address'] ]);
            }
        }

        $listUsers = $MailChimp->get("lists/".$this->unapproved_list_id."/members/?offset=0");
        $count = $listUsers['total_items'];
        for ($i = 0; $i <= (int) round( ($count / 10), 0, PHP_ROUND_HALF_UP); $i++)
        {
            $listUsers = $MailChimp->get("lists/".$this->unapproved_list_id."/members/?offset=".$i)['members'];
            foreach ($listUsers as $listUser)
            {
                array_push( $emails,[ 'list_id' => $this->unapproved_list_id, 'email' => $listUser['email_address'] ] );
            }
        }

        unset($emails[0]);

        if (count($emails) >= 1)
        {
            // Error: Invalid argument supplied for foreach()
            foreach ($emails as $email)
            {
                if(isset($email['email']) && isset($email['list_id'])) {
                    $user = User::where('email', $email['email'])->first();
                    if(is_null($user))
                    {
                        $this->removeUserFromList($MailChimp, $email['email'], $email['list_id']);
                    }
                }
            }
        }

        return true;
    }


    private function removeUserFromList( MailChimp $mailChimp, $email, $list_id)
    {
        $subscriber_hash = $mailChimp->subscriberHash($email);
        $mailChimp->delete("lists/$list_id/members/$subscriber_hash");

        if($mailChimp->success())
            return true;
        return false;
    }
}
