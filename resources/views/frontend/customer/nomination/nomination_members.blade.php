<div class="table_div my-5">
    <table class="table site_table table-borderless">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Country</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($all_customer_for_nomintion))
                @foreach ($all_customer_for_nomintion as $members)
                    <tr>
                        <td>
                            <div class="nominee_thumb">
                                <img src="{{ $members->profile_pic == null ? asset('assets/frontend/images/user_thumb.jpg') : asset('uploads/profile_pic/' . $members->profile_pic) }}"
                                    alt="...">
                            </div>
                        </td>
                        <td>{{ $members->user_name }}</td>
                        <td>{{ $members->country }}</td>
                        <td style="vertical-align: middle;">
                            <div class="d-flex justify-content-center">
                                @if ($members->social_media_link != null)
                                    <a class="nominee_action_btn mr-2" href="{{ $members->social_media_link }}"
                                        target="_blank">
                                        <svg width="48" height="48" viewBox="0 0 48 48">
                                            <defs>
                                                <clipPath id="clip-path">
                                                    <rect id="Rectangle_6191" data-name="Rectangle 6191" width="9.606"
                                                        height="21.27" fill="none" />
                                                </clipPath>
                                            </defs>
                                            <g id="Group_15107" data-name="Group 15107"
                                                transform="translate(-1101 -966)">
                                                <circle id="Ellipse_167" data-name="Ellipse 167" cx="24"
                                                    cy="24" r="24" transform="translate(1101 966)"
                                                    fill="#059" />
                                                <g id="Group_15196" data-name="Group 15196"
                                                    transform="translate(1120.197 979.365)">
                                                    <g id="Group_15196-2" data-name="Group 15196"
                                                        clip-path="url(#clip-path)">
                                                        <path id="Path_15276" data-name="Path 15276"
                                                            d="M9.385,80.294c-.107.418-.2.747-.276,1.079a.262.262,0,0,1-.186.2A10.488,10.488,0,0,1,4.4,82.584a3.257,3.257,0,0,1-2.883-2.067,3.938,3.938,0,0,1-.006-1.846c.266-1.555.827-3.033,1.234-4.551a9.843,9.843,0,0,0,.459-2.308c.024-1.006-.425-1.445-1.441-1.417A5.677,5.677,0,0,0,0,70.786a7.413,7.413,0,0,1,.254-1.137.237.237,0,0,1,.165-.173,11.008,11.008,0,0,1,4.569-1.016,2.941,2.941,0,0,1,2.735,2.1,5.1,5.1,0,0,1-.1,2.34C7.2,74.683,6.554,76.409,6.164,78.2a5.555,5.555,0,0,0-.144,1.231,1.037,1.037,0,0,0,.919,1.14,4.22,4.22,0,0,0,2.446-.282"
                                                            transform="translate(0 -61.332)" fill="#fff" />
                                                        <path id="Path_15277" data-name="Path 15277"
                                                            d="M42.883,0a2.583,2.583,0,0,1,2.744,2.538,2.486,2.486,0,0,1-1.941,2.3A2.83,2.83,0,0,1,40.45,3.523,2.469,2.469,0,0,1,42.59.017C42.7.006,42.811,0,42.883,0"
                                                            transform="translate(-36.021)" fill="#fff" />
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="nominee_action_tooltip">
                                            Read more
                                        </span>
                                    </a>
                                @endif
                                <div class="nominee_action_btn nominate_popop_trigger"
                                    onclick="get_member_details('{{ $members->user_name }}','{{ $members->profile_pic }}','{{ $members->id }}')">
                                    <svg xmlns="" class="nominee_check" xmlns:xlink="" width="48px"
                                        height="48px" fill="#059" viewBox="0 0 48 48" version="1.1">
                                        <g id="surface1">
                                            <path style=" stroke:none;fill-rule:nonzero;fill-opacity:1;"
                                                d="M 24 47.996094 C 17.632812 48.011719 11.523438 45.480469 7.03125 40.96875 C 2.515625 36.476562 -0.015625 30.363281 0 23.996094 C -0.015625 17.628906 2.515625 11.515625 7.03125 7.023438 C 11.523438 2.507812 17.632812 -0.0234375 24 -0.00390625 C 30.371094 -0.0234375 36.480469 2.507812 40.972656 7.023438 C 45.488281 11.515625 48.019531 17.628906 48 23.996094 C 48.019531 30.363281 45.488281 36.476562 40.972656 40.96875 C 36.480469 45.480469 30.371094 48.011719 24 47.996094 Z M 19.96875 34.855469 C 20.019531 34.859375 20.070312 34.859375 20.121094 34.855469 C 20.574219 34.839844 21 34.640625 21.300781 34.300781 L 29.332031 26.269531 L 37.445312 18.160156 L 37.476562 18.121094 L 37.492188 18.105469 C 37.550781 18.042969 37.605469 17.980469 37.660156 17.914062 C 38.007812 17.4375 38.101562 16.820312 37.917969 16.257812 C 37.746094 15.71875 37.320312 15.296875 36.78125 15.128906 C 36.601562 15.070312 36.410156 15.039062 36.222656 15.039062 L 36.160156 15.039062 C 35.609375 15.0625 35.09375 15.3125 34.730469 15.726562 C 32.234375 18.222656 29.714844 20.753906 27.542969 22.925781 C 25.1875 25.28125 22.746094 27.726562 20.359375 30.121094 C 20.191406 30.292969 20.078125 30.363281 19.964844 30.363281 C 19.851562 30.363281 19.734375 30.292969 19.566406 30.121094 C 17.609375 28.144531 15.585938 26.113281 13.183594 23.726562 C 12.824219 23.359375 12.335938 23.152344 11.824219 23.148438 C 11.351562 23.148438 10.894531 23.335938 10.558594 23.671875 C 10.226562 24 10.035156 24.445312 10.019531 24.910156 L 10.019531 24.957031 C 10.039062 25.460938 10.25 25.9375 10.613281 26.289062 C 11.957031 27.632812 13.3125 28.988281 14.644531 30.320312 L 15.960938 31.636719 L 18.640625 34.3125 C 18.949219 34.644531 19.378906 34.839844 19.832031 34.847656 L 19.972656 34.847656 Z M 19.96875 34.855469 " />
                                        </g>
                                    </svg>

                                    <span class="nominee_action_tooltip">
                                        Nominate
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center" style="color: red" id="empty_msg">No record found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@if (count($all_customer_for_nomintion))
    {{ $all_customer_for_nomintion->links() }}
@endif
