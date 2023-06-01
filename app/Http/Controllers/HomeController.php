<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Reward;

class HomeController extends Controller
{
    /**
     * Display index Page
     *
     * @return Response
     */
    public function index()
    {
        $meta = [
            'title' => 'Register',
            'description' => 'Have a large reach on social media? Monetize your following with our various campaigns and exclusive promotions.',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.index')->with(
            [
                'bodyid' => 'sticky',
                'activePage' => 'home',
                'meta' => $meta
            ]);
    }

    /**
     * Display Contact Page
     *
     * @return Response
     */
    public function getContact()
    {
        $meta = [
            'title' => 'Contact',
            'description' => 'Contact Us',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.contact')->with(['meta' => $meta]);
    }

    /**
     * Send email from contact page
     *
     * @return
     */
    public function postContact(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name'      => 'required|string|min:3|max:50',
            'email'     => 'required|email|max:255',
            'subject'   => 'required|min:4|max:100',
            'message'   => 'required|string|min:10|max:1000'
        ]);
        if ($validator->fails()) {
            return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }


        Mail::send('emails.contact', ['request' => $request], function ($m) use ($request) {
//            $m->from($request->email, $request->name);
            //$m->to("abdullahnaseer999@gmail.com", "Muhammad Abdullah")->subject($request->subject);
            $m->to("support@epicrevenue.com", "Epic Revenue")->subject($request->subject);
        });

        $request->session()->flash('success', 'Email sent successfully!!!');

        return redirect('/contact');
    }

    /**
     * Display Influencers Page
     *
     * @return Response
     */
    public function earn()
    {
        $meta = [
            'title' => 'Earn',
            'description' => 'Influencers',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.earn')->with(['bodyid' => 'sticky', 'meta' => $meta]);
    }

    /**
     * Display Business Page
     *
     * @return Response
     */
    public function business()
    {
        $meta = [
            'title' => 'Business',
            'description' => 'Advertisers',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.business')->with(['bodyid' => 'sticky', 'meta' => $meta]);
    }

    /**
     * Display About Page
     *
     * @return Response
     */
    public function about()
    {
        $meta = [
            'title' => 'About us',
            'description' => 'About us',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.about')->with(['meta' => $meta]);
    }

    /**
     * Display rewards Page
     *
     * @return Response
     */
    public function rewards()
    {
        $rewards = Reward::get();
        $meta = [
            'title' => 'Rewards',
            'description' => 'Rewards',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.rewards')->with(['bodyid' => 'sticky', 'meta' => $meta, 'rewards' => $rewards]);
    }


    /**
     * Display Faqs Page
     *
     * @return Response
     */
    public function faqs()
    {
        $meta = [
            'title' => 'Frequently Asked Questions',
            'description' => 'Frequently Asked Questions',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.faqs')->with(['meta' => $meta]);
    }

    /**
     * Display Privacy Page
     *
     * @return Response
     */
    public function privacy()
    {
        $meta = [
            'title' => 'Privacy Policy',
            'description' => 'Privacy Policy',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.privacy')->with(['meta' => $meta]);
    }

    /**
     * Display Terms Page
     *
     * @return Response
     */
    public function terms()
    {
        $meta = [
            'title' => 'Terms of Service',
            'description' => 'Terms of Service',
            'keywords'    => 'influencers reach,influencersreach, monetize,instagram, make money, influencersreach.com, payment proof, youtube,leads,apps'
        ];
        return view('home.terms')->with(['meta' => $meta]);
    }


}
