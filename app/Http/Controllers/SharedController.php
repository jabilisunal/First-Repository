<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\OrderRequest;
use App\Models\Page;
use App\Models\Place;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SharedController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function faqs(): Factory|View|Application
    {
        $faqs = Faq::where(['status' => 1])->get();

        return view('pages.faqs.index', [
            'faqs' => $faqs
        ]);
    }

    /**
     * @return Factory|View|Application
     */
    public function contact(): Factory|View|Application
    {
        return view('pages.contact.index');
    }

    /**
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function pages(string $locale, string $slug): Factory|View|Application
    {
        $page = Page::where(['status' => 1, 'slug' => $slug])->first();

        abort_if(!$page, Response::HTTP_NOT_FOUND);

        return view('pages.page.show', ['page' => $page]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @return RedirectResponse
     */
    public function storeReview(Request $request, string $locale): RedirectResponse
    {
        $request->validate([
            'model_id' => 'required',
            'model_type' => 'required',
            'rating' => 'required',
            'full_name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ], [
            'model_id.required' => __('model_id_required_validation'),
            'model_type.required' => __('model_type_required_validation'),
            'rating.required' => __('rating_required_validation'),
            'full_name.required' => __('full_name_required_validation'),
            'email.required' => __('email_required_validation'),
            'message.required' => __('message_required_validation'),
        ]);

        $modelId = $request->input('model_id');

        $modelType = $request->input('model_type');

        if (!class_exists($modelType)) {
            return redirect()->back()
                ->with('show', true)
                ->with('type', 'error')
                ->with('message', __('store_review_error_message'));
        }

        $model = $modelType::findOrFail($modelId);

        Review::create([
            "model_id" => $model->id,
            "model_type" => $modelType,
            "rating" => $request->input('rating') ?? 0,
            "full_name" => $request->input('full_name'),
            "email" => $request->input('email'),
            "message" => $request->input('message')
        ]);

        return redirect()
            ->with('show', true)
            ->with('type', 'success')
            ->with('message', __('store_review_success_message'));
    }

    /**
     * @param Request $request
     * @param string $locale
     * @return RedirectResponse
     */
    public function bookNow(Request $request, string $locale): RedirectResponse
    {
        $request->validate([
            'model_id' => 'required',
            'model_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'message' => 'required',
        ], [
            'model_id.required' => __('model_id_required_validation'),
            'model_type.required' => __('model_type_required_validation'),
            'first_name.required' => __('name_required_validation'),
            'last_name.required' => __('surname_required_validation'),
            'email.required' => __('email_required_validation'),
            'phone.required' => __('phone_required_validation'),
            'start_date.required' => __('start_date_required_validation'),
            'end_date.required' => __('end_date_required_validation'),
            'message.required' => __('message_required_validation'),
        ]);

        $modelId = $request->input('model_id');

        $modelType = $request->input('model_type');

        if (!class_exists($modelType)) {
            return redirect()->back()
                ->with('show', true)
                ->with('type', 'error')
                ->with('message', __('book_now_error_message'));
        }

        $model = $modelType::findOrFail($modelId);


        OrderRequest::create([
            "model_id" => $model->id,
            "model_type" => $modelType,
            "name" => $request->input('first_name'),
            "surname" => $request->input('last_name'),
            "email" => $request->input('email'),
            "phone" => $request->input('phone'),
            "start_date" => $request->input('start_date'),
            "end_date" => $request->input('end_date'),
            "message" => $request->input('message')
        ]);

        return redirect()->back()
            ->with('show', true)
            ->with('type', 'success')
            ->with('message', __('book_now_success_message'));
    }
}
