<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreFeedBackRequest;
use App\Http\Requests\UpdateFeedBackRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeedBackResource;
use App\Models\FeedBack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class FeedBackListController extends Controller
{
    /**
     * @param Request $request
     * @return \Inertia\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per-page', self::PER_PAGE);
        $orderBy = $request->get('per-page', self::ORDER_BY);

        try {
            $feedback = FeedBack::query()
                ->orderBy($orderBy)
                ->paginate($perPage)
                ->appends('per-page', $perPage);

            return Inertia::render('FeedBack', [
                'feedback' => FeedBackResource::collection($feedback),
            ]);
        } catch (\Throwable $e) {
            throw new \Exception('Error render feedback list ' . $e->getMessage());
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

            return Redirect::route('feedback.index')
                ->with('success', 'Відгук доданий дякуємо!');

        } catch (\Throwable $e) {
            throw new \Exception('Error feedback wos not created ' . $e->getMessage());
        }
    }


    /**
     * @param UpdateFeedBackRequest $request
     * @param FeedBack $feedback
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(UpdateFeedBackRequest $request, FeedBack $feedback): RedirectResponse
    {
        try {
            $feedback
                ->fill($request->validated())
                ->updateOrFail();

            return Redirect::route('feedback-list.index')
                ->with('success', 'Відгук оновлено дякуємо!');
        } catch (\Throwable $e) {
            throw new \Exception('Error feedback was not update ' . $e->getMessage());
        }
    }

    /**
     * @param FeedBack $feedback
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(FeedBack $feedback)
    {
        try {
            $feedback->delete();

            return Redirect::route('feedback-list.index')
                ->with('success', 'Відгук видалений!');
        } catch (\Exception $e) {
            throw new \Exception('Error feedback was not delete ' . $e->getMessage());
        }
    }
}
