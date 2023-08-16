<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedBackRequest;
use App\Http\Requests\UpdateFeedBackRequest;
use App\Models\FeedBack;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\MailService;
use Illuminate\Support\Facades\Redirect;


class FeedBackController extends Controller
{
    private MailService $_mainNotification;

    public function __construct(MailService $mailService)
    {
        $this->_mainNotification = $mailService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        try {
            return view('components.feedback')
                ->with('cities', City::all());
        } catch (\Throwable $e) {
            throw new \Exception('Error render feedback form ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedBackRequest $request): RedirectResponse
    {
        try {
            $feedback = new FeedBack();

            $feedback->fill($request->validated())
                ->save();

            $this->_mainNotification->mailNotification($feedback);

            return Redirect::route('feedback.index')
                ->with('success', 'Відгук доданий дякуємо!');

        } catch (\Throwable $e) {
            throw new \Exception('Error feedback wos not created ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedBackRequest $request, FeedBack $feedBack): RedirectResponse
    {
        try {
            $feedBack
                ->fill($request->validated())
                ->updateOrFail();

            return Redirect::route('feedback.index')
                ->with('success', 'Відгук доданий дякуємо!');
        } catch (\Throwable $e) {
            throw new \Exception('Error feedback was not update ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedBack $feedBack)
    {
        try {
            $feedBack->delete();

            return Redirect::route('feedback.index')
                ->with('success', 'Відгук доданий дякуємо!');
        } catch (\Exception $e) {
            throw new \Exception('Error feedback was not delete ' . $e->getMessage());
        }
    }
}
