<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedBackRequest;
use App\Models\FeedBack;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\MailService;
use Illuminate\Support\Facades\Redirect;


class FeedBackController extends Controller
{
    /**
     * @var MailService
     */
    private MailService $_mainNotification;

    /**
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->_mainNotification = $mailService;
    }

    /**
     * @return View
     * @throws \Exception
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
     * @param StoreFeedBackRequest $request
     * @return RedirectResponse
     * @throws \Exception
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
}
