@if (count($event) > 0)
    @foreach ($event as $event_data)
        <div class="col-sm-4 mb-5">
            <p class="news_event_small_title">
                @if ($event_data->is_news == 0)
                    Events
                @else
                    News
                @endif
            </p>
            <a href="@if ($event_data->is_news == 0) {{ route('frontend.event.details', $event_data->event_slug) }} @else 
                {{ route('frontend.news.details', $event_data->event_slug) }} @endif"
                class="news_event_div">
                <img class="news_event_div_img" src="{{ asset('') }}{{ $event_data->getFeaturedImage->path }}"
                    alt="...">
                <div class="news_event_div_content">
                    <p class="news_event_div_date">
                        @if ($event_data->start_date != null && $event_data->end_date != null)
                            {{ App\Helpers\Helper::getDateFormat($event_data->start_date, $event_data->end_date) }}
                        @else
                            {{ Carbon\Carbon::parse($event_data->created_at)->format('d F Y') }}
                        @endif
                    </p>
                    <p class="news_event_div_desc">{!! App\Helpers\Helper::getSuperScript($event_data->event_name) !!}</p>
                </div>
            </a>
        </div>
    @endforeach
    <div class="col-sm-12">
        {{ $event->links() }}
    </div>
@endif
