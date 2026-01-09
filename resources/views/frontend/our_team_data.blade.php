@if (count($our_teams_list))
    @foreach ($our_teams_list as $list)
        @if ($list->getOurTeamListingContent != null)
            <a href="{{ route('frontend.our.team.details', ['uid' => $list->getOurTeamListingContent->uid, 'slug' => $list->getOurTeamListingContent->page_slug]) }}"
                class="col-sm-4 our_team_thumb_div">
                <div class="our_team_thumb_img">
                    @if ($list->getOurTeamListingContent->image_details != null)
                        <img src="{{ asset('') }}{{ $list->getOurTeamListingContent->image_details->path }}"
                            alt="...">
                    @else
                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}">
                    @endif
                </div>
                <div class="our_team_content">
                    <h3 class="our_team_name">{{ $list->getOurTeamListingContent->name }}</h3>
                    <span class="our_team_desg">{{ $list->getOurTeamListingContent->designation }}</span>
                </div>
            </a>
        @endif
    @endforeach
@endif
