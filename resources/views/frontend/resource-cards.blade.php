@if (isset($resource->getResourceMenu))
    @if (count($resource->getResourceMenu))
        @foreach ($resource->getResourceMenu as $key => $menu_details)
            <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="tab_{{ $menu_details->id }}_content"
                role="tabpanel" aria-labelledby="tab_{{ $menu_details->id }}_content">
                <div class="row">
                    @if (isset($menu_details->getResourceCard))
                        @if (count($menu_details->getResourceCard))
                            @foreach ($menu_details->getResourceCard as $cards)
                                <div class="col-sm-6 mb-4">
                                    @if ($cards->status == '1' || Auth::guard('customer')->check())
                                        <a href="{{ $cards->link }}" target="_blank" class="resources_items">
                                        @else
                                            <a data-toggle="modal" data-target="#exampleModalCenter"
                                                class="resources_items">
                                    @endif

                                    <div class="resources_items_left">
                                        <div class="resources_items_icon">
                                            <img class="icon_blue" src="{{ asset('') . $cards->getHoverIcon->path }}"
                                                alt="...">
                                            <img class="icon_white" src="{{ asset('') . $cards->getIcon->path }}"
                                                alt="...">
                                        </div>
                                    </div>
                                    <div class="resources_items_right">
                                        <div class="resources_items_top">
                                            <p class="resources_items_type">
                                                @if ($cards->status == '1')
                                                    Public
                                                @else
                                                    Private
                                                @endif
                                            </p>
                                            <p class="resources_items_posted">
                                                @if ($cards->publish_date != null)
                                                    {{ Carbon\Carbon::parse($cards->publish_date)->format('M Y') }}
                                                @endif

                                            </p>
                                        </div>
                                        <h4 class="resources_items_title">{{ $cards->title }}</h4>
                                    </div>
                                    <div class="resources_items_overlay"></div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                    <div class="modal-header mx-auto" style="border-bottom: none;">
                        <h5 class="modal-title" id="exampleModalLongTitle">Not Accessible!</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body mx-auto">
                        Please login or become a member to access this page.
                    </div>
                    <div class="modal-footer mx-auto" style="border-top:none;">
                        <button type="button" class="btn btn-secondary" style="background-color: #02b0b5 " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
