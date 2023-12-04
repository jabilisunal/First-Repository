<div class="offcanvas select_offer_modal offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">{{__('book_now')}}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="side_canvas_wrapper">
            <div class="travel_date_side">
                <form action="{{route('bookNow', [$current_language->code])}}" method="post" id="book_now_form">
                    @csrf

                    <input type="hidden" value="{{$model_id}}" name="model_id">
                    <input type="hidden" value="{{$model_type}}" name="model_type">

                    <div class="form-group mb-3">
                        <label for="first_name">{{__('first_name')}}</label>
                        <input type="text" id="first_name" class="form-control bg_input" name="first_name" placeholder="{{__('first_name_placeholder')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="last_name">{{__('last_name')}}</label>
                        <input type="text" id="last_name" class="form-control bg_input" name="last_name" placeholder="{{__('last_name_placeholder')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">{{__('email')}}</label>
                        <input type="text" id="email" class="form-control bg_input" name="email" placeholder="{{__('email_placeholder')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">{{__('phone')}}</label>
                        <input type="text" id="phone" class="form-control bg_input" name="phone" placeholder="{{__('phone_placeholder')}}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="start_date">{{__('start_date')}}</label>
                        <input type="date" id="start_date" name="start_date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="end_date">{{__('end_date')}}</label>
                        <input type="date" id="end_date" name="end_date" value="{{\Carbon\Carbon::now()->addDay(2)->format('Y-m-d')}}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">{{__('special_note_placeholder')}}</label>
                        <textarea rows="5" id="message" name="message" class="form-control" placeholder="{{__('special_note_placeholder')}}"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="proceed_booking_btn ">
        <button type="submit" form="book_now_form" class="btn btn_theme btn_md w-100">{{__('proceed_to_booking')}}</button>
    </div>
</div>
